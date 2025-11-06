@extends('layouts.authlayout')
@section('custom_styles')
    <style>

    </style>
@endsection
@section('main_content')
    <section class="min-vh-100 bg-gray-300">
        <div class="page-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card mt-7" id="print_area">
                            <div class="card-header pb-0 text-center bg-transparent">
                                <i class="fa fa-times-circle text-6xl text-danger"></i>
                            </div>
                            <div class="card-body">
                                <h3 class="font-weight-black text-dark display-6 text-center">Error</h3>
                                <h4 class="font-weight-black text-dark text-center">{{ $error_msg }}</h4>
                                <hr>
                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-hover" style="width: 50%; row-span: 3" align="center">
                                        <tr>
                                            <th style="text-align: right">Order #</th>
                                            <td>{{ $orders->order_id }}</td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: right">Name</th>
                                            <td>{{ $customer->first_name.' '.$customer->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: right">Email</th>
                                            <td>{{ $customer->email }}</td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: right">Total Amount</th>
                                            <td>{{ $orders->currency.' '.$product_details->total_price }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer_scripts')
    @include('layouts.footer_scripts')
@endsection
@section('custom_scripts')
    <script
        src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection
