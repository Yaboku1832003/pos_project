@extends('authentication.layout.master')

@section('title', 'Login')

@section('content')
<div class="min-vh-100 d-flex">

        <!-- Left side with form -->
    <div class="d-flex flex-fill justify-content-center align-items-center bg-white p-5">
        <div style="width: 100%; max-width: 380px;">
            <h4 class="mb-4 text-center">Login to continue</h4>

            <form method="POST" action="{{ url('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <input type="email"
                           name="email"
                           id="email"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required autofocus
                           class="form-control rounded-pill px-3 py-2 border-primary">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="Password"
                           required
                           class="form-control rounded-pill px-3 py-2 border-primary">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label for="remember" class="form-check-label">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small">Forgot password?</a>
                </div>

                <!-- Login button -->
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">LOGIN</button>
            </form>

            <!-- Sign up link -->
            <div class="text-center mt-3">
                <small>Don't have an account?
                    <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a>
                </small>
            </div>

            <!-- Social Login -->
            <div class="text-center my-3">
                <small>or sign up using</small>
                <div class="mt-2">
                    <a href="{{ route('socialLogin', 'google') }}" class="btn btn-outline-danger rounded-circle mx-1">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="{{ route('socialLogin', 'github') }}" class="btn btn-outline-dark rounded-circle mx-1">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right side with image -->
    <div class="d-none d-md-flex flex-fill bg-light justify-content-center align-items-center"
         style="background: url('{{ asset('loginImage/Big_phone_with_cart.jpg') }}') center/cover no-repeat;">
        <!-- Optional overlay or branding -->
    </div>


</div>
@endsection
