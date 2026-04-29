<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'NotoSans';
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/NotoSans-Regular.ttf') }}");
        }

        body {
            font-family: 'NotoSans', sans-serif;
            font-size: 12px;
            color: #1e293b;
        }

        /* ── Header ── */
        .header {
            background: #18e268;
            color: white;
            padding: 20px 24px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            font-weight: bold;
        }

        .header p {
            font-size: 11px;
            opacity: 0.85;
            margin-top: 4px;
        }

        /* ── Summary cards ── */
        .summary {
            display: flex;
            gap: 12px;
            margin: 0 24px 20px;
        }

        .card {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
        }

        .card .label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
        }

        .card .value {
            font-size: 16px;
            font-weight: bold;
            color: #6366f1;
            margin-top: 4px;
        }

        /* ── Table ── */
        table {
            width: calc(100% - 48px);
            margin: 0 24px;
            border-collapse: collapse;
        }

        thead tr {
            background: #f1f5f9;
        }

        th {
            padding: 9px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 11.5px;
        }

        tr:nth-child(even) td {
            background: #f8fafc;
        }

        .amount {
            font-weight: 600;
            color: #dc2626;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 24px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h1>MoneyTracker — Expense Report</h1>
        <p>Generated on {{ now()->format('d M Y, h:i A') }}
            @if ($filters['start_date'] ?? null)
                &nbsp;·&nbsp; From: {{ $filters['start_date'] }} To: {{ $filters['end_date'] ?? 'now' }}
            @endif
        </p>
    </div>

    {{-- Summary cards --}}
    <div class="summary">
        <div class="card">
            <div class="label">Total Expenses</div>
            <div class="value">{{ $expenses->count() }}</div>
        </div>
        <div class="card">
            <div class="label">Total Amount</div>
            <div class="value">Rs.{{ number_format($expenses->sum('amount'), 2) }}</div>
        </div>
        <div class="card">
            <div class="label">Highest</div>
            <div class="value">Rs.{{ number_format($expenses->max('amount'), 2) }}</div>
        </div>
        <div class="card">
            <div class="label">Average</div>
            <div class="value">Rs.{{ number_format($expenses->avg('amount'), 2) }}</div>
        </div>
    </div>

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $i => $expense)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $expense->title }}</td>
                    <td>{{ ucfirst($expense->category) }}</td>
                    <td class="amount">Rs.{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#94a3b8; padding: 20px;">
                        No expenses found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">MoneyTracker · Exported by {{ auth()->user()->name }}</div>

</body>

</html>
