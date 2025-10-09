@extends('user.layouts.master')

@section('content')
@php
    $activeTab = request('tab', 'cartSection'); // default to cartSection
@endphp

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
                                <li class="{{ $activeTab == 'cartSection' ? 'active' : '' }}" data-target="#cartSection">
                                    <a href=""><i class="fa-solid fa-cart-shopping"> </i>My Cart</a>
                                </li>
                                {{-- split order by status start --}}
                                <li class="{{ $activeTab == 'pendingOrderSection' ? 'active' : '' }}" data-target="#pendingOrderSection">
                                    <a href=""><i class="fa-solid fa-spinner"></i> Pending
                                        Orders<span>{{$pendingOrders->total()}}</span></a>
                                </li>
                                <li class="{{ $activeTab == 'orderHistorySection' ? 'active' : '' }}" data-target="#orderHistorySection">
                                    <a href="#"><i class="fa-solid fa-clock-rotate-left"></i>
                                        Orders History<span>{{$otherOrders->total()}}</span></a>
                                </li>
                                {{-- split order by status end --}}
                                <li>
                                    <a href="{{ route('user#homePage') }}">
                                        <i class="fas fa-home fs-5 mt-1 me-2"></i> Back
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- profile and 4 Lists end --}}

                {{-- My Cart data start --}}
                <div class="col-lg-9">
                    <div class="content-section {{ $activeTab != 'cartSection' ? 'd-none' : '' }}" id="cartSection">
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
                                <!-- Cart Save Modal Start-->
                                <div class="modal fade" id="cartSaveModal" tabindex="-1" aria-labelledby="cartSaveModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm"> <!-- smaller, centered modal -->
                                        <div class="modal-content shadow-lg border-0 rounded-4">
                                        <!-- Header -->
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold text-danger">
                                            <i class="fas fa-exclamation-circle me-2 text-primary"></i> Unsaved Changes
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body text-center">
                                            <p class="fs-6 text-muted mb-3">
                                            You’ve made changes to your cart.
                                            Do you want to save them before leaving?
                                            </p>
                                            <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                                        </div>

                                        <!-- Footer -->
                                        <div class="modal-footer border-0 d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-danger border rounded-pill px-4" id="discardBtn" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i> Discard
                                            </button>
                                            <button type="button" class="btn btn-primary rounded-pill px-4" id="saveBtn">
                                            <i class="fas fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Cart Save Modal End --}}
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

                    <div class="content-section {{ $activeTab != 'pendingOrderSection' ? 'd-none' : '' }}" id="pendingOrderSection">
                        <div class="card">
                            @if ($pendingOrders->total()>0)
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
                                                <td class="fw-medium">
                                                    <a href="{{route('user#orderDetails',$items->order_code)}}" class="badge bg-light text-info orderCode">
                                                        {{$items->order_code}}
                                                    </a>
                                                </td>
                                                <td>{{ $items->created_at->format('F d, Y') }}</td>
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
                                {{-- Pagination --}}
                                {{ $pendingOrders->appends(['tab' => 'pendingOrderSection'])->links() }}
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
                    <div class="content-section {{ $activeTab != 'orderHistorySection' ? 'd-none' : '' }}" id="orderHistorySection">
                        <div class="card">
                            @if ($otherOrders->total() > 0)
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
                                                    <td class="fw-medium">
                                                        <a href="{{route('user#orderDetails',$items->order_code)}}" class="badge bg-light text-info orderCode">
                                                        {{$items->order_code}}
                                                        </a>
                                                    </td>
                                                    <td>{{ $items->created_at->format('F d, Y') }}</td>
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
                                    {{-- Pagination --}}
                                    {{ $otherOrders->appends(['tab' => 'orderHistorySection'])->links() }}
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
            let cartUpdated = false; // Track if cart has unsaved changes
            let pendingUrl = null; // Store URL user clicked while having unsaved changes

            // Update product row total when quantity changes
            function countCalculation(button) {
                let parentNode = button.closest("tr");                              // Find row of clicked button
                let price = parentNode.find(".price").text().replace("mmk", "");    // Get price text, remove "mmk"
                let qty = parseInt(parentNode.find(".quantity").val());             // Get quantity
                parentNode.find(".total").text((price * qty) + " mmk");             // Update row total
            }

             // Recalculate subtotal and final total
            function subTotalCalculation() {
                let total = 0;
                $("#productTable tbody tr").each(function(index, item) {
                    total += Number($(item).find(".total").text().replace("mmk", ""));
                })
                $("#subTotal").html(`${total} mmk`)
                $("#finalTotal").html(`${total+5000} mmk`) // Add fixed delivery fee to subTotal to get finalTotal
            }

            // Decrease quantity button
            $('.btn-minus').click(function() {
                let row = $(this).closest('tr');
                let input = row.find('.quantity');
                let current = parseInt(input.val());
                if (current > 1) {
                    input.val(current - 1);
                    countCalculation($(this));  // Update row total
                    subTotalCalculation();      // Update subtotal/final total
                    cartUpdated = true;         // Mark cart as changed
                }
            });

            $('.btn-plus').click(function() {
                let row = $(this).closest('tr');
                let input = row.find('.quantity');
                let stock = parseInt(input.data('stock')); // get stock value
                let current = parseInt(input.val());
                if (current < stock) {
                    input.val(current + 1);
                    countCalculation($(this));  // Update row total
                    subTotalCalculation();      // Update subtotal/final total
                    cartUpdated = true;         // Mark cart as changed
                }
            });

            //Delete item from cart
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

            //Intercept links if cart has unsaved changes
            $('.user-dashboard-menu li').click(function(e){
                if ($(this).is(':last-child')) {
                    // Back button → trigger modal if unsaved changes
                    if (cartUpdated) {
                        e.preventDefault();
                        pendingUrl = $(this).find('a').attr('href');
                        let modal = new bootstrap.Modal(document.getElementById('cartSaveModal'));
                        modal.show();
                    }
                    return;
                }

                // normal section switching
                e.preventDefault();
                $('.user-dashboard-menu li').removeClass('active');
                $(this).addClass('active');
                $('.content-section').addClass('d-none');
                let target = $(this).data('target');
                $(target).removeClass('d-none');
            });


            // 👉 Save changes to cart before leaving
            $('#saveBtn').click(function() {
                let cartUpdates = [];
                $("#productTable tbody tr").each(function(index, item) {
                    let cartId = $(item).find('.cartId').val();
                    let quantity = $(item).find('.quantity').val();
                    cartUpdates.push({ cartId, quantity });
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
                            cartUpdated = false;  // Reset flag
                            let modal = bootstrap.Modal.getInstance(document.getElementById('cartSaveModal'));
                            modal.hide();         // Close modal
                            if (pendingUrl) window.location.href = pendingUrl; // Continue navigation
                        }
                    }
                });
            });

            // 👉 Discard changes and leave page
            $('#discardBtn').click(function() {
                cartUpdated = false;  // Ignore unsaved changes
                let modal = bootstrap.Modal.getInstance(document.getElementById('cartSaveModal'));
                modal.hide();         // Close modal
                if (pendingUrl) window.location.href = pendingUrl; // Continue navigation
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
                    data: Object.assign({},orderList), //orderList = []; is array and we wanna send objects so we have to make them object assign
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        response.status == 'success' ? location.href = '/user/cart/paymentPage' : location.reload();
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
