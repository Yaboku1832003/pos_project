@extends('user.layouts.master')

@section('content')
    <section class="section bg-light">
        <div class="container">
            {{-- Back to Cart Button --}}

            {{-- Order Summary + Payment Voucher --}}
            <div class="card shadow-sm border-0 mb-5 rounded-4 p-4">
                <div class="row align-items-start">
                    {{-- Left: Order Summary --}}
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <div class="mb-3">
                            <a href="{{ route('user#cart') }}" class="btn btn-outline-primary rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i> Back to Cart
                            </a>
                        </div>
                        <h5 class="fw-bold text-primary mb-3">Order Summary</h5>

                        <p class="mb-1">
                            <span class="fw-semibold">Status:</span>
                            @if ($order[0]->status == 0)
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order[0]->status == 1)
                                <span class="badge bg-success">Accepted</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>

                        <p class="mb-1"><span class="fw-semibold">Order Date:</span>
                            {{ $order[0]->created_at->format('F d, Y') }}</p>
                        <p class="mb-1"><span class="fw-semibold">Total:</span>
                            <span class="text-danger fw-bold">{{ $paymentHistory->final_total }} mmk</span>
                            (Delivery Fees Included)
                        </p>
                        <p class="mb-1"><span class="fw-semibold">Phone:</span> {{ $paymentHistory->phone }}</p>
                        <p class="mb-0"><span class="fw-semibold">Payment Type:</span> {{ $paymentHistory->payment_type }}
                        </p>
                    </div>

                    {{-- Right: Payment Voucher --}}
                    <div class="col-lg-5 text-center">
                        @if ($paymentHistory->payment_voucher)
                            <h6 class="fw-bold mb-3">Payment Voucher</h6>
                            <img src="{{ asset('payment_voucher/' . $paymentHistory->payment_voucher) }}"
                                class="img-fluid rounded shadow-sm mb-2"
                                style="max-width: 200px; height: auto; object-fit: cover;">
                        @else
                            <p class="text-muted fst-italic mt-4">No payment voucher uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Products Section (same as before) --}}
            <div class="row gy-3">
                @foreach ($order as $item)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="row g-0 align-items-center">
                                {{-- Image --}}
                                <div class="col-md-4 col-5">
                                    <div class="d-flex justify-content-center align-items-center rounded-circle overflow-hidden"
                                        style="width:120px; height:120px;">
                                        <img src="{{ asset('productImage/' . $item->image) }}"
                                            class="w-100 h-100 object-fit-cover" alt="{{ $item->product_name }}">
                                    </div>

                                </div>
                                {{-- Info --}}
                                <div class="col-md-8 col-7">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-2">{{ $item->product_name }}</h6>
                                        <p class="mb-1">Price: <span class="text-primary">{{ $item->sale_price }}
                                                mmk</span></p>
                                        <p class="mb-1">Quantity: {{ $item->order_count }}</p>
                                        <p class="mb-0 fw-semibold text-info">Subtotal:
                                            {{ $item->sale_price * $item->order_count }} mmk</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $order->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Card hover effect */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }
    </style>
@endpush
