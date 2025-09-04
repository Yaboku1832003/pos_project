@extends('admin.layouts.master')

@section('content')
<div class="container-fluid py-4">

    {{-- Top Actions --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <button class="btn btn-secondary rounded-pill shadow-sm">
            <i class="fa-solid fa-database me-1"></i> Product Count ({{ count($products) }})
        </button>
        <div class="btn-group">
            <a href="{{ route('product#list') }}" class="btn btn-outline-primary rounded-pill shadow-sm mx-2">All Products</a>
            <a href="{{ route('product#list', 'lowAmt') }}" class="btn btn-outline-danger rounded-pill shadow-sm mx-2">Low Stock</a>
        </div>

        {{-- Search Form --}}
        <form class="d-flex" action="{{ route('product#list') }}" method="get">
            <div class="input-group shadow-sm">
                <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                    class="form-control rounded-start" placeholder="Search products...">
                <button class="btn btn-dark rounded-end"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>

    {{-- Products Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Cost Price</th>
                            <th>Sale Price</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset('productImage/' . $item->image) }}"
                                        class="img-thumbnail rounded shadow-sm" style="width:80px; height:80px; object-fit:cover;">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format($item->cost_price) }} mmk</td>
                                <td>{{ number_format($item->sale_price) }} mmk</td>
                                <td>
                                    <button type="button" class="btn btn-secondary position-relative">
                                        {{ $item->stock }}
                                        @if ($item->stock <= 3)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                Low amt stock
                                            </span>
                                        @endif
                                    </button>
                                </td>
                                <td>{{ $item->category_name }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-info"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="View Details"
                                                onclick="showDetails({{ $item }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <a href="{{ route('product#edit', $item->id) }}"
                                           class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="deleteButton({{ $item->id }})"
                                                data-bs-toggle="tooltip" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-box-open fa-2x mb-2"></i>
                                    <p class="mb-0">No low quantity products</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@section('js-sweetalert')
<script>
    // Delete Confirmation
    function deleteButton(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if(result.isConfirmed){
                Swal.fire({
                    title: "Deleted!",
                    text: "Product has been removed.",
                    icon: "success",
                    timer: 1200,
                    showConfirmButton: false
                });
                setTimeout(() => { location.href = '/admin/product/delete/' + id }, 1200);
            }
        });
    }

    // Product Details Modal
    function showDetails(product) {
        Swal.fire({
            title: `<strong>Product Details</strong>`,
            icon: 'info',
            html: `
                <div class="text-start">
                    <p><strong>Name:</strong> ${product.name}</p>
                    <p><strong>Cost Price:</strong> ${Number(product.cost_price).toLocaleString()} mmk</p>
                    <p><strong>Sale Price:</strong> ${Number(product.sale_price).toLocaleString()} mmk</p>
                    <p><strong>Stock:</strong> ${product.stock}</p>
                    <p><strong>Category:</strong> ${product.category_name}</p>
                    <p><strong>Description:</strong> ${product.description ?? 'No description'}</p>
                </div>`,
            showCloseButton: true,
            focusConfirm: false,
            confirmButtonText: 'Close',
        });
    }

    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', () => {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection
