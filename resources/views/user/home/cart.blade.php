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
                                <img src="{{asset('profileImage/68964bee05c26capybara.jpg')}}" alt="" class="rounded-circle">
                            </div>
                            <!-- User Name -->
                            <h5 class="text-center">Samanta Doe</h5>
                            <p>Joined February 06, 2017</p>
                        </div>
                        <!-- Dashboard Links -->
                        <div class="widget user-dashboard-menu">
                            <ul>
                                <li class="active"><a href="dashboard-my-ads.html"><i class="fa-solid fa-cart-shopping"></i> My Cart</a></li>
                                <li>
                                    <a href="#"><i class="fa-regular fa-thumbs-up"></i> Pending Orders<span>233</span></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-solid fa-clock-rotate-left"></i> History</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-solid fa-backward"></i> Back</a>
                                </li>
                                {{-- <li>
                                    <a href="#!" data-toggle="modal" data-target="#deleteaccount"><i class="fa fa-power-off"></i>Back</a>
                                </li> --}}
                            </ul>
                        </div>

                        <!-- delete-account modal -->
                        <!-- delete account popup modal start-->

                    </div>
            </div>
            {{-- profile and 4 Lists end --}}

            {{-- My Cart data start--}}
            <div class="col-lg-9">
                    <div class="widget dashboard-container my-adslist">
                    <h3 class="widget-header">My Cart</h3>
                    <div class=" table-responsive">
                        <table class="table table-responsive product-dashboard-table">
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
                                <img src="{{asset('productImage/'.$data->image)}}" style="width:100px; height:100px; object-fit:cover;" class=" rounded-circle">
                            </td>
                            <td class="p-3">
                            <h6 class="title">{{$data->name}}</h6>

                            </td>
                            <td class="p-3"><span class="text-muted">{{$data->sale_price}} mmk</span></td>
                            <td class="p-3">
                                {{-- Quantity + - start --}}
                                <span class="text-danger @if ($data->stock>5) text-muted @endif" style="font-size: 10px;">Stock: {{$data->stock}} item(s) left</span>
                                <div class="d-flex justify-content-evenly align-items-center mt-3" style="max-width: 120px;">
                                    <button class="btn btn-outline-primary rounded-pill p-0" type="button" id="btn-minus" style="width: 25px; height:25px;">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="" id="quantity" name="quantity"
                                        class="form-control text-center border-0"
                                        value="{{$data->qty}}" min="1"
                                        style="width:50px; height:25px;">
                                    <button class="btn btn-outline-primary rounded-pill p-0" type="button" id="btn-plus" style="width: 25px; height:25px;">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                {{-- Quantity + - end --}}
                            </td>
                            <td class="p-3 text-muted">{{$data->sale_price * $data->qty}} mmk</td>
                            <td class="action p-1" data-title="Action"  style="min-width:20px;">
                            <div class="">
                                    <a class="delete" data-toggle="tooltip" data-placement="top" title="Delete" href="dashboard.html">
                                    <i class="fa fa-trash"></i>
                                    </a>
                            </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>

                    </div>

                </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('js')
    <script>
        //Quantity + - start
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const quantityInput = document.getElementById('quantity');

        btnMinus.addEventListener('click', () => {
            let val = parseInt(quantityInput.value);
            if (val > 1) quantityInput.value = val - 1;
        });

        btnPlus.addEventListener('click', () => {
            let val = parseInt(quantityInput.value);
            quantityInput.value = val + 1;
        });
        //Quantity + - end
    </script>
@endsection
