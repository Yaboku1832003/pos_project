@extends('user.layouts.master')

@section('content')
    <style>
        .fruite-item {
            display: flex;
            flex-direction: column;
            height: 400px; /* reduced height */
            border: 1px solid #6c757d;
        }

        .fruite-img {
            flex: 0 0 auto;
        }

        .fruite-item .p-4 {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
        }

        .description-wrapper {
            max-height: 80px; /* slightly smaller scrollable area */
            overflow-y: auto;
            margin-top: 0.5rem;
            flex-grow: 1;
        }

        /* Optional scrollbar styles */
        .description-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .description-wrapper::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }
    </style>

    <!--  Shop Start-->
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">
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
                                            <button type="submit" class="btn"> <i
                                                    class="fa-solid fa-magnifying-glass"></i> </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <form action="" method="get">
                                            <input type="text" name="minPrice" value=""
                                                placeholder="Minimum Price..." class="form-control my-2">
                                            <input type="text" name="maxPrice" value=""
                                                placeholder="Maximum Price..." class="form-control my-2">
                                            <input type="submit" value="Search" class="btn btn-success my-2 w-100">
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form action="" method="get">
                                            <select name="sortingType" class="form-control w-100 bg-white mt-3">
                                                <!-- Add sorting options here -->
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
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <a href="">
                                                        <img src="{{ asset('productImage/' . $item->image) }}"
                                                            style="height: 220px" class="img-fluid w-100 rounded-top"
                                                            alt="">
                                                    </a>
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">Category Name
                                                </div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column">
                                                    <h4>{{ $item->name }}</h4>

                                                    <div class="description-wrapper">
                                                        {{ $item->description }}
                                                    </div>

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
        </div>
    </div>
    <!-- Shop End-->
@endsection
