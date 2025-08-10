@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="">
            <div class="row">
                <div class="col-8 offset-2">

                    <div class="card">
                        {{-- card body start --}}
                        <div class="card-body shadow">
                            {{-- form start --}}
                            <form action="" method="post" class="p-3 rounded">
                                @csrf
                                {{-- old password start --}}
                                <div class="mb-3">
                                    <label class="form-label @error('oldPassword') is-invalid @enderror">Old
                                        Password</label>
                                    <div class="input-group" style="position: relative;">
                                        <input type="password" name="oldPassword" value="" class="form-control pe-5"
                                            id="oldPassword" placeholder="Enter Password..."
                                            style="@error('oldPassword') border-color: #dc3545; box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25); @enderror">
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
                                        @error('oldPassword') color: #dc3545; @enderror
                                    ">
                                            <i class="fa-solid fa-eye-slash" id="eyeIcon" style="font-size: 1.2rem;"></i>
                                        </span>
                                    </div>
                                    @error('oldPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- old password end --}}

                                {{-- new password start --}}
                                <div class="mb-3">
                                    <label class="form-label @error('newPassword') is-invalid @enderror">Confirm
                                        Password</label>
                                    <div class="input-group" style="position: relative;">
                                        <input type="password" name="newPassword" value=""
                                            class="form-control pe-5" id="newPassword"
                                            placeholder="Enter Confirm Password..."
                                            style="@error('newPassword') border-color: #dc3545; box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25); @enderror">
                                        <span id="toggleNewPassword"
                                            style="
                                        position: absolute;
                                        top: 50%;
                                        right: 12px;
                                        cursor: pointer;
                                        z-index: 10;
                                        color: #6c757d;
                                        transform: translateY(-50%);
                                        transition: color 0.3s ease;
                                        @error('newPassword') color: #dc3545; @enderror
                                    ">
                                            <i class="fa-solid fa-eye-slash" id="eyeIconNew"
                                                style="font-size: 1.2rem;"></i>
                                        </span>
                                    </div>
                                    @error('confirmPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- new password end --}}


                                {{-- confrim password start --}}
                                <div class="mb-3">
                                    <label class="form-label @error('confirmPassword') is-invalid @enderror">Confirm
                                        Password</label>
                                    <div class="input-group" style="position: relative;">
                                        <input type="password" name="confirmPassword" value=""
                                            class="form-control pe-5" id="confirmPassword"
                                            placeholder="Enter Confirm Password..."
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
                                            <i class="fa-solid fa-eye-slash" id="eyeIconConfirm"
                                                style="font-size: 1.2rem;"></i>
                                        </span>
                                    </div>
                                    @error('confirmPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- confirm password end --}}

                                {{-- submit btn --}}
                                <input type="submit" value="Change" class="btn bg-primary text-white">
                                {{-- submit btn --}}
                            </form>
                            {{-- form end --}}
                        </div>
                        {{-- card body end --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection


@section('passwordToggle')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('oldPassword');
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

        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const password = document.getElementById('newPassword');
            const icon = document.getElementById('eyeIconNew');

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
