<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | POS Project</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f0f2f5;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .auth-card {
      max-width: 480px;
      width: 100%;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      padding: 50px 40px;
      text-align: center;
      transition: all 0.3s ease;
    }
    .auth-card img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);

        }

    .auth-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .auth-logo {
      width: 100px;
      height: 100px;
      margin: 0 auto 20px auto;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #0d6efd;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .auth-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: #0d6efd;
      margin-bottom: 10px;
    }

    .auth-desc {
      font-size: 0.95rem;
      color: #6c757d;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #dee2e6;
      height: 48px;
      transition: all 0.2s;
    }

    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
    }

    .btn-primary {
      border-radius: 10px;
      font-weight: 600;
      padding: 12px 0;
      transition: all 0.2s;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
      transform: translateY(-1px);
    }

    .back-link {
      margin-top: 20px;
    }

    .back-link a {
      color: #0d6efd;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }

    .back-link a:hover {
      color: #094bbf;
    }

    @media (max-width: 576px) {
      .auth-card {
        padding: 40px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="auth-card">
    {{-- Optional logo --}}
    <img src="{{ asset('images/reset-password.jpg') }}" alt="Reset Password" class="auth-logo">

    <h2 class="auth-title">Reset Password</h2>
    <p class="auth-desc">Enter your new password below to reset your account.</p>

    <form method="POST" action="{{ route('password.store') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <div class="mb-3 text-start">
        <label for="email" class="form-label fw-semibold">Email address</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
               name="email" value="{{ old('email', $request->email) }}" required autofocus>
        @error('email')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="mb-3 text-start">
        <label for="password" class="form-label fw-semibold">New Password</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
               name="password" required>
        @error('password')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="mb-3 text-start">
        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
        <input id="password_confirmation" type="password" class="form-control"
               name="password_confirmation" required>
      </div>

      <div class="d-grid mt-3">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-key me-2"></i> Reset Password
        </button>
      </div>
    </form>

    <div class="back-link">
      <a href="{{ route('login') }}">← Back to Login</a>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
