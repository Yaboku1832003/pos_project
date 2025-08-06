@extends('authentication.layout.master')

@section('title', 'Login')

@section('content')
    <div class="container-fluid min-vh-100 d-flex flex-column flex-md-row">
        <!-- Image Side with Card -->
        <div class="bg-image d-flex justify-content-center align-items-center p-5 col-md-6 text-center"
            style="background: url('https://cdn.acowebs.com/wp-content/uploads/2019/02/Impact-of-eCommerce-On-Society.png') no-repeat center center; background-size: cover;">
            <div class="card bg-transparent text-white p-4 shadow-none border-0" style="max-width: 400px;">
                <h1 class="fw-bold">Welcome Back!</h1>
                <p class="mt-2">How's your day?</p>
                {{-- <button id="toggle-theme" class="btn btn-light btn-sm mt-3">Toggle Light/Dark</button> --}}
            </div>
        </div>

        <!-- Login Form -->
        <div class="d-flex flex-column justify-content-center align-items-center p-4 col-md-6">
            <div class="card shadow-sm w-100" style="max-width: 400px;">
                <div class="card-body">
                    <h4 class="text-center mb-4">Login</h4>
                    <form method="POST" action="{{ url('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" value="{{old('email')}}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control">
                            @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <button class="btn btn-primary w-100">Sign In</button>
                    </form>

                    <div class="text-center mt-3">
                        <small>Don't have an account? <a href="{{ route('register') }}">Sign up</a></small>
                    </div>

                    <hr>

                    <!-- Social Login Buttons -->
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('socialLogin', 'google') }}" class="btn btn-danger">
                            <i class="fa-brands fa-google"></i> Sign in with Google
                        </a>
                        <a href="{{ route('socialLogin', 'github') }}" class="btn btn-dark">
                            <i class="fa-brands fa-github"></i> Sign in with GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
