@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

            <!-- Month Filter -->
            <form method="GET" class="d-flex align-items-center" id="monthFilterForm">
                <div class="input-group input-group-sm mr-2">
                    <input type="text" name="month" id="monthPicker" class="form-control"
                        value="{{ $filterMonth ?? date('Y-m') }}" autocomplete="off" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-week"></i></span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Monthly Summary Cards -->
        <div class="row mb-4">

            <!-- Total Payment -->
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card shadow h-100 py-2 border-left-primary hover-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-primary font-weight-bold mb-1">Total Payment</h6>
                            <h5 class="font-weight-bold text-gray-800">{{ number_format($totalPayment->totalPayment ?? 0) }}
                                MMK</h5>
                        </div>
                        <div class="text-gray-300"><i class="fas fa-dollar-sign fa-2x"></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Sale -->
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card shadow h-100 py-2 border-left-success hover-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-success font-weight-bold mb-1">Total Sale</h6>
                            <h5 class="font-weight-bold text-gray-800">
                                {{ number_format($monthlyTotals->total_sale_price ?? 0) }} MMK</h5>
                        </div>
                        <div class="text-gray-300"><i class="fas fa-shopping-cart fa-2x"></i></div>
                    </div>
                </div>
            </div>

            <!-- Delivery Fees -->
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card shadow h-100 py-2 border-left-info hover-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-info font-weight-bold mb-1">Delivery Fees</h6>
                            <h5 class="font-weight-bold text-gray-800">{{ number_format($totalAcceptedOrders * 5000 ?? 0) }}
                                MMK</h5>
                        </div>
                        <div class="text-gray-300"><i class="fas fa-truck fa-2x"></i></div>
                    </div>
                </div>
            </div>

            <!-- Profit -->
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card shadow h-100 py-2 border-left-warning hover-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-warning font-weight-bold mb-1">Profit</h6>
                            <h5 class="font-weight-bold text-gray-800">
                                {{ number_format(($monthlyTotals->total_sale_price ?? 0) - ($monthlyTotals->total_cost_price ?? 0)) }}
                                MMK
                            </h5>
                        </div>
                        <div class="text-gray-300"><i class="fas fa-chart-line fa-2x"></i></div>
                    </div>
                </div>
            </div>

            <!-- Accepted Orders -->
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card shadow h-100 py-2 border-left-success hover-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-success font-weight-bold mb-1">Accepted Orders</h6>
                            <h5 class="font-weight-bold text-gray-800">{{ number_format($totalAcceptedOrders ?? 0) }}</h5>
                        </div>
                        <div class="text-gray-300"><i class="fas fa-check-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>

            <!-- Rejected Orders -->
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card shadow h-100 py-2 border-left-danger hover-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-danger font-weight-bold mb-1">Rejected Orders</h6>
                            <h5 class="font-weight-bold text-gray-800">{{ number_format($totalRejectedOrders ?? 0) }}</h5>
                        </div>
                        <div class="text-gray-300"><i class="fas fa-times-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Daily Breakdown Table -->
        <section class="section bg-light">
            <div class="container">
                <div class="card shadow-sm border-0 rounded-4 p-4">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            Daily Breakdown for {{ date('F Y', strtotime($filterMonth . '-01')) }}
                        </h5>
                    </div>

                    {{-- Optional Table-like Header --}}
                    <div class="d-flex fw-bold border-bottom pb-2 mb-2">
                        <span class="me-3" style="width:30px;">#</span>
                        <span class="me-4" style="width:120px;">Date</span>
                        <span class="me-4" style="width:120px;">Total Sale</span>
                        <span class="me-4" style="width:120px;">Total Cost</span>
                        <span style="width:120px;">Profit</span>
                    </div>

                    {{-- Daily Totals List --}}
                    <div class="list-group list-group-flush">
                        @foreach ($dailyTotals as $index => $daily)
                            <div class="list-group-item px-3 py-2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center w-100">
                                    {{-- Index --}}
                                    <span class="me-3 fw-bold" style="width:30px;">{{$index +1}}</span>

                                    {{-- Date --}}
                                    <span class="me-4"
                                        style="width:120px;">{{ date('d M Y', strtotime($daily->day)) }}</span>

                                    {{-- Total Sale --}}
                                    <span class="text-success me-4"
                                        style="width:120px;">{{ number_format($daily->total_sale_price) }} MMK</span>

                                    {{-- Total Cost --}}
                                    <span class="text-danger me-4"
                                        style="width:120px;">{{ number_format($daily->total_cost_price) }} MMK</span>

                                    {{-- Profit --}}
                                    <span class="text-info"
                                        style="width:120px;">{{ number_format($daily->total_sale_price - $daily->total_cost_price) }}
                                        MMK</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>

    </div>
    <!-- Optional CSS for hover effect -->
    <style>
        .hover-shadow:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
    </style>
@endsection

@section('js')
    <!-- Include Datepicker CSS/JS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js">
    </script>

    <script>
        $(document).ready(function() {
            $('#monthPicker').datepicker({
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months",
                autoclose: true,
                todayHighlight: true
            });

            // Auto-submit when a month is selected
            $('#monthPicker').on('changeDate', function() {
                $('#monthFilterForm').submit();
            });
        });
    </script>
@endsection
