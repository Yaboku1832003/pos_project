@extends('user.layouts.master')

@section('content')

    <section class="section">
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
                                <li class="active"><a href="dashboard-my-ads.html"><i class="fa-solid fa-cart-shopping"></i>
                                        My Cart</a></li>
                                <li>
                                    <a href="#"><i class="fa-regular fa-thumbs-up"></i> Pending
                                        Orders<span>233</span></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-solid fa-clock-rotate-left"></i> History</a>
                                </li>
                                <li>
                                    <a href="{{ route('user#homePage') }}"><i class="fas fa-home  fs-5 mt-1"></i> Back</a>
                                </li>
                                {{-- <li>
                                    <a href="#!" data-toggle="modal" data-target="#deleteaccount"><i class="fa fa-power-off"></i>Back</a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- profile and 4 Lists end --}}

                {{-- My Cart data start --}}
                <div class="col-lg-9">
                    <h3 class="widget-header">My Cart</h3>
                    @if ($cartData->count() > 0)
                        <div class="table-responsive">
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
                                                    <span class="text-danger @if ($data->stock > 5) text-muted @endif"
                                                        style="font-size: 10px;">Stock: {{ $data->stock }} item(s) left</span>
                                                    @csrf
                                                    <div class="d-flex justify-content-evenly align-items-center mt-3"
                                                        style="max-width: 120px;">
                                                        <button type="submit" class="btn btn-outline-primary rounded-pill p-0 btn-minus"
                                                                value="minus" name="action" style="width: 25px; height:25px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="" name="quantity"
                                                            data-stock="{{ $data->stock }}"
                                                            class="form-control text-center border-0 quantity"
                                                            value="{{ $data->qty }}" min="1"
                                                            style="width:50px; height:25px;">
                                                        <button type="submit" class="btn btn-outline-primary rounded-pill p-0 btn-plus"
                                                                value="plus" name="action" style="width: 25px; height:25px;">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    {{-- Quantity + - end --}}
                                                </td>
                                                <td class="p-3 text-muted total">{{ $data->sale_price * $data->qty }} mmk</td>
                                                <td class="d-flex justify-content-center align-content-center">
                                                    <button style="width: 40px; height: 40px;" title="Delete"
                                                        class="btn btn-outline-danger rounded-circle btn-delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <input type="hidden" class="cartId" value="{{$data->cart_id}}">
                                                    <input type="hidden" class="userId" value="{{Auth::user()->id}}">
                                                    <input type="hidden" class="productId" value="{{$data->product_id}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <section class="section bg-gray">
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
                    <div class="modal fade" id="cartSaveModal" tabindex="-1" aria-labelledby="cartSaveModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Unsaved Changes</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Do you want to save them before leaving?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="discardBtn" data-bs-dismiss="modal">Discard</button>
                                <button type="button" class="btn btn-primary" id="saveBtn">Save Changes</button>
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
                                        <span id="subtotal">{{ $totalPrice }} mmk</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Delivery Fee:</span>
                                        <span>5000 mmk</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total:</span>
                                        <span id="finalTotal">{{ $totalPrice + 5000 }} mmk</span>
                                    </li>
                                </ul>
                                <div class="mt-3 text-end">
                                    <button id="btnCheckout" class="btn btn-success">Checkout</button>
                                </div>
                            </div>
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
                let price = parseFloat(parentNode.find(".price").text().replace("mmk", "").trim());
                let qty = parseInt(parentNode.find(".quantity").val());
                parentNode.find(".total").text((price * qty) + " mmk");
            }

            function subTotalCalculation() {
                let total = 0;
                $("#productTable tbody tr").each(function(index, item) {
                    // console.log($item);
                    total += Number($(item).find(".total").text().replace("mmk", ""));
                })
                $("#subtotal").html(`${total} mmk`)
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
                    'cartId' : cartId
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

            $('a').click(function(e){
                let url = $(this).attr('href');
                if(cartUpdated){
                    e.preventDefault(); // stop immediate navigation
                    pendingUrl = url;
                    $('#cartSaveModal').modal('show');
                }
            });

            // Save changes
            $('#saveBtn').click(function(){
                let cartUpdates = [];
                $("#productTable tbody tr").each(function(index, item) {
                    let cartId = $(item).find('.cartId').val();
                    let quantity = $(item).find('.quantity').val();
                    cartUpdates.push({ cartId, quantity });
                });

                updateData = {
                    'data' : cartUpdates,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }

                $.ajax({
                    url: '/user/cart/update',
                    type: 'POST',
                    data:  updateData ,
                    dataType: 'json',
                    success: function(response){
                        if(response.status === 'success'){
                            cartUpdated = false;
                            $('#cartSaveModal').modal('hide');
                            if(pendingUrl) window.location.href = pendingUrl;
                        }
                    }
                });
            });

            // Discard changes
            $('#discardBtn').click(function(){
                cartUpdated = false;
                $('#cartSaveModal').modal('hide');
                if(pendingUrl) window.location.href = pendingUrl;
            });

            //checkOut
            $('#btnCheckout').click(function(){
                orderList = [];
                userId=$('.userId').val();
                orderCode = "ZWY-POS-ORDER-" + Math.floor(Math.random() * 100000000);
                // console.log(userId, orderCode);

                $("#productTable tbody tr").each(function(index, row) {
                    productId = $(row).find('.productId').val();
                    qty = $(row).find('.quantity').val();
                    cartId = $(row).find('.cartId').val();

                    // array.push -> push object into array
                    orderList.push({
                        'product_id' : productId,
                        'user_id' : userId,
                        'count' : qty,
                        'status' : 0,
                        'order_code' : orderCode
                   });
                })
                // console.log(orderList);
                $.ajax({
                    url: '/user/cart/tempStorage',
                    type: 'get',
                    data: Object.assign({},orderList) , //orderList = []; is array and we wanna send objects so we have to make them object assign
                    dataType: 'json',
                    success: function(response){
                        // console.log(response);
                        response.status == 'success' ? location.href ='/user/cart/paymentPage' : location.reload();
                    }
                });
            });

        });
    </script>
@endsection
