@extends('user.layouts.master')

@section('title', 'Edit Profile')

@section('content')
<section class="section bg-light">
    <div class="container py-5">
        <div class="card shadow-sm border-0 rounded-4 p-4">

            {{-- Back Button --}}
            <div class="d-flex justify-content-end align-items-center mb-3">
                <a href="{{route('user#homePage')}}" class="btn btn-sm fs-2">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>

            {{-- Page Header --}}
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color:#0d6efd;">Edit Profile</h2>
                <p class="text-muted fs-6" style="line-height:1.6;">
                    Manage your account information and keep your profile up to date.
                </p>
            </div>

            <form action="{{ route('userProfile#update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4 align-items-start">

                    {{-- Profile Image --}}
                    <div class="col-md-4 text-center">
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset(Auth::user()->profile ? 'profileImage/' . Auth::user()->profile : 'default/default-profile.png') }}"
                                 class="rounded-circle border border-3 border-primary shadow-sm"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <label for="image"
                                   class="position-absolute bottom-0 end-0 bg-primary text-white p-2 rounded-circle shadow"
                                   style="cursor:pointer;">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" name="image" id="image" class="d-none">
                        </div>
                        <p class="text-muted small mt-2">Click the camera icon to update your photo.</p>
                    </div>

                    {{-- Profile Info --}}
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" class="form-control rounded-3"
                                   value="{{ old('name', Auth::user()->name) }}" placeholder="Your full name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control rounded-3"
                                   value="{{ old('email', Auth::user()->email) }}" placeholder="your@email.com">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control rounded-3"
                                   value="{{ old('phone', Auth::user()->phone) }}" placeholder="09xxxxxxxxx">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="address" class="form-control rounded-3" rows="3" placeholder="Your address">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('userProfile#changePasswordPage') }}" class="btn btn-outline-primary rounded-3 px-3">
                                <i class="fa-solid fa-lock me-2"></i> Change Password
                            </a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

{{-- Optional: Preview Selected Profile Image --}}
<script>
document.getElementById('image').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = e => {
        document.querySelector('img[alt="Profile Image"]').src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});
</script>

<style>
input.form-control, textarea.form-control {
    transition: all 0.2s ease-in-out;
    border: 1px solid #ddd;
}
input.form-control:focus, textarea.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
}
.btn-primary:hover {
    background-color: #0b5ed7;
}
</style>
@endsection
