@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 card p-3 shadow-sm rounded">

                <form action="{{route('product#create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        {{-- image --}}
                        <div class="mb-3">
                            <div class="text-center">
                                <img class="img-profile mb-1 w-25 rounded" id="output" src="">
                            </div>
                            <input type="file" name="image" id="" accept="image/*" class="form-control mt-1 @error('image') is-invalid @enderror "
                                onchange="loadFile(event)">
                            @error('image')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- second row --}}
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name...">
                                    @error('name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="categoryId" id=""
                                        class="form-control @error('categoryId') is-invalid @enderror ">
                                        <option value="">Choose Category...</option>

                                        @foreach ($categories as $items)
                                            <option value="{{ $items->id }}"
                                                @if (old('categoryId') == $items->id) selected @endif>{{ $items->name }}
                                            </option>

                                        @endforeach

                                    </select>
                                    @error('categoryId')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="text" name="stock" value="{{ old('stock') }}"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter stock quantity...">
                                    @error('stock')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        {{-- third row --}}
                        <div class="row">

                            <div class="col">
                                <label class="form-label">Cost price</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="cost_price" value="{{ old('cost_price') }}"
                                        class="form-control @error('cost_price') is-invalid @enderror"
                                        placeholder="Enter Price...">
                                    <span class="input-group-text">mmk</span>
                                    @error('cost_price')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label class="form-label">Sale price</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="sale_price" value="{{ old('sale_price') }}"
                                        class="form-control @error('sale_price') is-invalid @enderror"
                                        placeholder="Enter Price...">
                                    <span class="input-group-text">mmk</span>
                                    @error('sale_price')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter Description...">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- submit button --}}
                        <div class="mb-3">
                            <input type="submit" value="Create Product" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection
