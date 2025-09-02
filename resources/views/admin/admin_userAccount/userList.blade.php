@extends('admin.layouts.master')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('account#adminList') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fa-solid fa-user-shield me-1"></i> Admin List
        </a>

        <form action="{{ route('account#userList') }}" method="get" class="w-50">
            <div class="input-group shadow-sm">
                <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control" placeholder="Search users...">
                <button type="submit" class="btn btn-dark">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="card shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa-solid fa-users me-2"></i> User List</h5>
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center" style="font-size:0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th>Platform</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>

                                <!-- Profile -->
                                <td>
                                    @php
                                        $profile = $user->profile;
                                        $imgSrc = $profile
                                            ? (filter_var($profile, FILTER_VALIDATE_URL) ? $profile : asset('profileImage/' . $profile))
                                            : asset('default/default-profile.png');
                                    @endphp
                                    <img src="{{ $imgSrc }}" alt="Profile" class="rounded-circle shadow-sm"
                                         style="width:55px; height:55px; object-fit:cover;"
                                         title="{{ $user->name ?? $user->nickname ?? 'No Name' }}">
                                </td>

                                <!-- Name -->
                                <td>
                                    @if($user->name || $user->nickname)
                                        {{ $user->name ?? $user->nickname }}
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-user me-1"></i>No Data</span>
                                    @endif
                                </td>

                                <!-- Email -->
                                <td>
                                    @if($user->email)
                                        {{ $user->email }}
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-envelope me-1"></i>No Data</span>
                                    @endif
                                </td>

                                <!-- Address -->
                                <td>
                                    @if($user->address)
                                        {{ $user->address }}
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-map-marker-alt me-1"></i>No Data</span>
                                    @endif
                                </td>

                                <!-- Phone -->
                                <td>
                                    @if($user->phone)
                                        {{ $user->phone }}
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-phone me-1"></i>No Data</span>
                                    @endif
                                </td>

                                <!-- Role -->
                                <td>
                                    <span class="badge bg-info text-dark px-2 py-1 rounded-pill shadow-sm">
                                        <i class="fa-solid fa-user-tag me-1"></i> {{ ucfirst($user->role ?? 'No Data') }}
                                    </span>
                                </td>

                                <!-- Created Date -->
                                <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>

                                <!-- Platform -->
                                <td>
                                    @if ($user->provider == 'google')
                                        <i class="fa-brands fa-google text-danger" style="font-size:2rem; text-shadow:0 0 2px rgba(0,0,0,0.2);" title="Google Login"></i>
                                    @elseif ($user->provider == 'github')
                                        <i class="fa-brands fa-github text-dark" style="font-size:2rem; text-shadow:0 0 2px rgba(0,0,0,0.2);" title="GitHub Login"></i>
                                    @else
                                        <i class="fa-solid fa-user-circle text-primary" style="font-size:2rem; text-shadow:0 0 2px rgba(0,0,0,0.2);" title="Local Login"></i>
                                    @endif
                                </td>

                                <!-- Action -->
                                <td>
                                    <button type="button" onclick="deleteButton({{ $user->id }})" class="btn btn-outline-danger btn-sm shadow-sm">
                                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-danger py-4">
                                    <i class="fa-solid fa-user-slash me-2"></i> No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 d-flex justify-content-end">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

@section('js-sweetalert')
<script>
    function deleteButton(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    "Deleted!",
                    "User account has been deleted.",
                    "success"
                );
                setTimeout(() => {
                    window.location.href = '/admin/account/delete/user/' + id;
                }, 1000);
            }
        });
    }
</script>
@endsection
