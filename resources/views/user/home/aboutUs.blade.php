@extends('user.layouts.master')

@section('content')
<section class="section bg-light">
    <div class="container">
        <div class="card shadow-sm border-0 rounded-4 p-4">

            {{-- Back Button --}}
            <div class="d-flex justify-content-end align-items-center mb-3">
                <a href="javascript:history.back()" class="btn btn-sm fs-2">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>

            {{-- Header --}}
            <div class="text-center mb-4">
                <h3 class="fw-bold">About Us</h3>
                <p class="text-muted fs-6">Learn more about our mission, vision, and the team behind our company.</p>
            </div>

            {{-- Mission & Vision --}}
            <div class="row align-items-center mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <img src="{{ asset('images/mission.jpg') }}" alt="Mission"
                         style="width:100%; height:auto; border-radius:12px; object-fit:cover; box-shadow:0 8px 20px rgba(0,0,0,0.1);">
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold mb-2">Our Mission</h5>
                    <p style="line-height:1.6;">We strive to deliver top-notch products and services that make a meaningful impact in our customers’ lives. Quality, innovation, and reliability are our top priorities.</p>

                    <h5 class="fw-bold mt-3 mb-2">Our Vision</h5>
                    <p style="line-height:1.6;">To be a globally recognized brand that inspires trust and loyalty, continuously improving and adapting to serve the needs of a dynamic market.</p>
                </div>
            </div>

            {{-- Team Section --}}
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Our Team</h5>
                <div class="row">
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="text-center">
                            <img src="{{ asset('images/team1.jpg') }}" alt="Team Member"
                                 style="width:120px; height:120px; object-fit:cover; border-radius:50%; box-shadow:0 6px 15px rgba(0,0,0,0.1);">
                            <h6 class="mt-2 fw-bold">Alice Johnson</h6>
                            <p class="text-muted small">CEO & Founder</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="text-center">
                            <img src="{{ asset('images/team2.jpg') }}" alt="Team Member"
                                 style="width:120px; height:120px; object-fit:cover; border-radius:50%; box-shadow:0 6px 15px rgba(0,0,0,0.1);">
                            <h6 class="mt-2 fw-bold">Michael Lee</h6>
                            <p class="text-muted small">CTO</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="text-center">
                            <img src="{{ asset('images/team3.jpg') }}" alt="Team Member"
                                 style="width:120px; height:120px; object-fit:cover; border-radius:50%; box-shadow:0 6px 15px rgba(0,0,0,0.1);">
                            <h6 class="mt-2 fw-bold">Sophia Wang</h6>
                            <p class="text-muted small">Marketing Head</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Call to Action --}}
            <div class="text-center mt-4">
                <p style="color:#495057; font-size:1rem; line-height:1.6;">
                    Have any questions or want to reach out? You can email us directly at <a href="mailto:info@yourcompany.com" style="color:#0d6efd; text-decoration:none;">info@yourcompany.com</a>.
                </p>
            </div>

        </div>
    </div>
</section>
@endsection
