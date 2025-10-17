<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>IT Mart- Home Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('user/lib/lightbox/css/lightbox.min.css') }} " rel="stylesheet">
    <link href="{{ asset('user/lib/owlcarousel/assets/owl.carousel.min.css') }} " rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ asset('css/style.css') }} " rel="stylesheet">
    <!-- <link href="{{ asset('user/css/custom.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/bootstrap-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('css')
    <!-- CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/css/bootstrap-slider.min.css">

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/bootstrap-slider.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar start -->
    <div class="container-fluid fixed-top bg-white">
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-xl navigation">
                <a href="index.html" class="navbar-brand">
                    <h1 class="text-primary display-6">IT Mart</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{route('user#policy')}}" class="nav-item nav-link ">Policy</a>
                        <a href="{{route('user#aboutUs')}}" class="nav-item nav-link">About us</a>
                        <a href="{{route('user#contactUs')}}" class="nav-item nav-link">Contact us</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-end">


                        @if (Auth::user())
                            <a href="{{ route('user#cart') }}" class="position-relative me-4">
                                <i class="fa fa-shopping-cart fa-2x"></i>
                            </a>

                            {{-- notify the unread orders start --}}
                            <a href="{{ route('user#myNotifications') }}" class="position-relative me-4"
                                id="notification-bell">
                                <i class="fa-solid fa-bell fa-2x"></i>
                                <span id="notification-dot"
                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"
                                    style="display:none;">
                                </span>
                                <span id="notification-count"
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="display:none;">
                                </span>
                            </a>
                            {{-- notify the unread orders end --}}

                            <div class="nav-item dropdown d-flex align-items-center">
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    @php
                                        $profile = Auth::user()->profile;
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
                                    <img src="{{ $imgSrc }}"
                                        style="width: 45px; height: 45px; object-fit: cover;"
                                        class="img-profile rounded-circle me-2" alt="">
                                    <span>{{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end m-0 rounded border">
                                    <a href="{{ route('userProfile#edit') }}"
                                        class="dropdown-item py-2 text-muted">Edit Profile</a>
                                    <a href="{{ route('userProfile#changePasswordPage') }}"
                                        class="dropdown-item py-2 text-muted">Change Password</a>

                                    <div class="dropdown-item py-2">
                                        <form action="{{ route('logout') }}" method="post" class="p-0">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-outline-primary rounded w-100">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary mx-1">Sign In/Up</a>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <div class="flex-grow-1">
    @yield('content')
    </div>
    <!-- Notification Modal -->


    {{-- sweet alert laravel configuration --}}
    @include('sweetalert::alert')


    <!-- Footer Start -->
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer py-3">
        <div class="container py-3">
            <div class="row">

                <!-- Social Media -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">Follow Us</h5>
                    <div class="d-flex gap-2">
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle"
                            style="width:40px; height:40px; background-color:#1877F2; color:white; text-decoration:none;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle"
                            style="width:40px; height:40px; background-color:#000000; color:white; text-decoration:none;">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle"
                            style="width:40px; height:40px; background-color:#0088cc; color:white; text-decoration:none;">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle"
                            style="width:40px; height:40px; background-color:#C13584; color:white; text-decoration:none;">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Useful Links -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <div class="d-flex flex-column gap-2">
                        {{-- <a href="#" style="color:#f1f1f1; text-decoration:none;">Our Policy</a> --}}
                        <a href="{{route('user#policy')}}" style="color:#f1f1f1; text-decoration:none;">Our Policy</a>
                        <a href="{{route('user#contactUs')}}" style="color:#f1f1f1; text-decoration:none;">Contact Us</a>
                        <a href="{{route('user#aboutUs')}}" style="color:#f1f1f1; text-decoration:none;">About Us</a>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">Payments</h5>
                    <div class="d-flex gap-3 align-items-center">
                        <img src="{{ asset('paymentMethods/KBZpay.png') }}" alt="KPay"
                            style="width:50px; height:50px; object-fit:contain; transition: transform 0.3s, filter 0.3s; cursor:pointer;"
                            onmouseover="this.style.transform='scale(1.1)'; this.style.filter='brightness(1.2)';"
                            onmouseout="this.style.transform='scale(1)'; this.style.filter='brightness(1)';">
                        <img src="{{ asset('paymentMethods/CBpay.png') }}" alt="WavePay"
                            style="width:50px; height:50px; object-fit:contain; transition: transform 0.3s, filter 0.3s; cursor:pointer;"
                            onmouseover="this.style.transform='scale(1.1)'; this.style.filter='brightness(1.2)';"
                            onmouseout="this.style.transform='scale(1)'; this.style.filter='brightness(1)';">
                        <img src="{{ asset('paymentMethods/AYApay.png') }}" alt="CbPay"
                            style="width:50px; height:50px; object-fit:contain; transition: transform 0.3s, filter 0.3s; cursor:pointer;"
                            onmouseover="this.style.transform='scale(1.1)'; this.style.filter='brightness(1.2)';"
                            onmouseout="this.style.transform='scale(1)'; this.style.filter='brightness(1)';">
                    </div>
                </div>
            </div>
        </div>

            <!-- Footer Bottom -->
            <div class="text-center mt-4 pt-3" style="border-top: 1px solid #333;">
                <small>&copy; 2025 YourCompany. All rights reserved.</small>
            </div>
        </div>
    </div>

    <!-- Footer End -->

    <!-- Back to Top -->
    <div class="scroll-top-to"
        style="position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px;
            background: linear-gradient(135deg,#00aaff,#0077cc);
            color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3); font-size: 1.2rem; transition: transform 0.3s;">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- Toast Notification -->
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="3000"
            style="border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.25); border: none; background-color: #0077cc;">
            <div class="toast-header"
                style="background-color: #00aaff; border-bottom: 1px solid rgba(255,255,255,0.2);">
                <strong class="me-auto" style="color: #f1f1f1;">Notification</strong>
                <small style="color: #e0f7ff;">Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"
                    style="filter: invert(1);"></button>
            </div>
            <div class="toast-body" style="color: #e0f7ff; font-size: 0.95rem; line-height: 1.4;">
            </div>
        </div>
    </div>


    <!-- <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a> -->
    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/lib/easing/easing.min.js') }} "></script>
    <script src="{{ asset('user/lib/waypoints/waypoints.min.js') }} "></script>
    <script src="{{ asset('user/lib/lightbox/js/lightbox.min.js') }} "></script>
    <script src="{{ asset('user/lib/owlcarousel/owl.carousel.min.js') }} "></script>
    <script src="{{ asset('plugins/bootstrap/bootstrap-slider.js') }}"></script>
    <script src="{{ asset('plugins/tether/js/tether.min.js') }}"></script>
    <script src="{{ asset('plugins/raty/jquery.raty-fa.js') }}"></script>
    <script src="{{ asset('plugins/slick/slick.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('plugins/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            // get orderNotification order and show order count start
            function fetchNotifications() {
                $.ajax({
                    url: '/user/notifications/count',
                    type: "GET",
                    success: function(response) {
                        console.log("Notification response:", response);
                        if (response.count > 0) {
                            $("#notification-dot").show();
                            $("#notification-count").text(response.count).show();
                        } else {
                            $("#notification-dot").hide();
                            $("#notification-count").hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching notifications:", error);
                    }
                });
            }
            // get orderNotification order and show order count end

            // Run once when page loads
            fetchNotifications();

            // Auto refresh every 10s
            setInterval(fetchNotifications, 10000);
        });
    </script>

    @yield('js')

</html>
