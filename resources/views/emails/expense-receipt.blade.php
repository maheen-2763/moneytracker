@extends('emails.layouts.base')

@section('content')
    @php
        $catEmojis = [
            'food' => '🍔',
            'travel' => '✈️',
            'health' => '💊',
            'office' => '💼',
            'other' => '📦',
        ];
        $emoji = $catEmojis[$expense->category] ?? '📦';
    @endphp

    <div class="email-title">Expense Recorded 🧾</div>
    <div class="email-subtitle">
        Hi {{ $user->name }}, your expense has been
        successfully recorded.
    </div>

    {{-- Receipt card --}}
    <div
        style="background:#f8fafc; border:1px solid #e2e8f0;
            border-radius:14px; padding:1.5rem; margin:1.25rem 0;">

        <div style="text-align:center; margin-bottom:1.25rem;">
            <div style="font-size:2.5rem;">{{ $emoji }}</div>
            <div
                style="font-size:1.6rem; font-weight:800;
                    letter-spacing:-0.03em; color:#ef4444; margin-top:.5rem;">
                ₹{{ number_format($expense->amount, 2) }}
            </div>
            <div style="font-size:.875rem; font-weight:600; color:#0f172a;">
                {{ $expense->title }}
            </div>
        </div>

        <hr style="border:none; border-top:1px solid #e2e8f0; margin:1rem 0;">

        <table style="width:100%; font-size:.82rem;">
            <tr>
                <td style="color:#94a3b8; padding:.35rem 0;">Category</td>
                <td
                    style="text-align:right; font-weight:600;
                       color:#0f172a; text-transform:capitalize;">
                    {{ $expense->category }}
                </td>
            </tr>
            <tr>
                <td style="color:#94a3b8; padding:.35rem 0;">Date</td>
                <td style="text-align:right; font-weight:600; color:#0f172a;">
                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                </td>
            </tr>
            @if ($expense->description)
                <tr>
                    <td style="color:#94a3b8; padding:.35rem 0;">Notes</td>
                    <td style="text-align:right; font-weight:600;
                       color:#0f172a;">
                        {{ $expense->description }}
                    </td>
                </tr>
            @endif
            <tr>
                <td style="color:#94a3b8; padding:.35rem 0;">
                    Recorded at
                </td>
                <td style="text-align:right; font-weight:600; color:#0f172a;">
                    {{ $expense->created_at->format('d M Y, h:i A') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="alert-box success">
        <span class="alert-icon">💡</span>
        <div class="alert-text">
            <strong>Track your spending</strong>
            Visit your dashboard to see how this expense
            affects your monthly budget.
        </div>
    </div>

    <hr class="divider">

    <div style="text-align:center;">
        <a href="{{ url('/expenses') }}" class="email-btn">
            View All Expenses →
        </a>
    </div>
@endsection
