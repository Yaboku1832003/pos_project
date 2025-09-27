<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>POS Admin Dashboard</title>
    {{-- bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet" />

    <style>
        /* Hide sidebar by default on small screens */
        @media (max-width: 992px) {
            #accordionSidebar {
                display: none;
                position: fixed;
                z-index: 1030;
                height: 100vh;
                overflow-y: auto;
                background: #4e73df;
                width: 250px;
                top: 0;
                left: 0;
                transition: all 0.3s ease;
            }

            #accordionSidebar.show-sidebar {
                display: block !important;
            }

            /* Show close button inside sidebar */
            #sidebarCloseBtn {
                display: block;
                color: white;
                font-size: 1.5rem;
                padding: 0.75rem 1rem;
                cursor: pointer;
                text-align: right;
            }
        }

        /* Hide toggle button on screens wider than 992px */
        @media (min-width: 992px) {
            #sidebarToggleTop {
                display: none;
            }

            /* Hide close button on large screens */
            #sidebarCloseBtn {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Close button visible only on small screens -->
            <li id="sidebarCloseBtn" title="Close sidebar"><i class="fas fa-times"></i></li>

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">E-commerce</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#dashboard') }}"><i
                        class="fas fa-fw fa-table"></i><span>Dashboard </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('category#list') }}"><i
                        class="fa-solid fa-circle-plus"></i><span>Category </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#createPage') }}"><i class="fa-solid fa-plus"></i><span>Add
                        Products </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#list') }}"><i
                        class="fa-solid fa-layer-group"></i><span>Product List </span></a>
            </li>

            @if (Auth::check() && Auth::user()->role === 'superadmin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('payment#paymentMethod') }}"><i
                            class="fa-solid fa-credit-card"></i><span>Payment Method </span></a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-list"></i><span>Sale Information </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin#orderList')}}"><i class="fa-solid fa-cart-shopping"></i><span>Order Board
                    </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile#changePassword') }}"><i
                        class="fa-solid fa-lock"></i><span>Change
                        Password </span></a>
            </li>

            <li class="nav-item">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <span class="nav-link">
                        <button type="submit" class="btn bg-dark text-white"><i
                                class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </span>
                </form>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Hamburger Toggle Button for Mobile -->
                    <button id="sidebarToggleTop" class="btn btn-link d-lg-none rounded-circle mr-3"
                        aria-label="Toggle sidebar">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}
                                </span>
                                    @php
                                        $profile = Auth::user()->profile;
                                        if ($profile) {
                                            // Check if it's a valid URL
                                            if (filter_var($profile, FILTER_VALIDATE_URL)) {
                                                $imgSrc = $profile; // use URL directly
                                            } else {
                                                $imgSrc = asset('profileImage/' . $profile); // local image file
                                            }
                                        } else {
                                            $imgSrc = asset('default/default-profile.png'); // fallback default
                                        }
                                    @endphp

                                <img src="{{ $imgSrc }}" style="width: 45px; height: 45px; object-fit: cover;"
                                    class="img-profile rounded-circle" alt="">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile#edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                {{-- superAdmin part start --}}
                                @if (Auth::check() && Auth::user()->role === 'superadmin')
                                    <a class="dropdown-item" href="{{ route('account#newAdminPage') }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Add New Admin Account
                                    </a>
                                    <a class="dropdown-item" href="{{ route('account#adminList') }}">
                                        <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Admin List
                                    </a>

                                    <a class="dropdown-item" href="{{ route('account#userList') }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        User List
                                    </a>
                                @endif
                                {{-- superAdmin part end --}}

                                <a class="dropdown-item" href="{{ route('profile#changePassword') }}">
                                    <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i> Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input type="submit" class="btn btn-dark text-white w-100" value="Logout" />
                                    </form>
                                </span>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                {{-- customized parts --}}
                @yield('content')

                {{-- sweet alert laravel configuration --}}
                @include('sweetalert::alert')

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    {{-- Bootstrap 5 js --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    {{-- <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script> --}}

    {{-- sweet alert cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- this js is in list.blade.php --}}
    @yield('js-sweetalert')

    {{-- password toggle js --}}
    @yield('passwordToggle')

    {{-- image display after choosen --}}
    {{-- for productCreate.blade.php & productEdit.php --}}
    <script>
        function loadFile(event) {
            var read = new FileReader();

            read.onload = function() {
                var output = document.getElementById('output');
                output.src = read.result;
            };
            read.readAsDataURL(event.target.files[0]);
        }

        // Sidebar toggle for screens smaller than 992px
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggleTop');
            const sidebar = document.getElementById('accordionSidebar');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        sidebar.classList.add('show-sidebar');
                    }
                });
            }

            if (closeBtn && sidebar) {
                closeBtn.addEventListener('click', function() {
                    sidebar.classList.remove('show-sidebar');
                });
            }
        });

    </script>
    @stack('scripts')
</body>

</html>
