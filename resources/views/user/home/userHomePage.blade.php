@extends('user.layouts.master')

@section('css')
    <style>
        .ratedStar {
            font-size: 20px;
            color: gray;
            cursor: pointer;
            }
        .ratedStar.selected{
            color: #0d6efd;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid fruite py-5 mt-5">
        <section class="hero-area bg-1 text-center overly">
            <!-- Container Start -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Header Contetnt -->
                        <div class="content-block">
                            <h1>Click, Cart, Celebrate</h1>
                            <p>Welcome to our shop! Explore everything we have to offer <br> we guarantee your complete satisfaction with every purchase.</p>
                        </div>
                        <!-- Advance Search -->
                        <div class="advance-search">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12 col-md-12 align-content-center">

                                        <form action="{{route('user#category')}}" method="GET">
                                            <div class="form-row">
                                                <div class="form-group col-xl-5 col-lg-4 col-md-6">
                                                    <input type="text" name="search" class="form-control my-2 my-lg-1" id=""
                                                        placeholder="What are you looking for">
                                                </div>
                                                <div class="form-group col-lg-4 col-md-6">
                                                    <select class="form-control w-100 mt-lg-1 mt-md-2" name="category_id">
                                                        <option value="">Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-xl-3 col-lg-4 col-md-6 align-self-center">
                                                    <button type="submit" class="btn btn-primary active w-100">Search
                                                        Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container End -->
        </section>


        <!--===========================================
            =            Popular deals section            =
            ============================================-->

        <section class="popular-deals section bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2>Most Rated Items</h2>
                            <p>Discover our top-rated items. 🌟</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="trending-ads-slide">
                            @foreach ($topRatedProducts as $product)
                                <div class="col-sm-12 col-lg-4 d-flex align-items-stretch">
                                    <div class="product-item bg-light w-100">
                                        <div class="card h-100">
                                            <div class="thumb-content">
                                                <a href="{{route('user#productDetail',$product->id)}}">
                                                    <img class="card-img-top img-fluid"
                                                        src="{{ asset('productImage/' . $product->image) }}"
                                                        alt="Product image for {{ $product->name }}"
                                                        style="height: 220px; object-fit: cover;">
                                                </a>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <h4 class="card-title"><a href="single.html">{{ $product->name }}</a></h4>
                                                <ul class="list-inline product-meta">
                                                    <li class="list-inline-item">
                                                        <a href="single.html"><i class="fa fa-folder-open-o"></i>{{$product->category_name}}</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="category.html"><i
                                                                class="fa fa-calendar"></i>{{ $product->updated_at->format('Y-m-d') }}</a>
                                                    </li>
                                                </ul>
                                                <p class="card-text flex-grow-1">
                                                    {{ \Illuminate\Support\Str::limit($product->description, 30) }}</p>
                                                <div class="product-ratings mt-auto">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="ratedStar {{ $i <= $product->star_count ? 'selected' : '' }}" data-value="{{ $i }}">★</span>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!--==========================================
            =            All Products Section            =
            ===========================================-->

        <section class=" section">
            <!-- Container Start -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Section title -->
                        <div class="section-title">
                            <h2>Our Products</h2>
                            <p>Explore our latest collection of quality products made to fit your lifestyle and budget.</p>
                        </div>
                        <div class="row">
                            @foreach ($products as $item)
                                <div class="col-lg-4 offset-lg-0 col-md-5 offset-md-1 col-sm-6 mb-4">
                                    <div class="card h-100 border border-secondary">
                                        <a href="{{route('user#productDetail',$item->id)}}">
                                            <img src="{{ asset('productImage/' . $item->image) }}"
                                                class="card-img-top img-fluid rounded-top"
                                                style="height: 220px; object-fit: cover;" alt="">
                                        </a>
                                        <div class="text-white bg-secondary px-3 py-1 rounded-pill position-absolute"
                                            style="top: 10px; left: 10px;">{{ $item->category_name ?? 'No Category' }}
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h4 class="card-title">{{ $item->name }}</h4>
                                            <p class="card-text mb-1" style="max-height: 80px;">
                                                {{Str::words($item->description, 15, '...')  }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <h5 class="text-primary mb-0">{{ $item->sale_price }} MMK</h5>
                                                @if(Auth::user())
                                                    <form action="{{ route('user#addToCart') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="productId" value="{{ $item->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="btn btn-primary rounded-pill btn-sm d-inline-flex align-items-center">
                                                            <i class="fa-solid fa-cart-shopping me-2"></i>
                                                            Add to Cart
                                                        </button>
                                                    </form>
                                                @else
                                                    <small class="text-muted">
                                                        Need to Sign In/Up
                                                    </small>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <!-- Container End -->
        </section>
    </div>
@endsection
