@extends('layouts.app')
@section('title', 'Budgets')

@section('content')

    <div class="page-heading">
        <h4>🏷️ Budget Limits</h4>
        <small>Set monthly spending limits per category</small>
    </div>

    {{-- ── Add Budget Form ── --}}
    <div class="filter-card mb-4">
        <form method="POST" action="{{ route('budgets.store') }}" class="row g-3 align-items-end">
            @csrf

            <div class="col-md-5">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">Select category...</option>

                    {{-- Unbudgeted categories --}}
                    @forelse($unbudgeted as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @empty
                        <option disabled>All categories have budgets set ✅</option>
                    @endforelse

                    {{-- Divider + allow updating existing --}}
                    @if ($budgets->count() > 0)
                        <optgroup label="── Update existing ──">
                            @foreach ($budgets as $b)
                                <option value="{{ $b->category }}">
                                    {{ ucfirst($b->category) }} (update)
                                </option>
                            @endforeach
                        </optgroup>
                    @endif

                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Monthly Limit (₹)</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input type="number" name="amount" step="0.01" min="1" class="form-control"
                        placeholder="e.g. 5000" required>
                </div>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-lg me-1"></i> Set Budget
                </button>
            </div>

        </form>
    </div>

    {{-- ── Budget Cards ── --}}
    @if ($budgets->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="bi bi-piggy-bank fs-2 d-block mb-2"></i>
            No budgets set yet. Add one above!
        </div>
    @else
        <div class="row g-3">
            @foreach ($budgets as $budget)
                @php
                    $spent = $budget->spentThisMonth();
                    $pct = $budget->percentUsed();
                    $status = $budget->status();
                    $remaining = max(0, $budget->amount - $spent);
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="budget-card">

                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <div class="budget-category">{{ ucfirst($budget->category) }}</div>
                                <div class="budget-period">This month</div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button class="dropdown-item"
                                            onclick="openEditModal({{ $budget->id }}, '{{ ucfirst($budget->category) }}', {{ $budget->amount }})">
                                            <i class="bi bi-pencil me-2"></i> Edit Limit
                                        </button>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('budgets.destroy', $budget) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Remove this budget?')">
                                                <i class="bi bi-trash me-2"></i> Remove
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Progress bar --}}
                        <div class="budget-progress-wrap">
                            <div class="budget-progress-bar bg-{{ $status }}" style="width: {{ $pct }}%">
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div class="d-flex justify-content-between mt-2">
                            <div class="budget-stat">
                                <div class="budget-stat-val text-{{ $status }}">
                                    ₹{{ number_format($spent, 0) }}
                                </div>
                                <div class="budget-stat-label">Spent</div>
                            </div>
                            <div class="budget-stat text-center">
                                <div class="budget-stat-val">{{ $pct }}%</div>
                                <div class="budget-stat-label">Used</div>
                            </div>
                            <div class="budget-stat text-end">
                                <div class="budget-stat-val">
                                    ₹{{ number_format($budget->amount, 0) }}
                                </div>
                                <div class="budget-stat-label">Limit</div>
                            </div>
                        </div>

                        {{-- Warning banner --}}
                        @if ($pct >= 100)
                            <div class="budget-alert danger">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Over budget by ₹{{ number_format($spent - $budget->amount, 0) }}!
                            </div>
                        @elseif($pct >= 80)
                            <div class="budget-alert warning">
                                <i class="bi bi-exclamation-circle-fill me-1"></i>
                                Only ₹{{ number_format($remaining, 0) }} remaining!
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ── Edit Modal ── --}}
    <div class="modal fade" id="editBudgetModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h6 class="modal-title fw-bold">Edit Budget</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="editBudgetForm">
                    @csrf @method('PUT')
                    <div class="modal-body pt-0">
                        <label class="form-label fw-semibold">
                            Category: <span id="modalCategory" class="text-primary"></span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="amount" id="modalAmount" class="form-control" step="0.01"
                                min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openEditModal(id, category, amount) {
                document.getElementById('editBudgetForm').action = `/budgets/${id}`;
                document.getElementById('modalCategory').textContent = category;
                document.getElementById('modalAmount').value = amount;
                new bootstrap.Modal(document.getElementById('editBudgetModal')).show();
            }
        </script>
    @endpush

@endsection
