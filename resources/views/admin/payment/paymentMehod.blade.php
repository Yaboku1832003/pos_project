@extends('admin.layouts.master')

@section('content')
<div class="container-fluid py-4">

    <div class="row g-4">
        {{-- Add Payment Method --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa-solid fa-wallet me-2"></i> Add Payment Method</h5>
                </div>

                <form action="{{ route('payment#storeMethod') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Account Type</label>
                            <input type="text" name="account_type" class="form-control @error('account_type') is-invalid @enderror"
                                   value="{{ old('account_type') }}" placeholder="e.g., KBZ Pay, AYA Pay">
                            @error('account_type') <small class="invalid-feedback">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Account Name</label>
                            <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror"
                                   value="{{ old('account_name') }}" placeholder="Enter account name">
                            @error('account_name') <small class="invalid-feedback">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror"
                                   value="{{ old('account_number') }}" placeholder="Enter account number">
                            @error('account_number') <small class="invalid-feedback">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">Add Method</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Payment List --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa-solid fa-list me-2"></i> Payment Methods</h5>
                </div>
                <div class="card-body">
                    @if($payments->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-credit-card fa-2x mb-3"></i>
                            <p>No payment methods created yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-primary text-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $payment->type }}</td>
                                            <td>{{ $payment->account_name }}</td>
                                            <td>{{ $payment->account_number }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-secondary"
                                                            onclick="openEditCard({{ $payment->id }})">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger"
                                                            onclick="deleteButton({{ $payment->id }})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Floating Edit Card --}}
                                        <div id="editCard{{ $payment->id }}"
                                             class="position-fixed top-50 start-50 translate-middle shadow-lg bg-white p-4 rounded d-none"
                                             style="width: 400px; z-index: 1050;">
                                             <div class="card-header  d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i> Edit Payment Methods</h5>
                                            </div>
                                            <form action="{{ route('payment#update', $payment->id) }}" method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Account Type</label>
                                                    <input type="text" name="account_type" value="{{ old('account_type', $payment->type) }}" class="form-control mb-2">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Account Name</label>
                                                    <input type="text" name="account_name" value="{{ old('account_name', $payment->account_name) }}" class="form-control mb-2">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Account Number</label>
                                                    <input type="text" name="account_number" value="{{ old('account_number', $payment->account_number) }}" class="form-control mb-2">
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditCard({{ $payment->id }})">Cancel</button>
                                                    <div class="ml-3">
                                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if(result.isConfirmed){
                location.href = '/admin/payment/delete/' + id;
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
