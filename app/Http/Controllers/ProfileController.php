<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    // Show edit form
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    // Update profile info + avatar
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone'  => ['nullable', 'string', 'max:20'],
            'bio'    => ['nullable', 'string', 'max:200'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bio   = $request->bio;
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    // Update password separately
    public function updatePassword(Request $request)
    {

        /** @var User $user */   // ← add this like you did in update()
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);


        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }

    // Remove avatar — revert to letter avatar
    public function removeAvatar()
    {
       /** @var User $user */  
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Avatar removed.');
    }
}
