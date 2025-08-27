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

                                                    <input type="hidden" class="cartId" value="{{$data->cart_id}}">

                                                    <button style="width: 40px; height: 40px;" title="Delete"
                                                        class="btn btn-outline-danger rounded-circle btn-delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
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
                                        <span>Delivery Fee</span>
                                        <span>5000 mmk</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total</span>
                                        <span id="finalTotal">{{ $totalPrice + 5000 }} mmk</span>
                                    </li>
                                </ul>
                                <div class="mt-3 text-end">
                                    <a href="" class="btn btn-success">Checkout</a>
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
                }
            });

            $(".btn-delete").click(function() {
                let parentNode = $(this).closest("tr");
                cartId = parentNode.find(".cartId").val();

                console.log(cartId);

            })

        });
    </script>
@endsection
