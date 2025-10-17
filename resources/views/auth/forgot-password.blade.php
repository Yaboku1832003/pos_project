<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | POS Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f7, #dce7f9);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            max-width: 850px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .auth-card:hover {
            transform: translateY(-3px);
        }

        /* Left column */
        .auth-image {
            background: linear-gradient(135deg, #007bff, #0061d6);
            color: #fff;
            padding: 60px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .auth-image img {
            width: 260px;
            height: 260px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            margin-bottom: 25px;
        }
        .auth-image h3 {
            font-weight: 600;
            font-size: 1.4rem;
            margin-bottom: 10px;
        }
        .auth-image p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.85);
            text-align: center;
            max-width: 280px;
        }

        /* Right column */
        .auth-form {
            padding: 60px 50px;
        }
        .auth-form h3 {
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .auth-form p {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #ced4da;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
        }

        .btn-primary {
            border-radius: 10px;
            font-weight: 500;
            padding: 12px 0;
            background-color: #0d6efd;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-1px);
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
        }
        .back-link a {
            text-decoration: none;
            color: #0d6efd;
            font-weight: 500;
            transition: color 0.2s;
        }
        .back-link a:hover {
            color: #094bbf;
        }

        @media (max-width: 768px) {
            .auth-image {
                padding: 40px 20px;
            }
            .auth-form {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="row g-0">
        <!-- Left Side -->
        <div class="col-md-5 auth-image">
            <img src="{{ asset('images/forgetPassword.jpg') }}" alt="Forgot Password">
            <h3>Reset Your Password</h3>
            <p>We’ll send a link to your email so you can safely reset your password and regain access.</p>
        </div>

        <!-- Right Side -->
        <div class="col-md-7 bg-white auth-form">
            <div class="text-end">
                <a href="{{ route('login') }}" class="btn btn-sm text-muted fs-4"><i class="fa-solid fa-xmark"></i></a>
            </div>

            <h3>Forgot Password</h3>
            <p>Please enter your registered email address below.</p>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success small">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email address</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-envelope me-2"></i> Send Reset Link
                    </button>
                </div>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">← Back to Login</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
