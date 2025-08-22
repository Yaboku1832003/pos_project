    @extends('user.layouts.master')
    @section('css')
    <style>
        .star {
            font-size: 40px;
            color: gray;
            cursor: pointer;
            }

        .star.selected {
            color: #0d6efd;
            }
    </style>
    @endsection

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
                                <li class="list-inline-item"><a href="{{route('user#homePage')}}"><i class="fas fa-home  fs-5 mt-1"></i> Back</a></li>
                                <li class="list-inline-item">
                                    <form id="categoryForm" action="{{ route('user#category') }}" method="GET" class="d-none">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                    </form>
                                    <a href="javascript:void(0)" onclick="document.getElementById('categoryForm').submit()">
                                        <i class="fa-solid fa-folder-open fs-5"></i> Category: {{$product->category_name}}
                                    </a>
                                </li>
                                <li class="list-inline-item"><a href="#"><i class="fa-solid fa-calendar-days  fs-5 mt-1"></i> {{$product->updated_at->format('F d, Y')}}</a></li>
                            </ul>
                        </div>

                        <!-- product slider -->
                        <div >
                                <img class="img-fluid w-100" src="{{asset('productImage/'.$product->image)}}" alt="">
                        </div>
                        <!-- product slider -->
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $rating ? 'selected' : '' }}" data-value="{{ $i }}">★</span>
                            @endfor
                        </div>

                        <div class="content mt-3 pt-5">
                            <ul class="nav nav-pills  justify-content-start" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Product Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact"
                                    aria-selected="false">Reviews
                                        <span class="mx-3 px-3 py-1 rounded-1" style="border: 1px solid #679d06;">
                                            {{ count($comments) }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <h3 class="tab-title">Product Description</h3>
                                    <p>{{$product->description}}</p>
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
                                                <td>{{$product->updated_at->format('F d, Y')}}</td>
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
                                            <tr>
                                                <td>Rating</td>
                                                <td>{{$rating}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="review-submission">
                                    <h3 class="tab-title">Submit your review</h3>
                                    {{-- if loop start --}}
                                    {{-- this will show the Auth::user() comment start--}}
                                    @if ($userComment)
                                        <div class="user_review">
                                            @php
                                                $profile = $userComment->profile;
                                                if ($profile) {
                                                    if (filter_var($profile, FILTER_VALIDATE_URL)) {
                                                        $imgSrc = $profile;
                                                    } else {
                                                        $imgSrc = asset('profileImage/' . $profile);
                                                    }
                                                } else {
                                                    $imgSrc = asset('default/default-profile.png');
                                                }
                                            @endphp
                                                <img src="{{$imgSrc}}" alt="avater" style="width: 45px; height: 45px; object-fit: cover;"
                                                class="img-profile rounded-circle me-2">
                                                <div class="rate">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="star {{ $i <= $userComment->count ? 'selected' : '' }}" data-value="{{ $i }}">★</span>
                                                    @endfor
                                                </div>
                                                <p>{{ $userComment->comment }}</p>
                                                <button class="btn btn-sm btn-outline-primary" id="editReviewBtn">Edit Review</button>

                                                <div class="edit_review d-none">
                                                    <form id="" action="{{ route('user#comment') }}" method="POST" class="row">
                                                        @csrf
                                                        <input type="hidden" name="productId" value="{{ $product->id }}">
                                                        <input type="hidden" name="rating" id="rating" value="{{ $userComment->count }}">

                                                        <div class="col-12 mb-3">
                                                            <textarea name="review" rows="6" class="form-control" placeholder="Comment" required>{{ $userComment->comment }}</textarea>
                                                        </div>

                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-outline-primary">Submit</button>
                                                        </div>
                                                </form>
                                                </div>
                                            </div>
                                    @else
                                    {{-- this will show the Auth::user() comment end--}}
                                        <div class="rate">
                                            <span class="star" data-value="1">★</span>
                                            <span class="star" data-value="2">★</span>
                                            <span class="star" data-value="3">★</span>
                                            <span class="star" data-value="4">★</span>
                                            <span class="star" data-value="5">★</span>
                                        </div>

                                        <form id="reviewForm" action="{{ route('user#comment') }}" method="POST" class="row">
                                            @csrf
                                            <input type="hidden" name="productId" value="{{ $product->id }}">
                                            <input type="hidden" name="rating" id="rating">

                                            <div class="col-12 mb-3">
                                                <textarea name="review" id="review" rows="6" class="form-control" placeholder="Comment" required>{{ $existingReview ?? '' }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                                            </div>
                                        </form>
                                    @endif
                                    {{-- end if --}}
                                </div>
                                    <br>
                                    <h3 class="tab-title mt-2">Product Reviews</h3>
                                    <div class="product-review">
                                        {{-- for each loop for comment display start --}}
                                        @foreach ($comments as $comment )
                                            <div class="media">
                                            <!-- Avater  start-->
                                             @php
                                                $profile = $comment->profile;
                                                if ($profile) {
                                                    if (filter_var($profile, FILTER_VALIDATE_URL)) {
                                                        $imgSrc = $profile;
                                                    } else {
                                                        $imgSrc = asset('profileImage/' . $profile);
                                                    }
                                                } else {
                                                    $imgSrc = asset('default/default-profile.png');
                                                }
                                            @endphp
                                            <img src="{{$imgSrc}}" alt="avater" style="width: 45px; height: 45px; object-fit: cover;"
                                            class="img-profile rounded-circle me-2">
                                            {{-- Avatar end --}}
                                            <div class="media-body">
                                                @for ($i=1; $i<=5; $i++)
                                                    <span class="star {{ $i <= $comment->count ? 'selected' : '' }}" style="font-size: 20px;">★</span>
                                                @endfor
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="name">
                                                        <h5>{{$comment->name}}</h5>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm text-muted p-0" type="button"
                                                            id="dropdownMenuButton{{ $comment->comment_id }}"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $comment->comment_id }}">
                                                            <li><a class="dropdown-item" href="#">Report</a></li>
                                                            {{-- shown Delete_Btn only for Auth::user() comment start--}}
                                                            @if(Auth::id() === $comment->user_id)
                                                            <li>
                                                                <form action="{{route('user#commentDelete')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="currentComment" value="{{$comment->comment_id}}">
                                                                    <button class="dropdown-item text-danger" type="submit">Delete</button>
                                                                </form>
                                                            </li>
                                                            @endif
                                                            {{-- shown Delete_Btn only for Auth::user() comment end--}}
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="date">
                                                    <p>{{$comment->created_at->format('F d, Y')}}</p>
                                                </div>
                                                <div class="review-comment">
                                                    <p class="fs-5">
                                                        {{$comment->comment}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        {{-- for each loop for comment display end --}}
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
                            <p>{{$product->sale_price}} MMK</p>
                        </div>
                        @if (Auth::user())
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
                        @endif

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
        //Star rating start
        document.addEventListener('DOMContentLoaded', function() {
            // edit btn JS start
            const editBtn = document.getElementById('editReviewBtn');
                if(editBtn){
                    editBtn.addEventListener('click', () => {
                        editBtn.classList.add('d-none');
                        document.querySelector('.edit_review').classList.remove('d-none');
                    });
                }
            //edit btn JS end

            let stars = document.querySelectorAll('.star');
            let ratingInput = document.getElementById('rating');

            //for each stars get their data-values and put them in input hidden start
            stars.forEach(function(star) {
                star.addEventListener('click', function() {
                let rating = this.getAttribute('data-value');
                ratingInput.value = rating;
            //for each stars get their data-values and put them in input hidden end

                    // Highlight selected stars start
                    stars.forEach(function(s, index) {
                        if (index < rating) {
                        s.classList.add('selected');
                        } else {
                        s.classList.remove('selected');
                        }
                    });
                    // Highlight selected stars end
                });
            });
        });
        //Star rating end
    </script>
    @endsection
