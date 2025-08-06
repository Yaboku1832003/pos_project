@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container-fluid min-vh-100 d-flex flex-column flex-md-row">
    <!-- Blue Side -->
    <div class="d-flex flex-column justify-content-center align-items-center p-5 col-md-6 text-center">
        <h1 class="fw-bold">Join Us!</h1>
        <p class="mt-2">Create your account to get started.</p>
        <button id="toggle-theme" class="btn btn-light btn-sm mt-3"><i id="theme-icon" class="fa-solid fa-moon"></i></button>
    </div>

    <!-- Register Form -->
    <div class="d-flex flex-column justify-content-center align-items-center p-4 col-md-6">
        <div class="card shadow-sm w-100" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="text-center mb-4">Register</h4>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Name</label>
                        <input name="name" type="text" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input name="password_confirmation" type="password" class="form-control" required>
                    </div>
                    <button class="btn btn-success w-100">Sign Up</button>
                </form>
                <div class="text-center mt-3">
                    <small>Already have an account? <a href="{{ route('login') }}">Login</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
