@extends('admin.layouts.master')

@section('content')
<div class="container-fluid py-4">

    <!-- Search & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">
            <i class="fa-solid fa-clipboard-list me-2"></i> Orders
        </h4>
        <form action="" method="get" class="d-flex">
            <div class="input-group">
                <input type="text" name="searchKey" value="" class="form-control"
                    placeholder="Search orders...">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
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
                        @if ($orderList->count()>0)
                            @foreach ($orderList as $items)
                                <tr>
                                    <td>{{$items->created_at->format('j-F-Y')}}</td>
                                    <td class="text-start"><span class="badge bg-light text-info">{{$items->order_code}}</span></td>
                                    <td class="text-center">{{$items->name}}</td>
                                    <td class="text-center">
                                        @if ($items->status == 0)
                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill text-dark bg-warning shadow-sm">
                                            <i class="fa-solid fa-spinner fa-spin"></i>Pending
                                        </span>
                                        @elseif ($items->status == 1)
                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-success text-white shadow-sm">
                                            <i class="fas fa-check-circle"></i>Accepted
                                        </span>
                                        @elseif ($items->status == 2)
                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-danger text-white shadow-sm">
                                            <i class="fas fa-times-circle"></i>Rejected
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{route('admin#orderDetails',$items->order_code)}}" class="btn btn-sm btn-outline-info">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm confirm-order  @if ($items->status != 0 || $items->stock < $items->count) btn-outline-secondary disabled @else btn-outline-success @endif"
                                                data-order_code ="{{ $items->order_code }}">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                            <a href="#"  class="btn btn-sm reject-order  @if ($items->status != 0) btn-outline-secondary disabled @else btn-outline-danger @endif "
                                                data-order_code ="{{ $items->order_code }}">
                                                <i class="fa-solid fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        {{-- Empty state --}}
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fa-2x mb-2 d-block"></i>
                                No orders found
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                {{-- pagination --}}
                <div class="mt-2 d-flex justify-content-end me-3">
                    {{$orderList->links()}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
    <style>
        .table th:first-child {
        border-top-left-radius: 0.5rem;
    }
    .table th:last-child {
        border-top-right-radius: 0.5rem;
    }
    </style>
@endpush

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function ()
{
    $(document).ready(function () {

    // Confirm order
    $('.confirm-order').click(function(e){
        e.preventDefault();
        var orderCode = $(this).data('order_code');

        $.ajax({
            type: 'GET',
            url: '/admin/order/confirm',
            data: { order_code: orderCode },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success'){
                    location.reload();
                }
            },
        });
    });

    // Reject order
    $('.reject-order').click(function(e){
        e.preventDefault();
        var orderCode = $(this).data('order_code');

        $.ajax({
            type: 'GET',
            url: '/admin/order/reject',
            data: { order_code: orderCode },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success'){
                    location.reload();
                }
            },
        });
    });

});

});

</script>
@endpush
