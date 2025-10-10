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

    @yield('css')
    <!-- CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/css/bootstrap-slider.min.css">

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/bootstrap-slider.min.js"></script>
</head>

<body>

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
                        <a href="" class="nav-item nav-link ">Shop</a>
                        <a href="" class="nav-item nav-link">Cart</a>
                        <a href="#" class="nav-item nav-link">Contact</a>
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
                                    <a href="" class="dropdown-item py-2 text-muted">My Orders</a>
                                    <a href="#" class="dropdown-item py-2 text-muted">Edit Profile</a>
                                    <a href="#" class="dropdown-item py-2 text-muted">Change Password</a>

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


    @yield('content')
    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 400px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="notificationList">
                    <div class="text-center text-muted">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    {{-- sweet alert laravel configuration --}}
    @include('sweetalert::alert')

    <!-- Footer Start -->
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer py-3">
        <div class="container py-3">
            <div class="row">
                <!-- Social Media (Horizontal) -->
                <div class="col-md-4 d-flex flex-column align-items-start">
                    <div class="mb-2 fw-bold">Follow Us:</div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-sm-square rounded-circle" href="#"
                            style="background-color:#1877F2; color:white;"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-sm-square rounded-circle" href="#"
                            style="background-color:#000000; color:white;"><i class="fab fa-tiktok"></i></a>
                        <a class="btn btn-sm-square rounded-circle" href="#"
                            style="background-color:#0088cc; color:white;"><i class="fab fa-telegram"></i></a>
                        <a class="btn btn-sm-square rounded-circle" href="#"
                            style="background-color:#C13584; color:white;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Links (Vertical) -->
                <div class="col-md-4 d-flex flex-column justify-content-start">
                    <a class="btn-link text-light mb-1" href="#">Our Policy</a>
                    <a class="btn-link text-light mb-1" href="#">Blog</a>
                    <a class="btn-link text-light mb-1" href="#">Contact Us</a>
                    <a class="btn-link text-light" href="#">About Us</a>
                </div>

                <!-- Payments (Vertical) -->
                <div class="col-md-4 d-flex flex-column align-items-start">
                    <div class="mb-2 fw-bold">Payments:</div>
                    <img src="img/kpay.png" alt="KPay" style="height:30px;" class="mb-1">
                    <img src="img/wavepay.png" alt="WavePay" style="height:30px;" class="mb-1">
                    <img src="img/cbpay.png" alt="CbPay" style="height:30px;">
                </div>
            </div>
        </div>

    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your
                            Site
                            Name</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    {{-- Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By
                    <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <div class="scroll-top-to">
        <i class="fa fa-angle-up"></i>
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
        // $('#notification-bell').click(function(e) {
        //     e.preventDefault(); // prevent following the link

        //     $.ajax({
        //         url: "/user/notifications/mark-all-read",
        //         type: "POST",
        //         data: {
        //             _token: "{{ csrf_token() }}"
        //         },
        //         success: function(res) {
        //             if (res.success) {
        //                 // Hide notification dot and count
        //                 $('#notification-dot').hide();
        //                 $('#notification-count').text(0).hide();
        //                 console.log('All notifications marked as read!');
        //             }
        //         },
        //         error: function(err) {
        //             console.error('Error marking notifications read:', err);
        //         }
        //     });

        // });
    </script>

    @yield('js')

</html>
