@extends('user.layouts.master')

@section('content')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="card col-12 shadow-sm">
                <div class="card-body" >
                    <div class="row" >
                        {{-- Left column start --}}
                        <div class="col-lg-5 rounded-3 shadow-sm">
                            <h4 class="card-title">Your Orders</h4>
                            {{-- show order subtotal start --}}
                                <div class="form-row mt-2">
                                    <div class="col">
                                        <ul class="list-group list-group-flush">
                                            <li class="mt-2 d-flex justify-content-between fs-6">
                                                <span>Subtotal:</span>
                                                <span id="subtotal"> mmk</span>
                                            </li>
                                            <li class="mt-2 d-flex justify-content-between fs-6">
                                                <span>Delivery Fee:</span>
                                                <span>5000 mmk</span>
                                            </li>
                                            <li class="mt-2 d-flex justify-content-between fs-6">
                                                <span>Total:</span>
                                                <span id="finalTotal"> mmk</span>
                                            </li>
                                            <li class="mt-2 d-flex justify-content-between fs-6">
                                                <span>Order date:</span>
                                                <span id="finalTotal"> </span>
                                            </li>
                                            <li class="mt-2 d-flex justify-content-between fs-6">
                                                <span>Order Code:</span>
                                                <span id="finalTotal"> mmk</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            {{-- show order subtotal end --}}
                            {{-- show order list start --}}
                                <div class="row mt-2">
                                    <div class="col">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <img src="{{asset('productImage/6894d4c6b4a36itachi-uchiha-naruto-amoled-black-background-minimal-art-3840x2160-6478.jpg')}}" style="width:100px; height:100px; object-fit:cover;">
                                                </td>
                                                <td class="text-end">
                                                   <div class="div">Name:</div>
                                                   <div class="div">Price:</div>
                                                   <div class="div">Qty:</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            {{-- show order list end --}}
                        </div>
                        {{-- Left column end --}}

                        {{-- Right column start --}}
                        <div class="col-lg-7 " >
                            <div class="row">
                                @php
                                $imageMap = [
                                    'KBZ pay' => 'KBZpay.png',
                                    'CB pay'  => 'CBpay.png',
                                    'AYA pay' => 'AYApay.png',
                                ];
                                @endphp

                                @foreach ($paymentAcc as $payment)
                                    @php
                                        $image = $imageMap[$payment->type] ?? ' ';
                                    @endphp

                                    <div class="col-lg-4 col-sm-6">
                                        <div class="shadow-sm border-1 p-3 d-flex">
                                            <img src="{{ asset('paymentMethods/' . $image) }}"
                                                alt="{{ $payment->type }}"
                                                class="me-3"
                                                style="width:45px; height:45px; object-fit:cover;">

                                            <div class="">
                                                <p class="mb-1 fw-semibold" style="font-size: 12px;">{{ $payment->type }}</p>
                                                <p class="mb-1" style="font-size: 12px; font-weight:bold;">{{ $payment->account_number }}</p>
                                                <p class="mb-0" style="font-size: 12px;">{{ $payment->account_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="card shadow-sm mt-3" >
                                <div class="card-header">
                                    Payment Info
                                </div>
                                <div class="card-body">
                                    <form action="">
                                        <div class="form-row ">
                                            <div class="col-md-6">
                                                <input type="text" name="name" class="form-control" placeholder="User Name..." readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxxx">
                                            </div>
                                        </div>
                                        <div class="form-row mt-3">
                                            <input type="text" name="address" class="form-control" placeholder="Address...">
                                        </div>

                                        <div class="form-row mt-3">
                                            <div class="form-group col-lg-5">

                                                    <select name="paymentType" id="" class=" w-100">
                                                        <option value="">Choose Payment Method...</option>
                                                        @foreach ($paymentAcc as $items)
                                                            <option value="{{ $items->id }}"
                                                                @if (old('paymentType') == $items->id) selected @endif>
                                                                {{ $items->type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            <div class="form-group col-lg-7">
                                                <input type="file" class="form-control" name="paymentVoucher"  id=""
                                                    style="height: 40px;">
                                            </div>
                                        </div>


                                        <div class="form-row mt-3">
                                            <div class="col-5 offset-7 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-success">
                                                <i class="fa-solid fa-wallet me-1"></i></i>
                                                <small>Confirm Payment</small>
                                            </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- Right column end --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
