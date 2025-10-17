<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Auth Page')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    /* Navbar Styling */
    #main-navbar {
      background-color: #ffffff;
      padding: 1.5rem 1rem; /* taller navbar */
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
      transition: all 0.3s ease-in-out;
    }

    #main-navbar .navbar-brand {
      font-size: 2rem;
      font-weight: 700;
      color: #0d6efd !important; /* Bootstrap primary blue */
      display: flex;
      align-items: center;
      gap: 0.3rem;
      overflow: hidden;
    }

    #main-navbar .navbar-brand span {
      display: inline-block;
      animation: float 2s ease-in-out infinite;
    }

    /* Stagger each character */
    #main-navbar .navbar-brand span:nth-child(1) { animation-delay: 0s; }
    #main-navbar .navbar-brand span:nth-child(2) { animation-delay: 0.1s; }
    #main-navbar .navbar-brand span:nth-child(3) { animation-delay: 0.2s; }
    #main-navbar .navbar-brand span:nth-child(4) { animation-delay: 0.3s; }
    #main-navbar .navbar-brand span:nth-child(5) { animation-delay: 0.4s; }
    #main-navbar .navbar-brand span:nth-child(6) { animation-delay: 0.5s; }
    #main-navbar .navbar-brand span:nth-child(7) { animation-delay: 0.6s; }
    #main-navbar .navbar-brand span:nth-child(8) { animation-delay: 0.7s; }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }

    #main-navbar .nav-link {
      color: #0d6efd !important; /* blue links */
      font-size: 1.1rem;
      font-weight: 500;
      transition: color 0.3s;
    }

    #main-navbar .nav-link:hover {
      color: #094bbf !important; /* darker blue hover */
    }

    /* Mobile Navbar Toggler */
    .navbar-toggler {
      border: none;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 54, 255, 1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    @media (min-width: 992px) {
      #main-navbar .navbar-nav {
        margin-left: auto;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg" id="main-navbar">
    <div class="container">
      <!-- Logo & Brand -->
      <a class="navbar-brand" href="{{ route('user#homePage') }}">
        <!-- Wrap each character in a span for floating -->
        <span><i class="fas fa-shopping-cart"></i></span>
        <span>I</span>
        <span>T</span>
        <span>&nbsp;</span>
        <span>M</span>
        <span>A</span>
        <span>R</span>
        <span>T</span>
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu Links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="{{ route('user#homePage') }}">Explore</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Main Content -->
  <main>
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
