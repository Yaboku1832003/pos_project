@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="">
            <div class="row">
                <div class="col-8 offset-2">

                    <div class="card">
                        <div class="card-body shadow">
                            <form action="" method="post" class="p-3 rounded">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label @error('oldPassword') is-invalid @enderror">Old Password</label>
                                    <input type="password" name="oldPassword" class="form-control"
                                        placeholder="Enter Old Password...">
                                    @error('oldPassword')
                                        <small class="invalid-feedback">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label @error('newPassword') is-invalid @enderror">New Password</label>
                                    <input type="password" name="newPassword" class="form-control "
                                        placeholder="Enter New Password...">
                                    @error('newPassword')
                                        <small class="invalid-feedback">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label @error('confirmPassword') is-invalid @enderror">Confirm Password</label>
                                    <input type="password" name="confirmPassword" class="form-control "
                                        placeholder="Enter Confirm Password...">
                                    @error('confirmPassword')
                                        <small class="invalid-feedback">{{$message}}</small>
                                    @enderror
                                </div>
                               <input type="submit" value="Change" class="btn bg-dark text-white">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
