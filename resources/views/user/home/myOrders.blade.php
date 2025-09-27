@extends('user.layouts.master')

@section('content')
    <div class="content-section" id="orderHistorySection">
    <div class="card p-3">
        @if ($orderList->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Order Code</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderList as $order)
                            <tr class="align-middle">
                                <td class="fw-medium">
                                    <a href="">
                                        {{ $order->order_code }}
                                    </a>
                                </td>
                                <td>{{ $order->created_at->format('F d, Y') }}</td>
                                <td>
                                    @if ($order->status == 1)
                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-success text-white shadow-sm">
                                            <i class="fas fa-check-circle me-2"></i>Accepted
                                        </span>
                                    @elseif ($order->status == 2)
                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-danger text-white shadow-sm">
                                            <i class="fas fa-times-circle me-2"></i>Rejected
                                        </span>
                                    @else
                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-warning text-white shadow-sm">
                                            <i class="fas fa-clock me-2"></i>Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination links -->
            <div class="d-flex justify-content-end mt-3">
                {{ $orderList->links() }}
            </div>

        @else
            <section class="section py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 text-center mx-auto">
                            <div class="p-5 bg-light rounded shadow-sm">
                                <div class="mb-4">
                                    <i class="fas fa-user-clock fa-4x text-secondary"></i>
                                </div>
                                <h4 class="mb-3 text-muted">No completed orders yet.</h4>
                                <p class="text-muted">
                                    You haven't completed any orders yet. <br>
                                    Your current order may still be pending, so please check the Pending Orders tab.
                                </p>
                                <a href="{{ route('user#homePage') }}" class="btn btn-primary mt-3">
                                    Browse Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
</div>

@endsection
