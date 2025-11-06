@extends('admin.layouts.rootlayout')
@section('title', 'Payment Management System | Dashboard')
@section('sidebar')
    @include('admin.layouts.sidebar')
@endsection

@section('first_page')
    <a href="#">Dashboard</a>
@endsection
@section('current_page')
    Dashboard
@endsection
@section('page_title')
    Dashboard
@endsection

@section('navbar')
    @include('admin.layouts.navbar')
@endsection

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="d-md-flex align-items-center mb-3 mx-2">
            <div class="mb-md-0 mb-3">
                <h3 class="font-weight-bold mb-0">Welcome, {{ Auth::user()->name }}</h3>
                <p class="mb-0"></p>
            </div>
        </div>
    </div>
</div>
<hr class="mb-4">
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0">
        <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
                <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                    <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z" />
                        <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="w-100">
                            <p class="text-sm text-secondary mb-1">Total Orders</p>
                            <h4 class="mb-2 font-weight-bold">{{ $order_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0">
        <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
                <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="w-60" width="16" height="16">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                    </svg>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="w-100">
                            <p class="text-sm text-secondary mb-1">Total Customers</p>
                            <h4 class="mb-2 font-weight-bold">{{ $customer_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-xs border">
            <div class="card-header pb-0">
                <div class="d-sm-flex align-items-center mb-3">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Overview</h6>
                        <p class="text-sm mb-sm-0 mb-2">Here you have details about the orders.</p>
                        <small class="text-muted" style="font-size: 0.6em">*Note: All Currencies are converted to AED.</small>
                    </div>
                    <div class="ms-auto d-flex">
                        <a type="button" class="btn btn-sm btn-white mb-0 me-2" href="{{ route('orders') }}">
                            View Orders
                        </a>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center">
                    <h3 class="mb-0 font-weight-semibold" id="total_price"><i class="fa fa-circle-notch fa-spin"></i></h3>
{{--                    <span class="badge badge-sm border border-success text-success bg-success border-radius-sm ms-sm-3 px-2">--}}
{{--                  <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path d="M0.46967 4.46967C0.176777 4.76256 0.176777 5.23744 0.46967 5.53033C0.762563 5.82322 1.23744 5.82322 1.53033 5.53033L0.46967 4.46967ZM5.53033 1.53033C5.82322 1.23744 5.82322 0.762563 5.53033 0.46967C5.23744 0.176777 4.76256 0.176777 4.46967 0.46967L5.53033 1.53033ZM5.53033 0.46967C5.23744 0.176777 4.76256 0.176777 4.46967 0.46967C4.17678 0.762563 4.17678 1.23744 4.46967 1.53033L5.53033 0.46967ZM8.46967 5.53033C8.76256 5.82322 9.23744 5.82322 9.53033 5.53033C9.82322 5.23744 9.82322 4.76256 9.53033 4.46967L8.46967 5.53033ZM1.53033 5.53033L5.53033 1.53033L4.46967 0.46967L0.46967 4.46967L1.53033 5.53033ZM4.46967 1.53033L8.46967 5.53033L9.53033 4.46967L5.53033 0.46967L4.46967 1.53033Z" fill="#67C23A"></path>--}}
{{--                  </svg>--}}
{{--                  10.5%--}}
{{--                </span>--}}
                </div>
            </div>
            <div class="card-body p-3">
                <div class="chart mt-n6">
                    <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_content')
    @include('admin.layouts.footer_content')
@endsection

@section('color_settings')
    @include('admin.layouts.color_settings')
@endsection

@section('footer_scripts1')
    @include('admin.layouts.footer_scripts1')
@endsection

@section('chart_code')
    <script>


    </script>
@endsection

@section('footer_scripts2')
    @include('admin.layouts.footer_scripts2')
@endsection

@section('custom_scripts')
    <script>
        $(document).ready(function () {
            console.log("Working JS");
            getTransactions();
        });

        function getTransactions()
        {
            $.ajax({
                url: '{{ route('total_transactions') }}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                },
                success: function (data) {
                    if(data.status)
                    {
                        chartInit(data.all_dates, data.product_price);
                        $('#total_price').html("AED "+ data.total);
                    }
                }
            });
        }

        function chartInit(all_dates, product_price)
        {

            var ctx2 = document.getElementById("chart-line").getContext("2d");

            var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, 'rgba(45,168,255,0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(45,168,255,0.0)');
            gradientStroke1.addColorStop(0, 'rgba(45,168,255,0)'); //blue colors

            var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke2.addColorStop(1, 'rgba(119,77,211,0.4)');
            gradientStroke2.addColorStop(0.7, 'rgba(119,77,211,0.1)');
            gradientStroke2.addColorStop(0, 'rgba(119,77,211,0)'); //purple colors

            new Chart(ctx2, {
                plugins: [{
                    beforeInit(chart) {
                        const originalFit = chart.legend.fit;
                        chart.legend.fit = function fit() {
                            originalFit.bind(chart.legend)();
                            this.height += 40;
                        }
                    },
                }],
                type: "line",
                data: {
                    labels: all_dates,
                    datasets: [{
                        label: "Order",
                        tension: 0,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#2ca8ff",
                        pointBorderColor: '#2ca8ff',
                        pointBackgroundColor: '#2ca8ff',
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: product_price,
                        maxBarThickness: 6

                    },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                boxWidth: 6,
                                boxHeight: 6,
                                padding: 20,
                                pointStyle: 'circle',
                                borderRadius: 50,
                                usePointStyle: true,
                                font: {
                                    weight: 400,
                                },
                            },
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1e293b',
                            bodyColor: '#1e293b',
                            borderColor: '#e9ecef',
                            borderWidth: 1,
                            pointRadius: 2,
                            usePointStyle: true,
                            boxWidth: 8,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [4, 4]
                            },
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return parseInt(value).toLocaleString() + ' AED';
                                },
                                display: true,
                                padding: 10,
                                color: '#b2b9bf',
                                font: {
                                    size: 12,
                                    family: "Noto Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#64748B"
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [4, 4]
                            },
                            ticks: {
                                display: true,
                                color: '#b2b9bf',
                                padding: 20,
                                font: {
                                    size: 12,
                                    family: "Noto Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#64748B"
                            }
                        },
                    },
                },
            });
        }
    </script>
@endsection
