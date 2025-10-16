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

        .ratedStar {
            font-size: 40px;
            color: gray;
            cursor: pointer;
        }

        .ratedStar.selected {
            color: #0d6efd;
        }
    </style>
@endsection

@section('content')
    <section class="section bg-gray">
        <div class="container">
            <div class="row">
                <!-- Left sidebar -->
                <div class="col-lg-8">
                    <div class="product-details">
                        <h1 class="product-title">{{ $product->name }}</h1>
                        <div class="product-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="{{ route('user#homePage') }}"><i
                                            class="fas fa-home fs-5 mt-1"></i> Back</a></li>
                                <li class="list-inline-item">
                                    <form id="categoryForm" action="{{ route('user#category') }}" method="GET"
                                        class="d-none">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                    </form>
                                    <a href="javascript:void(0)" onclick="document.getElementById('categoryForm').submit()">
                                        <i class="fa-solid fa-folder-open fs-5"></i> Category: {{ $product->category_name }}
                                    </a>
                                </li>
                                <li class="list-inline-item"><a href="#"><i
                                            class="fa-solid fa-calendar-days fs-5 mt-1"></i>
                                        {{ $product->updated_at->format('F d, Y') }}</a></li>
                            </ul>
                        </div>

                        <div>
                            <img class="img-fluid w-100" src="{{ asset('productImage/' . $product->image) }}"
                                alt="">
                        </div>

                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="ratedStar {{ $i <= $rating ? 'selected' : '' }}"
                                    data-value="{{ $i }}">★</span>
                            @endfor
                        </div>

                        <div class="content mt-3 pt-5">
                            <ul class="nav nav-pills justify-content-start" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home"
                                        role="tab" aria-controls="pills-home" aria-selected="true">Product Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact"
                                        role="tab" aria-controls="pills-contact" aria-selected="false">
                                        Reviews
                                        <span class="mx-3 px-3 py-1 rounded-1"
                                            style="border: 1px solid #679d06;">{{ count($comments) }}</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <h3 class="tab-title">Product Description</h3>
                                    <p>{{ $product->description }}</p>

                                    <h3 class="tab-title">Product Specifications</h3>
                                    <table class="table table-bordered product-table">
                                        <tbody>
                                            <tr>
                                                <td>Product Name</td>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td>{{ $product->sale_price }} MMK</td>
                                            </tr>
                                            <tr>
                                                <td>Added</td>
                                                <td>{{ $product->updated_at->format('F d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Category</td>
                                                <td>{{ $product->category_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Rating</td>
                                                <td>{{ $rating }}
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="ratedStar {{ $i <= $rating ? 'selected' : '' }}"
                                                            style="font-size:14px;">★</span>
                                                    @endfor
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <div class="review-submission">
                                        <h3 class="tab-title">Submit your review</h3>
                                        @if ($userComment)
                                            <div class="user_review">
                                                @php
                                                    $profile = $userComment->profile;
                                                    $imgSrc = $profile
                                                        ? (filter_var($profile, FILTER_VALIDATE_URL)
                                                            ? $profile
                                                            : asset('profileImage/' . $profile))
                                                        : asset('default/default-profile.png');
                                                @endphp
                                                <img src="{{ $imgSrc }}" alt="avatar"
                                                    style="width:45px;height:45px;object-fit:cover;"
                                                    class="img-profile rounded-circle me-2">
                                                <div class="rate" id="authUserRating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="ratedStar {{ $i <= $userComment->count ? 'selected' : '' }}"
                                                            data-value="{{ $i }}">★</span>
                                                    @endfor
                                                    <p>{{ $userComment->comment }}</p>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" id="editReviewBtn">Edit
                                                    Review</button>

                                                <div class="edit_review d-none">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="star {{ $i <= $userComment->count ? 'selected' : '' }}"
                                                            data-value="{{ $i }}">★</span>
                                                    @endfor
                                                    <form action="{{ route('user#comment') }}" method="POST"
                                                        class="row">
                                                        @csrf
                                                        <input type="hidden" name="productId" value="{{ $product->id }}">
                                                        <input type="hidden" name="rating" id="rating"
                                                            value="{{ $userComment->count }}">
                                                        <div class="col-12 mb-3">
                                                            <textarea name="review" rows="6" class="form-control" placeholder="Comment" required>{{ $userComment->comment }}</textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit"
                                                                class="btn btn-outline-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <div class="rate">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="star" data-value="{{ $i }}">★</span>
                                                @endfor
                                            </div>

                                            <form id="reviewForm" action="{{ route('user#comment') }}" method="POST"
                                                class="row">
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
                                    </div>

                                    <br>
                                    <h3 class="tab-title mt-2">Product Reviews</h3>
                                    <div class="product-review">
                                        @foreach ($comments as $comment)
                                            @php
                                                $profile = $comment->profile;
                                                $imgSrc = $profile
                                                    ? (filter_var($profile, FILTER_VALIDATE_URL)
                                                        ? $profile
                                                        : asset('profileImage/' . $profile))
                                                    : asset('default/default-profile.png');
                                            @endphp
                                            <div class="media">
                                                <img src="{{ $imgSrc }}" alt="avatar"
                                                    style="width:45px;height:45px;object-fit:cover;"
                                                    class="img-profile rounded-circle me-2">
                                                <div class="media-body">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="ratedStar {{ $i <= $comment->count ? 'selected' : '' }}"
                                                            style="font-size:20px;">★</span>
                                                    @endfor
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="name">
                                                            <h5>{{ $comment->name }}</h5>
                                                        </div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm text-muted p-0" type="button"
                                                                id="dropdownMenuButton{{ $comment->comment_id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuButton{{ $comment->comment_id }}">
                                                                <li><a class="dropdown-item" href="#">Report</a>
                                                                </li>
                                                                @if (Auth::id() === $comment->user_id)
                                                                    <li>
                                                                        <form action="{{ route('user#commentDelete') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="currentComment"
                                                                                value="{{ $comment->comment_id }}">
                                                                            <button class="dropdown-item text-danger"
                                                                                type="submit">Delete</button>
                                                                        </form>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="date">
                                                        <p>{{ $comment->created_at->format('F d, Y') }}</p>
                                                    </div>
                                                    <div class="review-comment">
                                                        <p class="fs-5">{{ $comment->comment }}</p>
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

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="widget price text-center">
                            <h4>Price</h4>
                            <p>{{ $product->sale_price }} MMK</p>
                        </div>
                        <h6 class="text-danger @if ($product->stock > 5) text-muted @endif">Stock:
                            {{ $product->stock }} item(s) left</h6>

                        {{-- Add to Cart start --}}
                        @if (Auth::user())
                            <form id="cartForm" method="POST" action="{{ route('user#addToCart') }}">
                                @csrf
                                <input type="hidden" name="productId" value="{{ $product->id }}">

                                <label for="quantity" class="form-label fw-bold">Quantity</label>
                                <div class="input-group" style="max-width:150px;">
                                    <button class="btn btn-outline-primary rounded-pill" type="button" id="btn-minus"
                                        @if ($product->stock == 0) disabled @endif>
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <input type="hidden" id="maxStock" value="{{ $product->stock }}">
                                    <input type="number" id="quantity" name="quantity"
                                        class="form-control text-center border-0"
                                        value="{{ $product->stock == 0 ? 0 : 1 }}" min="0"
                                        style="background-color:rgba(240,255,255,0.921);"
                                        @if ($product->stock == 0) readonly @endif>

                                    <button class="btn btn-outline-primary rounded-pill" type="button" id="btn-plus"
                                        @if ($product->stock == 0) disabled @endif>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" name="action" value="addToCart"
                                        class="btn btn-outline-primary flex-fill"
                                        @if ($product->stock == 0) disabled @endif>
                                        <i class="fa-solid fa-cart-plus p-2 fs-5"></i>Add to Cart
                                    </button>
                                </div>
                            </form>
                        @endif
                        {{-- Add to Cart end --}}

                        @php
                            $shuffledProducts = $relatedProducts->shuffle()->take(2);
                        @endphp
                        @foreach ($shuffledProducts->shuffle() as $item)
                            <div class="row my-3">
                                <div class="card h-100 border border-secondary">
                                    <a href="{{ route('user#productDetail', $item->id) }}">
                                        <img src="{{ asset('productImage/' . $item->image) }}"
                                            class="card-img-top img-fluid rounded-top"
                                            style="width:100%;height:auto;object-fit:cover;" alt="">
                                    </a>
                                    <div class="text-white bg-secondary px-2 py-1 rounded-pill position-absolute"
                                        style="top:8px; left:8px; font-size:0.75rem;">
                                        {{ $item->category_name ?? 'No Category' }}
                                    </div>
                                    <div class="card-body d-flex flex-column p-2">
                                        <h6 class="card-title mb-1">{{ $item->name }}</h6>
                                        <p class="card-text mb-2"
                                            style="max-height:50px;overflow:hidden;font-size:0.85rem;">
                                            {{ Str::words($item->description, 10, '...') }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <h6 class="text-primary mb-0" style="font-size:0.9rem;">
                                                {{ $item->sale_price }} MMK</h6>
                                            <form action="{{ route('user#addToCart') }}" method="POST"
                                                class="add-to-cart-form d-inline">
                                                @csrf
                                                <input type="hidden" name="productId" value="{{ $item->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="btn btn-primary rounded-pill btn-sm d-inline-flex align-items-center">
                                                    <i class="fa-solid fa-cart-shopping me-2"></i>
                                                    Add to Cart
                                                </button>
                                            </form>
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
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartForms = document.querySelectorAll('.add-to-cart-form');

            cartForms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        if (response.ok) {
                            const data = await response.json();

                            const toastLiveExample = document.getElementById('liveToast');
                            const toastBody = toastLiveExample.querySelector('.toast-body');

                            toastBody.textContent = data.message || 'Product added to cart';

                            const toast = new bootstrap.Toast(toastLiveExample);
                            toast.show();

                        } else {
                            alert('Failed to add to cart');
                        }

                    } catch (error) {
                        console.error(error);
                        alert('Something went wrong.');
                    }
                });
            });
            const cartForm = document.getElementById('cartForm');
            if (cartForm) {
                cartForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // prevent normal form submit

                    const formData = new FormData(cartForm);

                    fetch(cartForm.getAttribute('action'), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Show toast
                            const toastEl = document.getElementById('liveToast');
                            toastEl.querySelector('.toast-body').innerText = data.message;
                            const toast = new bootstrap.Toast(toastEl);
                            toast.show();

                            // Optionally reset quantity to 1
                            const quantityInput = document.getElementById('quantity');
                            if (quantityInput && parseInt(quantityInput.value) > 1) {
                                quantityInput.value = 1;
                            }
                        })
                        .catch(err => console.error(err));
                });
            }
        });

        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const quantityInput = document.getElementById('quantity');
        const maxStock = document.getElementById('maxStock');

        if (quantityInput && maxStock) {
            const max = parseInt(maxStock.value);

            btnMinus?.addEventListener('click', () => {
                let val = parseInt(quantityInput.value);
                if (val > 1) quantityInput.value = val - 1;
            });

            btnPlus?.addEventListener('click', () => {
                let val = parseInt(quantityInput.value);
                if (val < max) quantityInput.value = val + 1;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editReviewBtn');
            if (editBtn) {
                editBtn.addEventListener('click', () => {
                    editBtn.classList.add('d-none');
                    document.getElementById('authUserRating').classList.add('d-none');
                    document.querySelector('.edit_review').classList.remove('d-none');
                });
            }

            let stars = document.querySelectorAll('.star');
            let ratingInput = document.getElementById('rating');

            stars.forEach(function(star) {
                star.addEventListener('click', function() {
                    let rating = this.getAttribute('data-value');
                    ratingInput.value = rating;

                    stars.forEach(function(s, index) {
                        if (index < rating) s.classList.add('selected');
                        else s.classList.remove('selected');
                    });
                });
            });
        });
    </script>
@endsection
