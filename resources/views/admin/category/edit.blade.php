@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"></h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-md-4 offset-4">
                    <div class="card">
                        <div class="card-title ">
                            <a href="{{ route('category#list') }}"
                                class="btn btn-sm btn-outline-dark text-dark rounded mt-2 mx-2">Back</a>
                        </div>
                        <div class="card-body shadow">
                            <form action="{{ route('category#update',$editCategory->id) }}" method="post"
                                class="p-3 rounded">
                                @csrf

                                <input type="text" name="categoryName"
                                    value="{{ old('categoryName', $editCategory->name) }}"
                                    class=" form-control @error('categoryName') is-invalid @enderror "
                                    placeholder="Category Name...">
                                @error('categoryName')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror


                                <input type="submit" value="Edit" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection
