@extends('authentication.layout.master')

@section('title', 'Register')

@section('content')
<div class="min-vh-100 d-flex flex-column flex-md-row">
    <!-- Form side (now on the left) -->
    <div class="d-flex flex-fill justify-content-center align-items-center bg-white p-5 order-1 order-md-0">
        <div style="width: 100%; max-width: 380px;">
            <h4 class="mb-4 text-center">Create Account</h4>

            <form method="POST" action="{{ url('register') }}">
                @csrf

                <div class="mb-3">
                    <input name="name" type="text" class="form-control rounded-pill px-3 py-2 border-primary" placeholder="Name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <input name="email" type="email" class="form-control rounded-pill px-3 py-2 border-primary" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <input name="phone" type="text" class="form-control rounded-pill px-3 py-2 border-primary" placeholder="Phone (optional)" value="{{ old('phone') }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <input name="password" type="password" class="form-control rounded-pill px-3 py-2 border-primary" placeholder="Password" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <input name="password_confirmation" type="password" class="form-control rounded-pill px-3 py-2 border-primary" placeholder="Confirm Password" required>
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">SIGN UP</button>
            </form>

            <!-- Social Sign Up -->
            {{-- <div class="text-center my-3">
                <small>or sign up using</small>
                <div class="mt-2">
                    <a href="{{ route('socialLogin', 'google') }}" class="btn btn-outline-danger rounded-circle mx-1">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="{{ route('socialLogin', 'github') }}" class="btn btn-outline-dark rounded-circle mx-1">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div> --}}

            <div class="text-center mt-3">
                <small>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a></small>
            </div>
        </div>
    </div>

    <!-- Image side (now on the right) -->
    <div class="d-none d-md-flex flex-fill bg-light justify-content-center align-items-center order-0 order-md-1"
         style="background: url('{{ asset('loginImage/Big_phone_with_cart.jpg') }}') center/cover no-repeat;">
    </div>
</div>
@endsection
