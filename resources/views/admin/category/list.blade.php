@extends('admin.layouts.master')

@section('content')
<div class="container-fluid py-4">

    <div class="row g-4">
        {{-- Create Category --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fa-solid fa-plus me-2 text-primary"></i> Add Category</h5>
                    <form action="{{ route('category#create') }}" method="post" class="d-flex flex-column gap-2">
                        @csrf
                        <input type="text" name="categoryName" value="{{ old('categoryName') }}"
                               class="form-control @error('categoryName') is-invalid @enderror"
                               placeholder="Category Name...">
                        @error('categoryName') <small class="invalid-feedback">{{ $message }}</small> @enderror
                        <button type="submit" class="btn btn-primary mt-2">Create</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Category List --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <!-- Edit triggers floating card -->
                                            <button class="btn btn-outline-secondary"
                                                    onclick="openEditCard({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-outline-danger"
                                                    onclick="deleteButton({{ $item->id }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Hidden Edit Card --}}
                                <div id="editCard{{ $item->id }}" class="position-fixed top-50 start-50 translate-middle shadow-lg bg-white p-4 rounded d-none" style="width: 350px; z-index: 1050;">
                                    <h5 class="mb-3"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i> Edit Category</h5>
                                    <form action="{{ route('category#update', $item->id) }}" method="post">
                                        @csrf
                                        <input type="text" name="categoryName" value="{{ old('categoryName', $item->name) }}"
                                               class="form-control @error('categoryName') is-invalid @enderror mb-3"
                                               placeholder="Category Name...">
                                        @error('categoryName') <small class="invalid-feedback d-block">{{ $message }}</small> @enderror
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditCard({{ $item->id }})">Cancel</button>
                                            <div class="ml-3">
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end p-2">
                        {{ $categories->links() }}
                    </div>
                </div>
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
            if(result.isConfirmed){
                Swal.fire({
                    title: "Deleted!",
                    text: "Category has been removed.",
                    icon: "success",
                    timer: 1200,
                    showConfirmButton: false
                });
                setTimeout(() => { location.href = '/admin/category/delete/' + id }, 1200);
            }
        });
    }

    function openEditCard(id){
        document.querySelectorAll('[id^=editCard]').forEach(el => el.classList.add('d-none'));
        document.getElementById('editCard' + id).classList.remove('d-none');
    }

    function closeEditCard(id){
        document.getElementById('editCard' + id).classList.add('d-none');
    }
</script>
@endsection
