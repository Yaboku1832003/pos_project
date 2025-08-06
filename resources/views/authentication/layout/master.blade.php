<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Auth Page')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS (in <head>) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle with Popper (before </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .bg-blue {
            background: linear-gradient(to bottom right, #1e3a8a, #2563eb);
            color: white;
        }

        .toggle-theme {
            cursor: pointer;
        }
    </style>
</head>

<body>
    {{-- nav start --}}
    <div>
        <nav class="navbar navbar-expand-lg shadow-sm py-1" id="main-navbar">
            <div class="container py-1 fs-5 d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/1356/1356559.png" alt=""
                        class="rounded-circle pe-2" style="height:30px;">
                    <a class="navbar-brand fw-bold fs-4" href="#">E-comerce</a>
                </div>

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
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
                </div>

                <!-- Sign Up / Sign In Button -->
                <div class="d-none d-lg-block">
                    <a href="#" class="btn btn-outline-primary fw-semibold">Sign In / Sign Up</a>
                </div>
            </div>
        </nav>

    </div>
    {{-- nav end --}}
    <main>

        @yield('content')

    </main>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.querySelector('#toggle-theme');
            const themeIcon = document.querySelector('#theme-icon');
            const navbar = document.querySelector('#main-navbar');
            const html = document.documentElement;

            themeToggle?.addEventListener('click', () => {
                const currentTheme = html.dataset.bsTheme;
                let newTheme;

                if (currentTheme === 'light') {
                    newTheme = 'dark';
                } else {
                    newTheme = 'light';
                }

                html.dataset.bsTheme = newTheme;

                if (newTheme === 'dark') {
                    themeIcon.className = 'fa-solid fa-moon';
                    navbar.classList.remove('navbar-light', 'bg-light');
                    navbar.classList.add('navbar-dark', 'bg-dark');
                } else {
                    themeIcon.className = 'fa-solid fa-sun';
                    navbar.classList.remove('navbar-dark', 'bg-dark');
                    navbar.classList.add('navbar-light', 'bg-light');
                }
            });
        });
    </script> --}}
</body>

</html>
