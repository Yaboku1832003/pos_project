@extends('admin.layouts.master')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('account#userList') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fa-solid fa-users me-1"></i> User List
        </a>

        <form action="{{ route('account#adminList') }}" method="get" class="w-50">
            <div class="input-group shadow-sm">
                <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control" placeholder="Search admins...">
                <button type="submit" class="btn btn-dark">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="card shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa-solid fa-user-shield me-2"></i> Admin List</h5>
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center" style="font-size:0.95rem;">
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
                        @forelse ($admins as $admin)
                            <tr>
                                <!-- ID -->
                                <td>{{ $admin->id }}</td>

                                <!-- Profile -->
                                <td>
                                    @php
                                        $profile = $admin->profile;
                                        $imgSrc = $profile
                                            ? (filter_var($profile, FILTER_VALIDATE_URL) ? $profile : asset('profileImage/' . $profile))
                                            : asset('default/default-profile.png');
                                    @endphp
                                    <img src="{{ $imgSrc }}" alt="Profile" class="rounded-circle shadow-sm"
                                         style="width:55px; height:55px; object-fit:cover;"
                                         title="{{ $admin->name ?? $admin->nickname ?? 'No Name' }}">
                                </td>

                                <!-- Name -->
                                <td>
                                    @if($admin->name || $admin->nickname)
                                        {{ $admin->name ?? $admin->nickname }}
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-user me-1"></i>No Data</span>
                                    @endif
                                </td>

                                <!-- Email -->
                                <td>
                                    {{ $admin->email ?? '-' }}
                                </td>

                                <!-- Address -->
                                <td>
                                    @if($admin->address)
                                        {{ $admin->address }}
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-map-marker-alt me-1"></i>No Data</span>
                                    @endif
                                </td>

                                <!-- Phone -->
                                <td>
                                    @if($admin->phone)
                                        {{ $admin->phone }}
                                    @else
                                        <span class="text-danger"><i class="fa-solid fa-phone me-1"></i>No Data</span>
                                    @endif
                                </td>

                                <!-- Role -->
                                <td>
                                    <span class="badge bg-info text-dark px-2 py-1 rounded-pill shadow-sm">
                                        <i class="fa-solid fa-user-shield me-1"></i> {{ ucfirst($admin->role ?? 'No Data') }}
                                    </span>
                                </td>

                                <!-- Created Date -->
                                <td>{{ $admin->created_at ? $admin->created_at->format('Y-m-d') : '-' }}</td>

                                <!-- Platform -->
                                <td class="text-center">
                                    @if ($admin->provider == 'google')
                                        <i class="fa-brands fa-google text-danger" style="font-size:2.2rem; text-shadow:0 0 3px rgba(0,0,0,0.2);" title="Google Login"></i>
                                    @elseif ($admin->provider == 'github')
                                        <i class="fa-brands fa-github text-dark" style="font-size:2.2rem; text-shadow:0 0 3px rgba(0,0,0,0.2);" title="GitHub Login"></i>
                                    @else
                                        <i class="fa-solid fa-user-circle text-primary" style="font-size:2.2rem; text-shadow:0 0 3px rgba(0,0,0,0.2);" title="Local Login"></i>
                                    @endif
                                </td>

                                <!-- Action -->
                                <td>
                                    @if ($admin->role != 'superadmin')
                                        <button type="button" onclick="deleteButton({{ $admin->id }})" class="btn btn-outline-danger btn-sm shadow-sm">
                                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-danger py-4">
                                    <i class="fa-solid fa-user-slash me-2"></i> No admins found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3 d-flex justify-content-end">
                {{ $admins->links() }}
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
                    "Admin account has been deleted.",
                    "success"
                );
                setTimeout(() => {
                    window.location.href = '/admin/account/delete/admin/' + id;
                }, 1000);
            }
        });
    }
</script>
@endsection
