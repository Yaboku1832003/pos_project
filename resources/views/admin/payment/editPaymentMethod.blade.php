@extends('admin.layouts.master')

@section('content')
    {{-- edit payment method start --}}
        <div class="card shadow mt-4 col-md-6 mx-auto">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">Edit Payment Method</h4>
                <a href="{{route('payment#paymentMethod')}}" class="btn btn-dark text-white"><i class="fa-solid fa-angles-left" style="margin-right: 8px;"></i>back</a>
            </div>

            <form action="{{ route('payment#update', ['id' => $editPayment->id]) }}" method="POST">
                @csrf

                <div class="card-body">

                    <div class="mb-3">
                        <label for="account_type" class="form-label">Account Type</label>
                        <input type="text" name="account_type" id="account_type"
                            class="form-control @error('account_type') is-invalid @enderror"
                            value="{{ old('account_type', $editPayment->type) }}" placeholder="e.g., KBZ pay, AYA pay">
                        @error('account_type')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="account_name" class="form-label">Account Name</label>
                        <input type="text" name="account_name" id="account_name"
                            class="form-control @error('account_name') is-invalid @enderror"
                            value="{{ old('account_name',$editPayment->account_name) }}" placeholder="Enter account name">
                        @error('account_name')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" name="account_number" id="account_number"
                            class="form-control @error('account_number') is-invalid @enderror"
                            value="{{ old('account_number',$editPayment->account_number) }}" placeholder="Enter account number">
                        @error('account_number')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Payment Method</button>
                </div>
            </form>
        </div>
        {{-- edit payment method end --}}
@endsection
