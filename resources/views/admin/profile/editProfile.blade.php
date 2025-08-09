@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 col-md-8 mx-auto">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Admin Profile (<span class="text-danger">{{ Auth::user()->role }}</span>)</h6>
                <button id="editBtn" class="btn btn-sm btn-primary">Edit Profile</button>
                <button id="cancelBtn" class="btn btn-sm btn-secondary d-none">Cancel</button>
            </div>

            {{-- Display profile info --}}
            <div id="profileDisplay" class="card-body">
                <div class="row">
                    <div class="col-3 text-center me-4">
                        <img src="{{ Auth::user()->profile ? asset('profileImage/' . Auth::user()->profile) : asset('default/default-profile.png') }}"
                            alt="Profile Picture" class="rounded-circle border"
                            style="width: 180px; height: 180px; object-fit: cover;">
                    </div>

                    <div class="col-9">
                        <p><strong>Name:</strong> {{ Auth::user()->name ?? Auth::user()->nickname }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
                        <p><strong>Address:</strong> {{ Auth::user()->address }}</p>
                        <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div>

            {{-- Edit profile form (hidden in default state by d-none in class) --}}
            <form id="profileForm" action="{{ route('profile#update') }}" method="post" enctype="multipart/form-data" class="card-body d-none">
                @csrf


                <div class="row">
                    <div class="col-3 text-center">
                        <input type="file" accept="image/*" name="image" id="profileImage" class="d-none @error('image') is-invalid @enderror" onchange="loadFile(event)">
                        <span></span>
                        @error('image')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <label for="profileImage" style="cursor: pointer;">
                            <img id="output" src="{{ Auth::user()->profile ? asset('profileImage/' . Auth::user()->profile) : asset('default/default-profile.png') }}"
                                alt="Profile Picture" class="rounded-circle border"
                                style="width: 180px; height: 180px; object-fit: cover;"
                                title="Click to change profile picture">
                        </label>
                    </div>

                    <div class="col-9">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Name..." value="{{ old('name', Auth::user()->name ?? Auth::user()->nickname) }}">
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email..." value="{{ old('email', Auth::user()->email) }}">
                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                placeholder="09xxxxxx" value="{{ old('phone', Auth::user()->phone) }}">
                            @error('phone')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Address" value="{{ old('address', Auth::user()->address) }}">
                            @error('address')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <a href="{{ route('profile#changePassword') }}">Change password</a>
                        </div>

                        <input type="submit" value="Update Profile" class="btn btn-primary mt-3">
                    </div>
                </div>
            </form>

        </div>

    </div>

    <script>
        // Toggle between display and form on edit and cancel buttons
        const editBtn = document.getElementById('editBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const profileDisplay = document.getElementById('profileDisplay');
        const profileForm = document.getElementById('profileForm');

        editBtn.addEventListener('click', () => {
            profileDisplay.classList.add('d-none');
            profileForm.classList.remove('d-none');
            editBtn.classList.add('d-none');
            cancelBtn.classList.remove('d-none');
        });

        cancelBtn.addEventListener('click', () => {
            profileDisplay.classList.remove('d-none');
            profileForm.classList.add('d-none');
            editBtn.classList.remove('d-none');
            cancelBtn.classList.add('d-none');
            location.reload();
        });
    </script>
@endsection
