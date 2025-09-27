@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">

    <!-- Back Button -->
    <a href="javascript:history.back()" class="text-decoration-none text-secondary mb-3 d-inline-block">
        <i class="fa-solid fa-arrow-left-long me-2"></i> Back to Orders
    </a>

    <!-- Order Summary -->
    <div class="row g-4 mb-4">
        <!-- Customer Card -->
        <div class="col-md-6 d-flex">
            <div class="card order-card shadow-sm border-0 flex-fill">
                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-user me-2"></i> Customer Information
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><span class="fw-semibold">Name:</span> {{$order[0]->user_name}}</li>
                        <li class="mb-3"><span class="fw-semibold">Phone:</span> {{$order[0]->phone}}</li>
                        <li class="mb-3"><span class="fw-semibold">Address:</span> {{$paymentHistory->address}}</li>
                        <li class="mb-3"><span class="fw-semibold">Order Code: </span>
                            <span class="text-info" id="order_code">{{$order[0]->order_code}}</span>
                        </li>
                        <li class="mb-3"><span class="fw-semibold">Order Date: </span>{{$order[0]->created_at->format('j F Y')}}</li>
                        <li class="mb-3"><span class="fw-semibold">Total:</span>
                            <span class="text-danger fw-bold">{{$paymentHistory->final_total}}</span>
                            <small class="text-danger d-block">(Including Delivery)</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Payment Card -->
        <div class="col-md-6 d-flex">
            <div class="card order-card shadow-sm border-0 flex-fill">
                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-credit-card me-2"></i> Payment Information
                    </h6>
                    <ul class="list-unstyled mb-3">
                        <li class=""><span class="fw-semibold text-info">Contact Phone:</span> {{$paymentHistory->phone}}</li>
                        <li><span class="text-primary">Payment Method:</span> {{$paymentHistory->payment_type}}</li>
                        <li><span class="fw-semibold text-info">Purchase Date: </span>{{$paymentHistory->created_at->format('j F Y')}}</li>
                    </ul>
                    <img src="{{ asset('payment_voucher/'.$paymentHistory->payment_voucher) }}"
                        alt="Payment Slip"
                        class="img-thumbnail shadow-sm hover-zoom"
                        style="width: 150px; height: 300px; object-fit:cover; cursor:pointer;"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content shadow border-0 rounded-4">
                <div class="modal-header border-0 bg-primary text-white rounded-top-4">
                    <h5 class="modal-title" id="staticBackdropLabel">Payment Voucher</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <img src="{{ asset('payment_voucher/'.$paymentHistory->payment_voucher) }}" class="img-fluid rounded shadow-sm" alt="Payment Voucher">
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">Close</button>
                    <a href="{{ asset('payment_voucher/'.$paymentHistory->payment_voucher) }}" download class="btn btn-primary rounded-pill px-4 shadow-sm">Download</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="row">
        <div class="col">
            <table class="table table-hover shadow-sm">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>Product</th>
                        <th class="">Order Count</th>
                        <th class="">Available Stock</th>
                        <th class="">Price</th>
                        <th class="">Total</th>
                        <th class="">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order as $items)

                    <tr>
                        <input type="hidden" class="productId" value="{{$items->product_id}}">
                        <input type="hidden" class="count" value="{{$items->order_count}}">

                        <td class="d-flex align-items-center">
                            <img src="{{ asset('productImage/'.$items->image) }}"
                                class="rounded shadow-sm me-3"
                                style="width: 75px; height: 75px; object-fit:cover;" alt="">
                            <div>
                                <div class="fw-semibold" style="font-size: 20px;">{{ $items->product_name }}</div>
                                <small class="text-muted">SKU-{{ $items->product_id }}</small>
                            </div>
                        </td>
                        <td class="">
                            {{ $items->order_count }}
                            @if ($items->order_count > $items->stock)
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td class="">{{ $items->stock }}</td>
                        <td class="">{{ $items->sale_price }}</td>
                        <td class="text-info fw-semibold">{{ $items->sale_price * $items->order_count }}</td>
                        <td class="text-muted">{{ $items->created_at->format('Y M d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- pagination --}}
            <div class="mt-2 d-flex justify-content-end me-3">
                {{$order->links()}}
            </div>

        </div>
    </div>

    <div class="row my-3">
        <div class="col text-end">
            <button type="button" class="btn btn-md shadow-sm me-4  text-white  @if ($status) bg-success @else bg-secondary disabled  @endif" id="btn-order-confirm">Confirm</button>
            <button type="button" class="btn btn-md shadow-sm text-white  bg-danger " id="btn-order-reject">Reject</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Card hover */
    .order-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }
    .table th:first-child {
        border-top-left-radius: 0.5rem;
    }
    .table th:last-child {
        border-top-right-radius: 0.5rem;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
    /* Image hover zoom */
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function ()
{ // Example JS for confirmation actions
$('#btn-order-confirm').click(function(){
    orderCode = $('#order_code').text();
    orderList = []
    $('.table tbody tr').each(function(index,row){
        productId= $(row).find('.productId').val();
        count= $(row).find('.count').val();

        orderList.push({
            'product_id' : productId,
            'count' : count,
            'order_code' : orderCode
        })
    })
    $.ajax({
        type : 'get',
        url : '/admin/order/confirm',
        data : Object.assign({},orderList),
        dataType : 'json',
        success : function($response){
            $response.status == 'success' ? window.location.href = document.referrer : '';
        }
    })

})

$('#btn-order-reject').click(function(){
    orderCode = $('#order_code').text();

    $.ajax({
        type : 'get',
        url : '/admin/order/reject',
        data : {'order_code' : orderCode},
        dataType : 'json',
        success : function($response){
            $response.status == 'success' ? window.location.href = document.referrer : '';
        }
    })

})
});

</script>
@endpush
