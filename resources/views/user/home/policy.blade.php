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

            {{-- Page Header --}}
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color:#0d6efd;">Our Policy</h2>
                <p class="text-muted fs-6" style="line-height:1.6;">
                    Learn about the rules, guidelines, and policies that govern how we operate and ensure the best experience for our customers.
                </p>
            </div>

            {{-- Policy Sections --}}
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 p-4 h-100"
                         style="transition: transform 0.3s, box-shadow 0.3s; cursor:pointer;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,0.15)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';">
                        <h5 class="fw-bold mb-2">Privacy Policy</h5>
                        <p class="text-muted mb-0" style="line-height:1.6;">
                            We respect your privacy and are committed to protecting your personal information. Your data is handled securely and never shared without your consent.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 p-4 h-100"
                         style="transition: transform 0.3s, box-shadow 0.3s; cursor:pointer;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,0.15)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';">
                        <h5 class="fw-bold mb-2">Terms & Conditions</h5>
                        <p class="text-muted mb-0" style="line-height:1.6;">
                            By using our website and services, you agree to our terms and conditions, which outline the rules and responsibilities for both parties.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 p-4 h-100"
                         style="transition: transform 0.3s, box-shadow 0.3s; cursor:pointer;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,0.15)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';">
                        <h5 class="fw-bold mb-2">Refund Policy</h5>
                        <p class="text-muted mb-0" style="line-height:1.6;">
                            We provide a clear and fair refund policy for our products and services. If you are unsatisfied, we will guide you through the process quickly and efficiently.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 p-4 h-100"
                         style="transition: transform 0.3s, box-shadow 0.3s; cursor:pointer;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,0.15)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';">
                        <h5 class="fw-bold mb-2">Shipping Policy</h5>
                        <p class="text-muted mb-0" style="line-height:1.6;">
                            Our shipping policy ensures that your orders arrive on time and in perfect condition. We provide tracking information and updates for every shipment.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
