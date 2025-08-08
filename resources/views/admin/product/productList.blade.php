@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class="">
                <button class=" btn btn-secondary rounded shadow-sm"> <i class="fa-solid fa-database"></i>
                    Product Count ({{ count($products) }} ) </button>
                <a href="{{ route('product#list') }}" class=" btn btn-outline-primary  rounded shadow-sm">All Products</a>
                {{-- lowAmt will be caught with $action in Controller --}}
                <a href="{{ route('product#list', 'lowAmt') }}" class=" btn btn-outline-danger  rounded shadow-sm">Low Amount
                    Product List</a>
            </div>
            <div class="">

                {{-- carry searchKey value to ProductController --}}
                <form action="{{ route('product#list') }}" method="get">

                    {{-- value="{{request(searchKey)}}" make old data left after search --}}
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
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Cost price</th>
                            <th>Sale price</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($products) != 0)
                            @foreach ($products as $items)
                                <tr>
                                    <td> <img src="{{ asset('productImage/' . $items->image) }}"
                                            class=" img-thumbnail rounded shadow-sm" style="width:100px" alt="">
                                    </td>
                                    <td>{{ $items->name }}</td>
                                    <td>{{ $items->cost_price }} mmk</td>
                                    <td>{{ $items->sale_price }} mmk</td>
                                    <td class="col-2">
                                        <button type="button" class="btn btn-secondary position-relative">
                                            {{ $items->stock }}

                                            @if ($items->stock <= 3)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    Low amt stock
                                                </span>
                                            @endif


                                        </button>
                                    </td>
                                    <td>{{ $items->category_name }}</td>
                                    <td>

                                        <a href="#" class="btn btn-sm btn-outline-secondary openDetail"
                                            data-name="{{ $items->name }}" data-cost="{{ $items->cost_price }}"
                                            data-sale="{{ $items->sale_price }}" data-stock="{{ $items->stock }}"
                                            data-category="{{ $items->category_name }}"
                                            data-description="{{ $items->description ?? 'No description' }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('product#edit', $items->id) }}"
                                            class="btn btn-sm btn-outline-secondary"> <i
                                                class="fa-solid fa-pen-to-square"></i> </a>
                                        <button type="button" onclick="deleteButton({{ $items->id }})"
                                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-muted text-center">There is no products</h5>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                <span class=" d-flex justify-content-end">{{ $products->links() }}</span>

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
                        location.href = '/admin/product/delete/' + $id
                    }, 1000);
                }
            });
        }




        document.querySelectorAll('.openDetail').forEach(btn => {
            btn.addEventListener('click', function() {
                // e.preventDefault();
                const name = this.getAttribute('data-name');
                const cost = this.getAttribute('data-cost');
                const sale = this.getAttribute('data-sale');
                const stock = this.getAttribute('data-stock');
                const category = this.getAttribute('data-category');
                const description = this.getAttribute('data-description');

                Swal.fire({
                    title: `<strong>Product Details</strong>`,
                    icon: 'info',
                    draggable: true,
                    html: `<p><strong>Name:</strong> ${name}</p>` +
                        `<p><strong>Cost Price:</strong> ${cost} mmk</p>` +
                        `<p><strong>Sale Price:</strong> ${sale} mmk</p>` +
                        `<p><strong>Stock:</strong> ${stock}</p>` +
                        `<p><strong>Category:</strong> ${category}</p>` +
                        `<p><strong>Description:</strong> ${description}</p>`,
                    showCloseButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Close',
                });
            });
        });
    </script>
@endsection
