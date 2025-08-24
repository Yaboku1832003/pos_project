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
                                    <a href="{{route('user#homePage')}}"><i class="fas fa-home  fs-5 mt-1"></i> Back</a>
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
                                <form action="{{route('user#updateCart')}}" method="POST">
                                    <input type="hidden" name="cart_id" value="{{$data->cart_id}}">
                                    <input type="hidden" name="product_id" value="{{$data->product_id}}">
                                <tr>
                                    <td class="p-3">
                                        <img src="{{asset('productImage/'.$data->image)}}" style="width:100px; height:100px; object-fit:cover;" class=" rounded-circle">
                                    </td>
                                    <td class="p-3">
                                        <h6 class="title">{{$data->name}}</h6>
                                    </td>
                                    <td class="p-3 price">
                                        <span class="text-muted">{{$data->sale_price}} mmk</span>
                                    </td>
                                    <td class="p-3">
                                        {{-- Quantity + - start --}}
                                        <span class="text-danger @if ($data->stock>5) text-muted @endif" style="font-size: 10px;">Stock: {{$data->stock}} item(s) left</span>
                                            @csrf
                                            <div class="d-flex justify-content-evenly align-items-center mt-3" style="max-width: 120px;">
                                            <button type="submit" class="btn btn-outline-primary rounded-pill p-0 btn-minus" value="minus" name="action" style="width: 25px; height:25px;">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="" id="" name="quantity"
                                                class="form-control text-center border-0 quantity"
                                                value="{{$data->qty}}" min="1"
                                                style="width:50px; height:25px;">
                                            <button type="submit" class="btn btn-outline-primary rounded-pill p-0 btn-plus" value="plus" name="action" style="width: 25px; height:25px;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        {{-- Quantity + - end --}}
                                    </td>
                                    <td class="p-3 text-muted total">{{$data->sale_price * $data->qty}} mmk</td>
                                    <td class="d-flex justify-content-center align-content-center" style="min-width:30px;">
                                        <div class="">
                                                <button type="submit" name="action" value="delete" style="width: 40px; height: 40px;" title="Delete"
                                                class="btn btn-outline-danger rounded-circle d-flex justify-content-center align-items-center">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                            @endforeach
                            </tbody>
                        </table>
                    <span class=" d-flex justify-content-end">{{ $cartData->links() }}</span>
                    </div>
                </div>

                </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('js')

@endsection
