@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 card p-3 shadow-sm rounded">

                <div class="d-flex justify-content-end">
                    <a href="{{route('account#adminList')}}"
                        class="btn bg-danger my-2 w-25 rounded shadow-sm text-white d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users"></i>
                        <span class="d-none d-md-inline ms-2">Admin List</span>
                    </a>

                </div>

                <div class="card-title bg-primary text-white p-3 h5">New Admin Account</div>

                <form action="{{ route('account#createNewAdmin') }}" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name...">
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email...">
                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Phone...">
                            @error('phone')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group" style="position: relative;">
                                <input type="password" name="password" value="" class="form-control pe-5"
                                    id="password" placeholder="Enter Password..."
                                    style="@error('password') border-color: #dc3545; box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25); @enderror">
                                <span id="togglePassword"
                                    style="
                                        position: absolute;
                                        top: 50%;
                                        right: 12px;
                                        cursor: pointer;
                                        z-index: 10;
                                        color: #6c757d;
                                        transform: translateY(-50%);
                                        transition: color 0.3s ease;
                                        @error('password') color: #dc3545; @enderror
                                    ">
                                    <i class="fa-solid fa-eye-slash" id="eyeIcon" style="font-size: 1.2rem;"></i>
                                </span>
                            </div>
                            @error('password')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group" style="position: relative;">
                                <input type="password" name="confirmPassword" value="" class="form-control pe-5"
                                    id="confirmPassword" placeholder="Enter Confirm Password..."
                                    style="@error('confirmPassword') border-color: #dc3545; box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25); @enderror">
                                <span id="toggleConfirmPassword"
                                    style="
                                        position: absolute;
                                        top: 50%;
                                        right: 12px;
                                        cursor: pointer;
                                        z-index: 10;
                                        color: #6c757d;
                                        transform: translateY(-50%);
                                        transition: color 0.3s ease;
                                        @error('confirmPassword') color: #dc3545; @enderror
                                    ">
                                    <i class="fa-solid fa-eye-slash" id="eyeIconConfirm" style="font-size: 1.2rem;"></i>
                                </span>
                            </div>
                            @error('confirmPassword')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Create Account" class="btn btn-primary w-100 rounded shadow-sm">
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('passwordToggle')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                password.type = "password";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPassword = document.getElementById('confirmPassword');
            const icon = document.getElementById('eyeIconConfirm');

            if (confirmPassword.type === "password") {
                confirmPassword.type = "text";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                confirmPassword.type = "password";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    </script>
@endsection
