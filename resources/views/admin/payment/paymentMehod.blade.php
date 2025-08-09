@extends('admin.layouts.master')

@section('content')
    {{-- whole content start --}}
    <div class="container-fluid">
        {{-- add payment start --}}
        <div class="card shadow mb-4 col-md-6 mx-auto">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Add Payment Method</h4>
            </div>

            <form action="{{ route('payment#storeMethod') }}" method="POST">
                @csrf

                <div class="card-body">

                    <div class="mb-3">
                        <label for="account_type" class="form-label">Account Type</label>
                        <input type="text" name="account_type" id="account_type"
                            class="form-control @error('account_type') is-invalid @enderror"
                            value="{{ old('account_type') }}" placeholder="e.g., KBZ pay, AYA pay">
                        @error('account_type')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="account_name" class="form-label">Account Name</label>
                        <input type="text" name="account_name" id="account_name"
                            class="form-control @error('account_name') is-invalid @enderror"
                            value="{{ old('account_name') }}" placeholder="Enter account name">
                        @error('account_name')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" name="account_number" id="account_number"
                            class="form-control @error('account_number') is-invalid @enderror"
                            value="{{ old('account_number') }}" placeholder="Enter account number">
                        @error('account_number')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Payment Method</button>
                </div>
            </form>
        </div>
        {{-- add payment end --}}

        {{-- payment list start --}}
        <div class="card shadow mt-4 col-md-8 mx-auto">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Payment Methods List</h4>
            </div>

            <div class="card-body">
                @if ($payments->isEmpty())
                    <p>No payment methods created yet.</p>
                @else
                    <table class="table table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>#</th>
                                <th>Account Type</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $payment->type }}</td>
                                    <td>{{ $payment->account_name }}</td>
                                    <td>{{ $payment->account_number }}</td>
                                    <td>
                                        <a href="{{ route('payment#edit',$payment->id) }}"
                                            class="btn btn-sm btn-outline-secondary"title="Edit Payment Method"
                                            aria-label="Edit payment method for {{ $payment->account_name }}"> <i
                                                class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button type="button" onclick="deleteButton({{ $payment->id }})"
                                            class="btn btn-danger btn-sm" title="Delete Payment Method"
                                            aria-label="Delete payment method for {{ $payment->account_name }}"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        {{-- payment list end --}}
    </div>
    {{-- whole content end --}}
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
                        location.href = '/admin/payment/delete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
