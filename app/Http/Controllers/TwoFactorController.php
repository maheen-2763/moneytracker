<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    private Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    // ── Show QR code to setup 2FA ──────────
    public function setup()
    {
        $user   = Auth::user();
        $secret = $this->google2fa->generateSecretKey();

        // Store secret temporarily in session
        session(['2fa_setup_secret' => $secret]);

        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        // Generate QR code as SVG
        $qrCode = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );

        $writer    = new \BaconQrCode\Writer($qrCode);
        $qrCodeSvg = base64_encode($writer->writeString($qrCodeUrl));

        return view('profile.security', compact('secret', 'qrCodeSvg', 'user'));
    }

    // ── Verify OTP and enable 2FA ──────────
    public function enable(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $secret = session('2fa_setup_secret');

        $valid = $this->google2fa->verifyKey($secret, $request->otp);

        if (!$valid) {
            return back()->withErrors([
                'otp' => 'Invalid code. Please try again.',
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'two_factor_secret'       => encrypt($secret),
            'two_factor_enabled'      => true,
            'two_factor_confirmed_at' => now(),
        ]);

        session()->forget('2fa_setup_secret');

        return redirect()->route('profile.security')
            ->with('success', '2FA enabled successfully! ✅');
    }

    // ── Disable 2FA ────────────────────────
    public function disable(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'two_factor_secret'       => null,
            'two_factor_enabled'      => false,
            'two_factor_confirmed_at' => null,
        ]);

        return redirect()->route('profile.security')
            ->with('success', '2FA has been disabled.');
    }

    // ── Show OTP challenge page ────────────
    public function challenge()
    {
        // If 2FA not required, go to dashboard
        if (session('2fa_verified')) {
            return redirect()->route('dashboard');
        }

        return view('auth.two-factor');
    }

    // ── Verify OTP challenge ───────────────
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $secret = decrypt($user->two_factor_secret);

        $valid = $this->google2fa->verifyKey($secret, $request->otp);

        if (!$valid) {
            return back()->withErrors([
                'otp' => 'Invalid code. Please try again.',
            ]);
        }

        session(['2fa_verified' => true]);

        return redirect()->intended(route('dashboard'));
    }
}
