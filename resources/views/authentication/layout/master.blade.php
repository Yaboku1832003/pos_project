<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Auth Page')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Updated Navbar Style */
        #main-navbar {
            background: linear-gradient(to right, #3b82f6, #60a5fa); /* Lighter blue */
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Realistic shadow */
            transition: all 0.3s ease-in-out;
        }

        #main-navbar .navbar-brand {
            font-size: 1.6rem; /* Larger brand text */
            font-weight: 700;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        #main-navbar .nav-link {
            color: white !important;
            font-size: 1.05rem; /* Slightly bigger menu text */
            font-weight: 500;
            padding-left: 1rem;
            padding-right: 1rem;
            transition: color 0.3s ease;
        }

        #main-navbar .nav-link:hover {
            color: #facc15 !important; /* Yellow highlight on hover */
        }

        #main-navbar .btn-outline-primary {
            border-color: white;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            transition: 0.3s;
        }

        #main-navbar .btn-outline-primary:hover {
            background-color: white;
            color: #2563eb;
        }

        /* Mobile Menu */
        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255, 1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg absolute top-0" id="main-navbar">
        <div class="container">
            <!-- Logo & Brand -->
            <a class="navbar-brand" href="#">
                <i class="fas fa-shopping-cart"></i> E-commerce
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="#">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Contact Us</a>
                    </li>
                </ul>

                {{-- <!-- Sign In / Sign Up Button -->
                <div class="text-center text-lg-end mt-3 mt-lg-0">
                    <a href="#" class="btn btn-outline-primary rounded-pill">Sign In / Sign Up</a>
                </div> --}}
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

</body>
</html>
