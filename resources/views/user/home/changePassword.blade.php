@extends('user.layouts.master')

@section('title', 'Change Password')

@section('content')
<section class="section bg-light" style="min-height:80vh; display:flex; align-items:center; justify-content:center;">
    <div class="card shadow-sm border-0 rounded-4 p-4" style="width: 400px;">
        <div class="d-flex justify-content-end align-items-center mb-3">
                <a href="{{route('user#homePage')}}" class="btn btn-sm fs-2">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>
        {{-- Page Header --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:#0d6efd;">Change Password</h2>
            <p class="text-muted fs-6" style="line-height:1.6;">
                Secure your account by updating your password regularly.
            </p>
        </div>

        {{-- Change Password Form --}}
        <form action="{{ route('userProfile#changePassword') }}" method="POST">
            @csrf

            <div class="form-group mb-3 position-relative">
                <label class="form-label fw-semibold">Current Password</label>
                <input type="password" name="oldPassword" class="form-control rounded-3 password-field" placeholder="Enter current password" required>
                <i class="fa-solid fa-eye-slash toggle-password" style="position:absolute; top:38px; right:10px; cursor:pointer;"></i>
                @error('oldPassword') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3 position-relative">
                <label class="form-label fw-semibold">New Password</label>
                <input type="password" name="newPassword" class="form-control rounded-3 password-field" placeholder="Enter new password" required>
                <i class="fa-solid fa-eye-slash toggle-password" style="position:absolute; top:38px; right:10px; cursor:pointer;"></i>
                @error('newPassword') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-4 position-relative">
                <label class="form-label fw-semibold">Confirm New Password</label>
                <input type="password" name="confirmPassword" class="form-control rounded-3 password-field" placeholder="Confirm new password" required>
                <i class="fa-solid fa-eye-slash toggle-password" style="position:absolute; top:38px; right:10px; cursor:pointer;"></i>
                @error('confirmPassword') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary rounded-3 px-4">
                    <i class="fa-solid fa-key me-2"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Show/Hide Password JS --}}
<script>
const toggles = document.querySelectorAll('.toggle-password');
toggles.forEach((toggle, index) => {
    toggle.addEventListener('click', () => {
        const input = toggle.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            toggle.classList.remove('fa-eye-slash');
            toggle.classList.add('fa-eye');
        } else {
            input.type = 'password';
            toggle.classList.remove('fa-eye');
            toggle.classList.add('fa-eye-slash');
        }
    });
});
</script>

<style>
.password-field {
    padding-right: 40px;
}
input.form-control {
    transition: all 0.2s ease-in-out;
    border: 1px solid #ddd;
}
input.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
}
.btn-primary:hover {
    background-color: #0b5ed7;
}
</style>
@endsection
