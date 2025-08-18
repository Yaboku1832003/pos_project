    @extends('user.layouts.master')

    @section('content')
    <section class="section bg-gray">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <!-- Left sidebar -->
                <div class="col-lg-8">
                    <div class="product-details">
                        <h1 class="product-title">{{$product->name}}</h1>
                        <div class="product-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="javascript:history.back()"><i class="fas fa-sign-out-alt  fs-5 mt-1"></i> Back</a></li>
                                <li class="list-inline-item">
                                    <form id="homeForm" action="{{ route('user#category') }}" method="GET" class="d-none">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                    </form>
                                    <a href="javascript:void(0)" onclick="document.getElementById('homeForm').submit()">
                                        <i class="fa-solid fa-folder-open fs-5"></i> Category: {{$product->category_name}}
                                    </a>
                                </li>
                                <li class="list-inline-item"><a href="#"><i class="fa-solid fa-calendar-days  fs-5 mt-1"></i> {{$product->updated_at->format('Y-m-d')}}</a></li>
                            </ul>
                        </div>

                        <!-- product slider -->
                        <div >
                                <img class="img-fluid w-100" src="{{asset('productImage/'.$product->image)}}" alt="">
                        </div>
                        <!-- product slider -->

                        <div class="content mt-5 pt-5">
                            <ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Product Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile"
                                    aria-selected="false">Specifications</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact"
                                    aria-selected="false">Reviews</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <h3 class="tab-title">Product Description</h3>
                                    <p>{{$product->description}}</p>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <h3 class="tab-title">Product Specifications</h3>
                                    <table class="table table-bordered product-table">
                                        <tbody>
                                            <tr>
                                                <td>Product Name</td>
                                                <td>{{$product->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td>{{$product->sale_price}} MMK</td>
                                            </tr>
                                            <tr>
                                                <td>Added</td>
                                                <td>{{$product->updated_at->format('Y-m-d')}}</td>
                                            </tr>
                                            <tr>
                                                <td>Stock</td>
                                                <td>
                                                    {{$product->stock}}
                                                        @if ($product->stock<=5)
                                                    <span
                                                        class="badge bg-danger text-white ms-2">
                                                        Low stock
                                                    </span>
                                                        @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Category</td>
                                                <td>{{$product->category_name}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <h3 class="tab-title">Product Review</h3>
                                    <div class="product-review">
                                        <div class="media">
                                            <!-- Avater -->
                                            <img src="images/user/user-thumb.jpg" alt="avater">
                                            <div class="media-body">
                                                <!-- Ratings -->
                                                <div class="ratings">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <i class="fa fa-star"></i>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <i class="fa fa-star"></i>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <i class="fa fa-star"></i>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <i class="fa fa-star"></i>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <i class="fa fa-star"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="name">
                                                    <h5>Jessica Brown</h5>
                                                </div>
                                                <div class="date">
                                                    <p>Mar 20, 2018</p>
                                                </div>
                                                <div class="review-comment">
                                                    <p>
                                                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremqe laudant tota rem ape
                                                        riamipsa eaque.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review-submission">
                                            <h3 class="tab-title">Submit your review</h3>
                                            <!-- Rate -->
                                            <div class="rate">
                                                <div class="starrr"></div>
                                            </div>
                                            <div class="review-submit">
                                                <form id="reviewForm" action="{{route('user#comment')}}" method="POST" class="row">
                                                    @csrf
                                                    <div class="col-12 mb-3">
                                                        <textarea name="review" id="review" rows="6" class="form-control" placeholder="Comment" required></textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-main">Sumbit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="widget price text-center">
                            <h4>Price</h4>
                            <p>$230</p>
                        </div>
                        <div class="widget">
                            <!-- Quantity Selector -->
                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-bold">Quantity</label>
                                <div class="input-group" style="max-width: 150px;">
                                    <button class="btn btn-outline-primary" type="button" id="btn-minus">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" name="quantity" class="form-control text-center" value="1" min="1">
                                    <button class="btn btn-outline-primary" type="button" id="btn-plus">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary flex-fill">Buy Now</button>
                                <button type="button" class="btn btn-outline-primary flex-fill">Add to Cart</button>
                            </div>
                        </div>
                            @foreach ($relatedProducts as $item)
                                <div class="row mb-3">
                                    <div class="card h-100 border border-secondary">
                                        <a href="{{ route('user#productDetail', $item->id) }}">
                                            <img src="{{ asset('productImage/' . $item->image) }}"
                                                class="card-img-top img-fluid rounded-top"
                                                style="width: 100%; height: auto; object-fit: cover;" alt="">
                                        </a>
                                        <div class="text-white bg-secondary px-2 py-1 rounded-pill position-absolute"
                                            style="top: 8px; left: 8px; font-size: 0.75rem;">
                                            {{ $item->category_name ?? 'No Category' }}
                                        </div>
                                        <div class="card-body d-flex flex-column p-2">
                                            <h6 class="card-title mb-1">{{ $item->name }}</h6>
                                            <p class="card-text mb-2" style="max-height: 50px; overflow: hidden; font-size: 0.85rem;">
                                                {{ Str::words($item->description, 10, '...') }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <h6 class="text-primary mb-0" style="font-size: 0.9rem;">{{ $item->sale_price }} MMK</h6>
                                                <a href="#" class="btn btn-sm btn-primary btn-sm d-inline-flex align-items-center py-1 px-2">
                                                    <i class="fa-solid fa-cart-shopping me-1"></i> Add to Cart
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
        <!-- Container End -->
    </section>
    @endsection

    @section('js')
    <script>
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
    </script>
    @endsection
