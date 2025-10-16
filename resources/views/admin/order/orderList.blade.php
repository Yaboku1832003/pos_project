@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header & Filters -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h4 class="fw-bold text-primary d-flex align-items-center mb-0">
                <i class="fa-solid fa-clipboard-list me-2"></i> Orders
            </h4>

            <form method="GET" class="d-flex align-items-center flex-wrap gap-2" id="filterForm">
                <!-- Search Box -->
                <div class="input-group input-group-sm shadow-sm rounded">
                    <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control border-0"
                        placeholder="Search orders...">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <!-- Month Picker -->
                <div class="input-group input-group-sm shadow-sm rounded">
                    <input type="text" name="month" id="monthPicker" class="form-control border-0"
                        value="{{ request('month') ?? date('Y-m') }}" autocomplete="off" readonly>
                    <span class="input-group-text bg-white border-0"><i class="fa-solid fa-calendar-week"></i></span>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="card shadow-sm border-0 rounded">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0 rounded">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col" class="text-start">Order Code</th>
                                <th scope="col" class="text-center">User Name</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orderList as $items)
                                <tr class="align-middle shadow-sm rounded mb-1">
                                    <td>{{ $items->created_at->format('j-F-Y') }}</td>
                                    <td class="text-start">
                                        <span
                                            class="badge bg-light text-info orderCode">{{ $items->order_code }}</span>
                                    </td>
                                    <td class="text-center">{{ $items->name }}</td>
                                    <td class="text-center">
                                        @if ($items->status == 0)
                                            <span class="badge bg-warning bg-gradient text-dark px-3 py-2">
                                                <i class="fa-solid fa-spinner fa-spin me-1"></i>Pending
                                            </span>
                                        @elseif ($items->status == 1)
                                            <span class="badge bg-success bg-gradient px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>Accepted
                                            </span>
                                        @elseif ($items->status == 2)
                                            <span class="badge bg-danger bg-gradient px-3 py-2">
                                                <i class="fas fa-times-circle me-1"></i>Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin#orderDetails', $items->order_code) }}"
                                                class="btn btn-outline-info">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="#"
                                                class="btn confirm-order @if ($items->status != 0 || $items->stock < $items->count) btn-outline-secondary disabled @else btn-outline-success @endif">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                            <a href="#"
                                                class="btn reject-order @if ($items->status != 0) btn-outline-secondary disabled @else btn-outline-danger @endif">
                                                <i class="fa-solid fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fa-2x mb-2 d-block"></i>
                                        No orders found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $orderList->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

    <style>
        .table th:first-child {
            border-top-left-radius: 0.5rem;
        }

        .table th:last-child {
            border-top-right-radius: 0.5rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: 0.2s;
        }

        .badge {
            font-size: 0.9rem;
        }

        .btn-group-sm .btn {
            padding: 0.3rem 0.6rem;
        }

        .card {
            border-radius: 0.75rem;
        }

        .input-group {
            border-radius: 0.75rem;
            overflow: hidden;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Month picker
            flatpickr("#monthPicker", {
                plugins: [new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "Y-m",
                    altFormat: "F Y"
                })]
            });

            $(document).ready(function() {
                // Confirm order
                $('.confirm-order').click(function(e) {
                    e.preventDefault();
                    let orderCode = $(this).parents("tr").find('.orderCode').text();
                    $.ajax({
                        type: 'GET',
                        url: '/admin/order/confirm',
                        data: {
                            order_code: orderCode
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                location.reload();
                            }
                        },
                    });
                });

                // Reject order
                $('.reject-order').click(function(e) {
                    e.preventDefault();
                    let orderCode = $(this).parents("tr").find('.orderCode').text();
                    $.ajax({
                        type: 'GET',
                        url: '/admin/order/reject',
                        data: {
                            order_code: orderCode
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                location.reload();
                            }
                        },
                    });
                });
            });
        });
    </script>
@endpush
