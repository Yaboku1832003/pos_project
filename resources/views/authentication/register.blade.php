@extends('authentication.layout.master')

@section('title', 'Register')

@section('content')
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <div class="col-md-6 d-flex justify-content-center align-items-center p-4 bg-light">
                <div class="card shadow-sm w-100" style="max-width: 400px;">
                    <div class="card-body">
                        <h4 class="text-center mb-4">Sign Up</h4>
                        <form method="POST" action="{{ url('register') }}">
                            @csrf
                            <div class="mb-3">
                                <input name="name" type="text" class="form-control form-control-user"
                                    placeholder="Enter Name..." value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input name="email" type="email" class="form-control form-control-user"
                                    placeholder="Enter Email..." value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input name="phone" type="text" class="form-control form-control-user"
                                    placeholder="Enter phone..." value="{{ old('phone') }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input name="password" type="password" class="form-control form-control-user"
                                    placeholder="Enter password...">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">

                                <input name="password_confirmation" type="password" class="form-control form-control-user"
                                    placeholder="Re-Enter password...">
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Create Account</button>

                        </form>

                        <div class="text-center mt-3">
                            <small>Already have an account? <a href="{{ route('login') }}">Sign in</a></small>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
