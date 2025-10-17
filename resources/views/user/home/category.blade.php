@extends('user.layouts.master')

@section('css')
    <style>
        .ratedStar {
            font-size: 20px;
            color: gray;
            cursor: pointer;
        }

        .ratedStar.selected {
            color: #0d6efd;
        }
    </style>
@endsection

@section('content')
    <section class="hero-area bg-1 text-center overly position-sticky top-0 w-100" style="z-index: 1000;">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Advance Search -->
                    <div class="advance-search ">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12 align-content-center">

                                    <form action="{{ route('user#category') }}" method="GET">
                                        <div class="form-row">
                                            <div class="form-group col-xl-5 col-lg-4 col-md-6">
                                                <input type="text" name="search" class="form-control my-2 my-lg-1"
                                                    placeholder="What are you looking for" value="{{ request('search') }}">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-6">
                                                <select class="form-control w-100 mt-lg-1 mt-md-2" name="category_id">
                                                    <option value="">Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
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
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-result bg-gray">
                        <h2>Results For "{{ $categoryName }}"</h2>
                        <p>{{ $productCount }} Results on {{ now()->format('d F, Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- sidebar column start --}}
                <div class="col-lg-3 col-md-4">
                    {{-- sidebar start --}}
                    <div class="category-sidebar">
                        <div class="widget filter">
                            <a href="{{ route('user#homePage') }}" class="widget-header">
                                <i class="fas fa-home me-2"></i> Back
                            </a>
                            <h4 class="widget-header mt-2">Show Produts</h4>
                            <div class="widget-header">
                                <form id="sortForm" action="{{ route('user#category') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">

                                    <select name="sort" onchange="this.form.submit()">
                                        <option>Popularity</option>
                                        <option value="most_recent"
                                            {{ request('sort') == 'most_recent' ? 'selected' : '' }}>Most Recent</option>
                                        <option value="lowest_price"
                                            {{ request('sort') == 'lowest_price' ? 'selected' : '' }}>Lowest Price</option>
                                        <option value="highest_price"
                                            {{ request('sort') == 'highest_price' ? 'selected' : '' }}>Highest Price
                                        </option>
                                        <option value="top_rated" {{ request('sort') == 'top_rated' ? 'selected' : '' }}>
                                            Top Rated</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="widget price-range w-100">
                            <h4 class="widget-header">Price Range</h4>
                            <form method="GET" action="{{ route('user#category') }}">
                                @csrf
                                <div class="block">
                                    <input id="price_range" type="text" />
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="value" id="price_value">10,000 - 150,000 MMK</span>
                                    </div>
                                </div>

                                <!-- Filter Form -->
                                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="min_price" id="min_price" value="10000">
                                <input type="hidden" name="max_price" id="max_price" value="150000">
                                <button type="submit" class="btn btn-primary mt-2">Search</button>
                            </form>
                        </div>
                    </div>
                    {{-- sidebar end --}}
                </div>
                {{-- sidebar column end --}}
                <div class="col-lg-9 col-md-8">
                    <div class="category-search-filter d-none d-md-block">
                        <div class="row">
                            <div class="col d-flex  justify-content-end">
                                <div class="view">
                                    <strong>Views</strong>
                                    <ul class="list-inline view-switcher">
                                        <li class="list-inline-item">
                                            <a href="#" onclick="default_listing()" class="text-info"><i
                                                    class="fa fa-th-large"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" onclick="ad_listing()"><i class="fa fa-reorder"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- show products in that category start --}}
                    @if ($products->count() > 0)
                        {{-- default view start --}}
                        <div class="product-grid-list" id="default_view">
                            <div class="row mt-30">
                                @foreach ($products as $product)
                                    <div class="col-lg-4 col-md-6">
                                        <!-- product card -->
                                        <div class="product-item bg-light">
                                            <div class="card">
                                                <div class="thumb-content">
                                                    <!-- <div class="price">$200</div> -->
                                                    <a href="{{ route('user#productDetail', $product->id) }}">
                                                        <img class="card-img-top img-fluid"
                                                            src="{{ asset('productImage/' . $product->image) }}"
                                                            alt="Card image cap"
                                                            style="height: 220px; object-fit: cover;">
                                                    </a>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-title"><a href="single.html">{{ $product->name }}</a>
                                                    </h4>
                                                    <ul class="list-inline product-meta">
                                                        <li class="list-inline-item">
                                                            <a href="single.html"><i
                                                                    class="fa-solid fa-sack-dollar"></i>{{ $product->sale_price }}
                                                                MMK</a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="category.html"><i
                                                                    class="fa fa-calendar"></i>{{ $product->updated_at->format('Y-m-d') }}</a>
                                                        </li>
                                                    </ul>
                                                    <p class="card-text" style="max-height: 80px; overflow: auto;">
                                                        {{ $product->description }}
                                                    </p>
                                                    <div class="product-ratings float-lg-left pb-3">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="ratedStar {{ $i <= $product->star_count ? 'selected' : '' }}"
                                                                data-value="{{ $i }}">★</span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- default view end --}}

                        {{-- changed view start --}}
                        <div id="ad_listing_view" class="d-none">
                            @foreach ($products as $product)
                                <div class="ad-listing-list mt-20 ">
                                    <div class="row p-lg-3 p-sm-5 p-4">
                                        <div class="col-lg-4 align-self-center">

                                            <a href="{{ route('user#productDetail', $product->id) }}">
                                                <img src="{{ asset('productImage/' . $product->image) }}"
                                                    class="img-fluid" alt="">
                                            </a>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-10">
                                                    <div class="ad-listing-content">
                                                        <div>
                                                            <a href="single.html"
                                                                class="font-weight-bold">{{ $product->name }}</a>
                                                        </div>
                                                        <ul class="list-inline mt-2 mb-3">
                                                            <li class="list-inline-item"><a href="category.html"> <i
                                                                        class="fa-solid fa-sack-dollar"></i>
                                                                    {{ $product->sale_price }} MMK</a>
                                                            </li>
                                                            <li class="list-inline-item"><a href="category.htm"><i
                                                                        class="fa fa-calendar"></i>{{ $product->updated_at->format('Y-m-d') }}</a>
                                                            </li>
                                                        </ul>
                                                        <p class="pr-5" style="max-height: 80px; overflow: auto;">
                                                            {{ $product->description }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 align-self-center">
                                                    <div class="product-ratings float-lg-right pb-3">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="ratedStar {{ $i <= $product->star_count ? 'selected' : '' }}"
                                                                data-value="{{ $i }}">★</span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- changed view end --}}
                        {{-- show products in that category end --}}

                        {{-- no item in this category start --}}
                    @else
                        <section class="section bg-gray">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 text-center mx-auto">
                                        <div class="404-content">
                                            <div class="404-img">
                                                <img src="{{ asset('images/404/404.png') }}" class="img-fluid"
                                                    alt="404">
                                            </div>
                                            <h1 class="display-1 pt-1 pb-2">Oops</h1>
                                            <p class="px-3 pb-2 text-dark">Sorry, we couldn’t find any products
                                                matching your search
                                                in the <strong class="text-danger">"{{ $categoryName }}"</strong>
                                                category.
                                                Please try a different search or check back later. </p>
                                            <a href="{{ route('user#homePage') }}" class="btn btn-info">GO HOME</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                    {{-- no item in this category end --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {})
        // sorting style change
        const savedView = sessionStorage.getItem("viewMode");
        if (savedView === "list") {
            const default_view = document.getElementById('default_view');
            const ad_listing_view = document.getElementById('ad_listing_view');

            if (default_view && ad_listing_view) {
                default_view.classList.add('d-none');
                ad_listing_view.classList.remove('d-none');
            }
        } else {
            const default_view = document.getElementById('default_view');
            const ad_listing_view = document.getElementById('ad_listing_view');

            if (default_view && ad_listing_view) {
                default_view.classList.remove('d-none');
                ad_listing_view.classList.add('d-none');
            }
        }

        function default_listing() {
            const default_view = document.getElementById('default_view');
            const ad_listing_view = document.getElementById('ad_listing_view');

            default_view.classList.remove('d-none');
            ad_listing_view.classList.add('d-none');
            sessionStorage.setItem("viewMode", "grid");
        }

        function ad_listing() {
            const default_view = document.getElementById('default_view');
            const ad_listing_view = document.getElementById('ad_listing_view');

            default_view.classList.add('d-none');
            ad_listing_view.classList.remove('d-none')
            sessionStorage.setItem("viewMode", "list");
        }

        // Initialize slider
        var slider = new Slider("#price_range", {
            min: 10000,
            max: 150000,
            step: 5000,
            value: [10000, 150000],
            tooltip_split: true,
            formatter: function(value) {
                if (Array.isArray(value)) {
                    return value[0].toLocaleString() + " - " + value[1].toLocaleString() + " MMK";
                }
                return value.toLocaleString() + " MMK";
            }
        });

        // Update UI + hidden inputs on slide
        slider.on("slide", function(value) {
            document.getElementById("price_value").textContent =
                value[0].toLocaleString() + " - " + value[1].toLocaleString() + " MMK";

            document.getElementById("min_price").value = value[0];
            document.getElementById("max_price").value = value[1];
        });


        // dropdown select sorting
        document.getElementById('sort_dropdown').addEventListener('change', function() {
            var sort = this.value;
            var category = document.getElementById('current_category').value;
            var minPrice = document.getElementById('current_min_price').value;
            var maxPrice = document.getElementById('current_max_price').value;
            var search = document.getElementById('current_search').value;

            var url = "{{ route('user#category') }}?";
            if (category) url += "category_id=" + category + "&";
            if (minPrice) url += "min_price=" + minPrice + "&";
            if (maxPrice) url += "max_price=" + maxPrice + "&";
            if (search) url += "search=" + search + "&";
            if (sort) url += "sort=" + sort;

            // Go to the URL
            window.location.href = url;
        });
    </script>
@endsection
