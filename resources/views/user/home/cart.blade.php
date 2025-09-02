@extends('user.layouts.master')

@section('content')

    <section class="section bg-gray">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                {{-- profile and 4 Lists start --}}
                <div class="col-lg-3">
                    <div class="sidebar">
                        <!-- User Widget -->
                        <div class="widget user-dashboard-profile">
                            <!-- User Image -->
                            <div class="profile-thumb">
                                <img src="@if ($profile->profile != null) {{ asset('profileImage/' . $profile->profile) }}
                                @else {{ asset('default/default-profile.png') }} @endif"
                                    style="width:150px; height:150px; object-fit:cover;" class="rounded-circle">
                            </div>
                            <!-- User Name -->
                            <h5 class="text-center">{{ $profile->name }}</h5>
                            <p>Joined on {{ $profile->created_at->format('F d,Y') }}</p>
                        </div>
                        <!-- Dashboard Links -->
                        <div class="widget user-dashboard-menu">
                            <ul>
                                <li class="active" data-target="#cartSection">
                                    <a href=""><i class="fa-solid fa-cart-shopping"> </i>My Cart</a>

                                </li>
                                {{-- split order by status start --}}
                                @php
                                    $pendingOrders = $orderHistory->where('status', 0);
                                    $otherOrders   = $orderHistory->whereIn('status', [1, 2]);
                                @endphp
                                {{-- split order by status end --}}
                                <li data-target="#pendingOrderSection">
                                    <a href=""><i class="fa-solid fa-spinner"></i> Pending
                                        Orders<span>{{$pendingOrders->count()}}</span></a>
                                </li>
                                <li data-target="#orderHistorySection">
                                    <a href="#"><i class="fa-solid fa-clock-rotate-left"></i>
                                        Orders History<span>{{$otherOrders->count()}}</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('user#homePage') }}"><i class="fas fa-home  fs-5 mt-1"></i> Back</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- profile and 4 Lists end --}}

                {{-- My Cart data start --}}
                <div class="col-lg-9">
                    <div class="content-section" id="cartSection">
                            <div class="card">
                                <div class="card-header fs-3">My Cart</div>
                                @if ($cartData->count() > 0)
                                    <div class="table-responsive">
                                            <table class="table w-100" id="productTable">
                                                <thead>

                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Name</th>
                                                        <th>Price</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cartData as $data)
                                                        <tr>
                                                            <td class="p-3">
                                                                <img src="{{ asset('productImage/' . $data->image) }}"
                                                                    style="width:100px; height:100px; object-fit:cover;"
                                                                    class="rounded-circle">
                                                            </td>
                                                            <td class="p-3">
                                                                <h6 class="title">{{ $data->name }}</h6>
                                                            </td>
                                                            <td class="p-3">
                                                                <span class="text-muted price">{{ $data->sale_price }} mmk</span>
                                                            </td>
                                                            <td class="p-3">
                                                                {{-- Quantity + - start --}}
                                                                <span
                                                                    class="text-danger @if ($data->stock > 5) text-muted @endif"
                                                                    style="font-size: 10px;">Stock: {{ $data->stock }} item(s)
                                                                    left</span>
                                                                @csrf
                                                                <div class="d-flex justify-content-evenly align-items-center mt-3"
                                                                    style="max-width: 120px;">
                                                                    <button type="submit"
                                                                        class="btn btn-outline-primary rounded-pill p-0 btn-minus"
                                                                        value="minus" name="action"
                                                                        style="width: 25px; height:25px;">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
                                                                    <input type="" name="quantity"
                                                                        data-stock="{{ $data->stock }}"
                                                                        class="form-control text-center border-0 quantity"
                                                                        value="{{ $data->qty }}" min="1"
                                                                        style="width:50px; height:25px;">
                                                                    <button type="submit"
                                                                        class="btn btn-outline-primary rounded-pill p-0 btn-plus"
                                                                        value="plus" name="action"
                                                                        style="width: 25px; height:25px;">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                                {{-- Quantity + - end --}}
                                                            </td>
                                                            <td class="p-3 text-muted total">{{ $data->sale_price * $data->qty }}
                                                                mmk</td>
                                                            <td class="d-flex justify-content-center align-content-center">
                                                                <button style="width: 40px; height: 40px;" title="Delete"
                                                                    class="btn btn-outline-danger rounded-circle btn-delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="cartId" value="{{ $data->cart_id }}">
                                                                <input type="hidden" class="userId"
                                                                    value="{{ Auth::user()->id }}">
                                                                <input type="hidden" class="productId"
                                                                    value="{{ $data->product_id }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                @else
                                    <section class="section">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6 text-center mx-auto">
                                                    <h4>Empty Cart</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endif
                                <!-- Cart Save Modal -->
                                <div class="modal fade" id="cartSaveModal" tabindex="-1" aria-labelledby="cartSaveModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Unsaved Changes</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Do you want to save them before leaving?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" id="discardBtn"
                                                    data-bs-dismiss="modal">Discard</button>
                                                <button type="button" class="btn btn-primary" id="saveBtn">Save
                                                    Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="card mt-4" style="width: 300px;">
                                    <div class="card-body">
                                        <h5 class="card-title">Cart Summary</h5>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Subtotal:</span>
                                                <span id="subTotal">{{ $totalPrice }} mmk</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Delivery Fee:</span>
                                                <span>@if ($cartData->count()>0)
                                                    5000 mmk
                                                    @else
                                                         ----
                                                    @endif
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Total:</span>
                                                <span id="finalTotal">
                                                    @if ($cartData->count()>0)
                                                        {{ $totalPrice + 5000 }} mmk
                                                    @else
                                                        ----
                                                    @endif
                                                </span>
                                            </li>
                                        </ul>
                                        <div class="mt-3 text-end">
                                            <button id="btnCheckout" class="btn btn-success"
                                                @if ($cartData->count() == 0) disabled @endif>
                                                Checkout
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="content-section d-none" id="pendingOrderSection">
                        <div class="card">
                            @if ($pendingOrders->count()>0)
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
                                        @foreach ($pendingOrders as $items )
                                            <tr class="align-middle">
                                                <td class="fw-medium">{{$items->order_code}}</td>
                                                <td>{{ $items->created_at->format('F d, Y - h:i A') }}</td>
                                                <td>
                                                    @if ($items->status == 0)
                                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill text-dark bg-warning shadow-sm">
                                                            <i class="fa-solid fa-spinner fa-spin me-2"></i>Pending
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                                                    <h4 class="mb-3 text-muted">No pending orders at the moment.</h4>
                                                    <p class="text-muted">You currently have no orders waiting for processing. Once you place an order, it will appear here with its status.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endif
                        </div>
                    </div>
                    <div class="content-section d-none" id="orderHistorySection">
                        <div class="card">
                            @if ($otherOrders->count() > 0)
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
                                            @foreach ($otherOrders as $items)
                                                <tr class="align-middle">
                                                    <td class="fw-medium">{{ $items->order_code }}</td>
                                                    <td>{{ $items->created_at->format('F d, Y - h:i A') }}</td>
                                                    <td>
                                                        @if ($items->status == 1)
                                                            <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-success text-white shadow-sm">
                                                                <i class="fas fa-check-circle me-2"></i>Accepted
                                                            </span>
                                                        @elseif ($items->status == 2)
                                                            <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-danger text-white shadow-sm">
                                                                <i class="fas fa-times-circle me-2"></i>Rejected
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                </div>

                {{-- My Cart data end --}}
            </div>
        </div>
    </section>
    <!-- Container End -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let cartUpdated = false;
            let pendingUrl = null;


            function countCalculation(button) {
                let parentNode = button.closest("tr");
                let price = parentNode.find(".price").text().replace("mmk", "");
                let qty = parseInt(parentNode.find(".quantity").val());
                parentNode.find(".total").text((price * qty) + " mmk");
            }

            function subTotalCalculation() {
                let total = 0;
                $("#productTable tbody tr").each(function(index, item) {
                    // console.log($item);
                    total += Number($(item).find(".total").text().replace("mmk", ""));
                })
                $("#subTotal").html(`${total} mmk`)
                $("#finalTotal").html(`${total+5000} mmk`)
            }

            $('.btn-minus').click(function() {
                let row = $(this).closest('tr');
                let input = row.find('.quantity');
                let current = parseInt(input.val());
                if (current > 1) {
                    input.val(current - 1);
                    countCalculation($(this));
                    subTotalCalculation();
                    cartUpdated = true;
                }
            });

            $('.btn-plus').click(function() {
                let row = $(this).closest('tr');
                let input = row.find('.quantity');
                let stock = parseInt(input.data('stock')); // get stock value
                let current = parseInt(input.val());
                if (current < stock) {
                    input.val(current + 1);
                    countCalculation($(this));
                    subTotalCalculation();
                    cartUpdated = true;
                }
            });

            $(".btn-delete").click(function() {
                let parentNode = $(this).closest("tr");
                cartId = parentNode.find(".cartId").val();

                deleteData = {
                    'cartId': cartId
                }

                $.ajax({
                    type: 'get',
                    url: '/user/cart/delete',
                    data: deleteData,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        response.status == 'success' ? location.reload() : '';
                    }
                })
            })

             $('a').not('.user-dashboard-menu li a').click(function(e) {
                let url = $(this).attr('href');
                if (cartUpdated) {
                    e.preventDefault();
                    pendingUrl = url;
                    $('#cartSaveModal').modal('show');
                }
            });

            // Save changes
            $('#saveBtn').click(function() {
                let cartUpdates = [];
                $("#productTable tbody tr").each(function(index, item) {
                    let cartId = $(item).find('.cartId').val();
                    let quantity = $(item).find('.quantity').val();
                    cartUpdates.push({
                        cartId,
                        quantity
                    });
                });

                updateData = {
                    'data': cartUpdates,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }

                $.ajax({
                    url: '/user/cart/update',
                    type: 'POST',
                    data: updateData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            cartUpdated = false;
                            $('#cartSaveModal').modal('hide');
                            if (pendingUrl) window.location.href = pendingUrl;
                        }
                    }
                });
            });

            // Discard changes
            $('#discardBtn').click(function() {
                cartUpdated = false;
                $('#cartSaveModal').modal('hide');
                if (pendingUrl) window.location.href = pendingUrl;
            });

            //checkOut
            $('#btnCheckout').click(function() {
                orderList = [];
                userId = $('.userId').val();
                orderCode = "ZWY-POS-ORDER-" + Math.floor(Math.random() * 10000000000);
                // console.log(userId, orderCode);

                $("#productTable tbody tr").each(function(index, row) {
                    productId = $(row).find('.productId').val();
                    qty = $(row).find('.quantity').val();
                    cartId = $(row).find('.cartId').val();
                    subTotal = $('#subTotal').text().replace("mmk", "");
                    // console.log(subTotal);

                    // array.push -> push object into array
                    orderList.push({
                        'product_id': productId,
                        'user_id': userId,
                        'count': qty,
                        'status': 0,
                        'order_code': orderCode,
                        'subTotal': subTotal
                    });
                })
                // console.log(orderList);
                $.ajax({
                    url: '/user/cart/tempStorage',
                    type: 'get',
                    data: Object.assign({},
                    orderList), //orderList = []; is array and we wanna send objects so we have to make them object assign
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        response.status == 'success' ? location.href =
                            '/user/cart/paymentPage' : location.reload();
                    }
                });
            });

            //user menu
            $('.user-dashboard-menu li').click(function(e){
                // If this is the last li (Back button), allow normal navigation
                if ($(this).is(':last-child')) {
                    return; // do nothing, follow the link
                }
                e.preventDefault();

                // Switch active state
                $('.user-dashboard-menu li').removeClass('active');
                $(this).addClass('active');

                // Hide all sections
                $('.content-section').addClass('d-none');

                // Show selected section
                let target = $(this).data('target');
                $(target).removeClass('d-none');
            });

        });
    </script>
@endsection
