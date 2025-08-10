@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{route('account#userList')}}"> <button class=" btn btn-sm btn-secondary  "> User List</button> </a>

            <div class="">
                <form action="{{route('account#adminList')}}" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{request('searchKey')}}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <table class="table table-hover shadow-sm text-center">
                    <thead class="bg-primary text-white">
                            <tr class="bg-white">
                            <td colspan="12" class="text-center align-middle" style="color:black">
                                Admin List
                            </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Created Date</th>
                                <th> Platform</th>
                                <th></th>
                            </tr>
                    </thead>
                    <tbody>

                        @foreach ($admins as $admin)
                            <tr>
                                <td class="text-center align-middle">
                                    {{ $admin->id }}
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    @php
                                        $profile = $admin->profile;

                                        if ($profile) {
                                            // Check if it's a valid URL
                                            if (filter_var($profile, FILTER_VALIDATE_URL)) {
                                                $imgSrc = $profile; // use URL directly
                                            } else {
                                             $imgSrc = asset('profileImage/' . $profile); // local image file
                                            }
                                        } else {
                                            $imgSrc = asset('default/default-profile.png'); // fallback default
                                        }
                                    @endphp

                                    <img src="{{ $imgSrc }}" alt="Profile Image"
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; display: block;">
                                </td>
                                <td>{{ $admin->name ? $admin->name : $admin->nickname}}</td>
                                <td>{{ $admin->email }}</td>
                                {{-- {!!......!!} is used when want to add HTML code--}}
                                <td>{!! $admin->address != null ? $admin->address : '<span class="text-danger" style="opacity: 0.7;"> no data</span>' !!}</td>
                                <td>{!!$admin->phone != null ? $admin->phone : '<span class="text-danger" style="opacity: 0.7;"> no data</span>' !!}</td>
                                <td>{{ $admin->role }}</td>
                                <td>{{ $admin->created_at->format('Y-F-d') }}</td>
                                <td>
                                    @if ($admin->provider == 'google')
                                        <i class="fa-brands fa-google text-danger bg-white border border-2 rounded-circle d-flex justify-content-center align-items-center"
                                         style="width: 30px; height: 30px; font-size: 25px;"></i>
                                    @elseif ($admin->provider == 'github')
                                        <i class="fa-brands fa-github rounded-circle d-flex justify-content-center align-items-center"
                                         style="width: 30px; height: 30px; font-size: 30px; color:darkgray;"></i>
                                    @else
                                        <i class="fa-solid fa-right-to-bracket text-primary d-flex justify-content-center align-items-center"
                                        style="width: 30px; height: 30px; font-size: 25px;"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($admin->role != 'superadmin')
                                        <button type="button" onclick="deleteButton({{$admin->id}})" class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-trash-can"></i> </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <span class=" d-flex justify-content-end">{{$admins->links()}}</span>

            </div>
        </div>
    </div>
@endsection

@section('js-sweetalert')
    <script>
        function deleteButton($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                draggable: true,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    setInterval(() => {
                        location.href = '/admin/account/delete/admin/' + $id
                    }, 1000);
                }
            });
        }
        </script>
@endsection
