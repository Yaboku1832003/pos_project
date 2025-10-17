@extends('user.layouts.master')

@section('content')
<section class="section bg-light">
    <div class="container py-5">
        <div class="card shadow-sm border-0 rounded-4 p-4">

            {{-- Back Button --}}
            <div class="d-flex justify-content-end align-items-center mb-3">
                <a href="javascript:history.back()" class="btn btn-sm fs-2">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>

            {{-- Row 1: Header + Image --}}
            <div class="row align-items-center mb-5">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h2 class="fw-bold" style="color:#0d6efd;">Get in Touch</h2>
                    <p class="text-muted fs-6" style="line-height:1.6;">
                        We’re here to help! Reach out to us with any questions or inquiries and we’ll respond as soon as possible.
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/AboutUs/contactUs.jpg') }}" alt="Contact Us"
                         style="width:100%; height:auto; border-radius:12px; object-fit:cover; box-shadow:0 12px 30px rgba(0,0,0,0.12);">
                </div>
            </div>

            {{-- Row 2: Contact Cards --}}
            <div class="row g-4">
                {{-- Phone Card --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 p-4 text-center h-100"
                         style="transition: transform 0.3s, box-shadow 0.3s; cursor:pointer;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,0.15)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';">
                        <div class="mb-3">
                            <i class="fa-solid fa-phone fs-2 text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Call Us</h5>
                        <p class="text-muted mb-0">(+95) 9758343191</p>
                    </div>
                </div>

                {{-- Email Card --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 p-4 text-center h-100"
                         style="transition: transform 0.3s, box-shadow 0.3s; cursor:pointer;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,0.15)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';">
                        <div class="mb-3">
                            <i class="fa-solid fa-envelope fs-2 text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Email Us</h5>
                        <p class="text-muted mb-0">toge7448@gmail.com</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
