@extends('user.layouts.master')

@section('content')
    <section class="section bg-light">
        <div class="container">
            {{-- Order Summary Card --}}
            <div class="card shadow-sm border-0 mb-5 rounded-4">
                {{-- Back to Home Button --}}
                <div class="mt-4 ml-4">
                    <button onclick="window.location.href='{{ route('user#homePage') }}'" class="btn btn-outline-primary rounded-pill btn-sm">
                         <i class="fas fa-arrow-left me-2"></i> Back to Home
                    </button>
                    {{-- <a href="{{ route('user#homePage') }}" class="btn btn-outline-primary rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i> Back to Home
                    </a> --}}
                </div>
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                    <div>
                        <h5 class="fw-bold text-primary">Order Summary</h5>
                        <p class="mb-1"><span class="fw-semibold">Status:</span>
                            @if($order[0]->status == 0)
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order[0]->status == 1)
                                <span class="badge bg-success">Accepted</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>
                        <p class="mb-1"><span class="fw-semibold">Order Date:</span> {{ $order[0]->created_at->format('F d, Y') }}</p>
                        <p class="mb-1"><span class="fw-semibold">Total:</span> <span class="text-danger fw-bold">{{ $paymentHistory->final_total }} mmk </span>(Delivery Fees Included)</p>
                    </div>
                    <div>
                        <p class="mb-1"><span class="fw-semibold">Phone:</span> {{ $paymentHistory->phone }}</p>
                        <p class="mb-0"><span class="fw-semibold">Payment Type:</span> {{ $paymentHistory->payment_type }}</p>
                    </div>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="row g-4">
                @foreach($order as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="ratio ratio-1x1">
                                <img src="{{ asset('productImage/'.$item->image) }}"
                                    class="card-img-top rounded-top-4"
                                    style="object-fit: cover; width: 100%; height: 100%;"
                                    alt="{{ $item->product_name }}">
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h6 class="card-title fw-bold">{{ $item->product_name }}</h6>
                                <p class="mb-1">Price: <span class="text-primary">{{ $item->sale_price }} mmk</span></p>
                                <p class="mb-1">Quantity: {{ $item->order_count }}</p>
                                <p class="mb-0 fw-semibold text-info">Subtotal: {{ $item->sale_price * $item->order_count }} mmk</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $order->links('pagination::bootstrap-5') }}
                </div>
            </div>

            {{-- Optional Payment Voucher --}}
            @if($paymentHistory->payment_voucher)
                <div class="mt-5 text-center">
                    <h5 class="mb-3">Payment Voucher</h5>
                    <a href="{{ asset('payment_voucher/'.$paymentHistory->payment_voucher) }}" target="_blank">
                        <img src="{{ asset('payment_voucher/'.$paymentHistory->payment_voucher) }}"
                             class="img-thumbnail shadow-sm"
                             style="max-width: 300px; height:auto; object-fit:cover;">
                    </a>
                    <div class="mt-2">
                        <a href="{{ asset('payment_voucher/'.$paymentHistory->payment_voucher) }}" download class="btn btn-primary rounded-pill px-4 mt-2">
                            Download
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection

@push('styles')
<style>
    /* Card hover effect */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush


