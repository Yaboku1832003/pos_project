@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('account#adminList') }}"> <button class=" btn btn-sm btn-secondary  "> Admin List</button> </a>

            <div class="">
                <form action="{{route('account#userList')}}" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <table class="table table-hover shadow-sm text-center ">
                    <thead class="bg-primary text-white">
                        <tr class="bg-white">
                            <td colspan="12" class="text-center align-middle" style="color:black">
                                User List
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

                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center align-middle">
                                    {{ $user->id }}
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    @php
                                        $profile = $user->profile;

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
                                <td>{{ $user->name ? $user->name : $user->nickname}}</td>
                                <td>{{ $user->email }}</td>
                                {{-- {!!......!!} is used when want to add HTML code --}}
                                <td>{!! $user->address != null ? $user->address : '<span class="text-danger" style="opacity: 0.7;">no data</span>' !!}</td>
                                <td>{!! $user->phone != null ? $user->phone : '<span class="text-danger" style="opacity: 0.7;">no data</span>' !!}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at->format('Y-F-d') }}</td>
                                <td>
                                    @if ($user->provider == 'google')
                                        <i class="fa-brands fa-google text-danger bg-white border border-2 rounded-circle d-flex justify-content-center align-items-center"
                                         style="width: 30px; height: 30px; font-size: 25px;"></i>
                                    @elseif ($user->provider == 'github')
                                        <i class="fa-brands fa-github rounded-circle d-flex justify-content-center align-items-center"
                                         style="width: 30px; height: 30px; font-size: 30px; color:darkgray;"></i>
                                    @else
                                        <i class="fa-solid fa-right-to-bracket text-primary d-flex justify-content-center align-items-center"
                                        style="width: 30px; height: 30px; font-size: 25px;"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <span class=" d-flex justify-content-end">{{$users->links()}}</span>

            </div>
        </div>
    </div>
@endsection
