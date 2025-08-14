@extends('user.layouts.master')
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
                            <div class="short-popular-category-list text-center">
                                <h2>Popular Category</h2>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="category.html"><i class="fa fa-bed"></i> Hotel</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="category.html"><i class="fa fa-grav"></i> Fitness</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="category.html"><i class="fa fa-car"></i> Cars</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="category.html"><i class="fa fa-cutlery"></i> Restaurants</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="category.html"><i class="fa fa-coffee"></i> Cafe</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <!-- Advance Search -->
                        <div class="advance-search">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12 col-md-12 align-content-center">
                                        <form>
                                            <div class="form-row">
                                                <div class="form-group col-xl-4 col-lg-3 col-md-6">
                                                    <input type="text" class="form-control my-2 my-lg-1" id="inputtext4"
                                                        placeholder="What are you looking for">
                                                </div>
                                                <div class="form-group col-lg-3 col-md-6">
                                                    <select class="w-100 form-control mt-lg-1 mt-md-2">
                                                        <option>Category</option>
                                                        <option value="1">Top rated</option>
                                                        <option value="2">Lowest Price</option>
                                                        <option value="4">Highest Price</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-3 col-md-6">
                                                    <input type="text" class="form-control my-2 my-lg-1" id="inputLocation4"
                                                        placeholder="Location">
                                                </div>
                                                <div class="form-group col-xl-2 col-lg-3 col-md-6 align-self-center">
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, magnam.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="trending-ads-slide">
                            @foreach ($products as $product)
                                <div class="col-sm-12 col-lg-4 d-flex align-items-stretch">
                                    <div class="product-item bg-light w-100">
                                        <div class="card h-100">
                                            <div class="thumb-content">
                                                <a href="single.html">
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
                                                        <a href="single.html"><i class="fa fa-folder-open-o"></i>Electronics</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="category.html"><i
                                                                class="fa fa-calendar"></i>{{ $product->created_at->format('jS F') }}</a>
                                                    </li>
                                                </ul>
                                                <p class="card-text flex-grow-1">
                                                    {{ \Illuminate\Support\Str::limit($product->description, 30) }}</p>
                                                <div class="product-ratings mt-auto">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    </ul>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis, provident!</p>
                        </div>
                        <div class="row">
                            @foreach ($products as $item)
                                <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 mb-4">
                                    <div class="card h-100 border border-secondary">
                                        <a href="#">
                                            <img src="{{ asset('productImage/' . $item->image) }}"
                                                class="card-img-top img-fluid rounded-top"
                                                style="height: 220px; object-fit: cover;" alt="">
                                        </a>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                            style="top: 10px; left: 10px;">{{ $item->category_name ?? 'No Category' }}
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h4 class="card-title">{{ $item->name }}</h4>
                                            <p class="card-text" style="max-height: 80px; overflow: auto;">
                                                {{ $item->description }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <h5 class="text-primary mb-0">{{ $item->sale_price }} MMK</h5>
                                                <a href="#" class="btn btn-primary btn-sm">View Details</a>
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
        <!-- <div class="container py-5">
                    <div class="tab-class text-center">
                        <div class="row g-4">
                            <div class="col-lg-4 text-start">
                                <h1>Our Products</h1>
                            </div>
                            <div class="col-lg-8 text-end">
                                <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                    <li class="nav-item">
                                        <a class="d-flex m-2 py-2 bg-light rounded-pill" href="">
                                            <span class="text-dark" style="width: 130px;">All Products</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    <div class="col-3">
                                        <div class="form">
                                            <form action="" method="get">
                                                <div class="input-group">
                                                    <input type="text" name="searchKey" value="" class="form-control"
                                                        placeholder="Enter Search Key...">
                                                    <button type="submit" class="btn"> <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <form action="" method="get">
                                                    <input type="text" name="minPrice" value="" placeholder="Minimum Price..."
                                                        class="form-control my-2">
                                                    <input type="text" name="maxPrice" value="" placeholder="Maximum Price..."
                                                        class="form-control my-2">
                                                    <input type="submit" value="Search" class="btn btn-success my-2 w-100">
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="get">
                                                    <select name="sortingType" class="form-control w-100 bg-white mt-3">
                                                    </select>
                                                    <input type="submit" value="Sort" class="btn btn-success my-3 w-100">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="row g-4">
                                            @foreach ($products as $item)
                                                <div class="col-4">
                                                    <div class="card h-100 rounded position-relative">
                                                        <div class="fruite-img">
                                                            <a href="">
                                                                <img src="{{ asset('productImage/' . $item->image) }}"
                                                                    class="card-img-top img-fluid rounded-top"
                                                                    style="height: 220px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                            style="top: 10px; left: 10px;">Category Name
                                                        </div>
                                                        <div
                                                            class="card-body d-flex flex-column justify-content-between p-4 border border-secondary border-top-0 rounded-bottom">
                                                            <h4 class="card-title">{{ $item->name }}</h4>
                                                            <p class="card-text overflow-auto" style="max-height: 80px;">
                                                                {{ $item->description }}
                                                            </p>
                                                            <div class="d-flex justify-content-between flex-lg-wrap mt-3">
                                                                <p class="text-dark fs-5 fw-bold mb-0"> mmk</p>
                                                                <a href="#"
                                                                    class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                                    cart
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
    </div>
@endsection