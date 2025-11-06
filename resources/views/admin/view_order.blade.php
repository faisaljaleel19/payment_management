@extends('admin.layouts.rootlayout')
@section('title','Payment Management System | View Order')
@section('sidebar')
    @include('admin.layouts.sidebar')
@endsection

@section('first_page')
    <a href="{{ route('orders') }}">Orders</a>
@endsection
@section('current_page')
    View Order
@endsection
@section('page_title')
    View Order
@endsection

@section('navbar')
    @include('admin.layouts.navbar')
@endsection

@section('main_content')
    <div class="row my-4">
        <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
            <div class="card shadow-xs border h-100">
                <div class="card-header pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Order & Account Information</h6>
                    <p class="text-sm">Order #<span>{{ $order->order_id }}</span></p>
                </div>
                <div class="card-body py-3">
                    <div class="row m-2 bg-secondary text-white">
                        <div class="col-6">
                            Order Date
                        </div>
                        <div class="col-6">
                            {{ \Carbon\Carbon::parse($order->order_date)->format('D, d M Y H:i:s')  }}
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-6">
                            Order Status
                        </div>
                        <div class="col-6">
                            @if($order_status[0]->order_status_text === 'Pending')
                                <span class="badge badge-info">Pending</span>
                            @elseif($order_status[0]->order_status_text === 'Completed')
                                <span class="badge badge-success">Completed</span>
                            @elseif($order_status[0]->order_status_text === 'Failed')
                                <span class="badge badge-danger">Failed</span>
                            @elseif($order_status[0]->order_status_text === 'Cancelled')
                                <span class="badge badge-danger">Cancelled</span>
                            @else
                                <span class="badge badge-warning">{{$order_status[0]->order_status_text}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-6">
                            Payment Link
                        </div>
                        <div class="col-6">
                            <a href="{{ route('pay', ['mi' => $payment_link->token]) }}" class="btn btn-primary btn-sm" target="_blank">Open Payment Link</a>
                            @if($order_status[0]->order_status_text !== 'Completed')
                                <button type="button" id="resend_payment_link" class="btn btn-secondary btn-sm">Resend Payment Link</button>
                            @endif
                        </div>
                    </div>
                    @if($order_status[0]->order_status_text !== 'Completed')
                        <div class="row m-2">
                            <div class="col-6">
                                Expiry Status
                            </div>
                            <div class="col-6">
                                <div id="order_expiry"><i class="fa fa-spinner fa-spin"></i></div>
                            </div>
                        </div>
                    @endif
                    <div class="row m-2">
                        <div class="col-6">
                            Change Status
                        </div>
                        <div class="col-6">
                            <div>
                                <select class="form-control" id="change_status">
                                    <option value="">--Select Status--</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Pending">Pending</option>
                                </select>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-primary" id="btn_change_status">Change Status</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
            <div class="card shadow-xs border h-100">
                <div class="card-header pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Account Information</h6>
                    <p class="text-sm">Edit Customer</p>
                </div>
                <div class="card-body py-3">
                    <div class="row m-2 bg-secondary text-white">
                        <div class="col-6">
                            Customer Name
                        </div>
                        <div class="col-6">
                            {{ $customer->first_name.' '.$customer->last_name }}
                        </div>
                    </div>
                    <div class="row m-2 bg-gray-500 text-white">
                        <div class="col-6">
                            Email
                        </div>
                        <div class="col-6">
                            {{ $customer->email }}
                        </div>
                    </div>
                    <div class="row m-2 bg-gray-500 text-white">
                        <div class="col-6">
                            Tel
                        </div>
                        <div class="col-6">
                            {{ $customer_address->phone_number }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card shadow-xs border h-100">
                <div class="card-header pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Address Information</h6>
                    <p class="text-sm">Billing Address</p>
                </div>
                <div class="card-body py-3">
                    <div class="row m-2">
                        <div class="col-12">
                            <p>
                            {{ $customer_address->street_address1 }}<br>
                            {{ $customer_address->street_address2 }}<br>
                            {{ $customer_address->street_address3 }}<br>
                            {{ $customer_address->city }}<br>
                            {{ $customer_address->state}}<br>
                            {{ $customer_address->country }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card shadow-xs border h-100">
                <div class="card-header pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Remarks</h6>
                    <p class="text-sm"></p>
                </div>
                <div class="card-body py-3">
                    <div class="row m-2">
                        <div class="col-12">
                            <p>
                                {{ $order->remarks ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card shadow-xs border h-100">
                <div class="card-header pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Items Ordered</h6>
                    <p class="text-sm"></p>
                </div>
                <div class="card-body py-3">
                    <div class="row m-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Product</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Product Description</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Price</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Qty</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                /** @var array<\App\Models\Products> $products */
                                @endphp
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $product->product_name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ isset($product->product_description) ? $product->product_description : 'N/A'  }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-normal mb-0">{{ $product->product_price.' '.$order->currency }}</p>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-normal">{{ $product->product_quantity }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-normal">{{ $product->product_price * $product->product_quantity.' '.$order->currency }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-lg-12">--}}
{{--            <div class="card shadow-xs border">--}}
{{--                <div class="card-header pb-0">--}}
{{--                    <div class="d-sm-flex align-items-center mb-3">--}}
{{--                        <div>--}}
{{--                            <h6 class="font-weight-semibold text-lg mb-0">Overview balance</h6>--}}
{{--                            <p class="text-sm mb-sm-0 mb-2">Here you have details about the balance.</p>--}}
{{--                        </div>--}}
{{--                        <div class="ms-auto d-flex">--}}
{{--                            <button type="button" class="btn btn-sm btn-white mb-0 me-2">--}}
{{--                                View report--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="d-sm-flex align-items-center">--}}
{{--                        <h3 class="mb-0 font-weight-semibold">$87,982.80</h3>--}}
{{--                        <span class="badge badge-sm border border-success text-success bg-success border-radius-sm ms-sm-3 px-2">--}}
{{--                  <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path d="M0.46967 4.46967C0.176777 4.76256 0.176777 5.23744 0.46967 5.53033C0.762563 5.82322 1.23744 5.82322 1.53033 5.53033L0.46967 4.46967ZM5.53033 1.53033C5.82322 1.23744 5.82322 0.762563 5.53033 0.46967C5.23744 0.176777 4.76256 0.176777 4.46967 0.46967L5.53033 1.53033ZM5.53033 0.46967C5.23744 0.176777 4.76256 0.176777 4.46967 0.46967C4.17678 0.762563 4.17678 1.23744 4.46967 1.53033L5.53033 0.46967ZM8.46967 5.53033C8.76256 5.82322 9.23744 5.82322 9.53033 5.53033C9.82322 5.23744 9.82322 4.76256 9.53033 4.46967L8.46967 5.53033ZM1.53033 5.53033L5.53033 1.53033L4.46967 0.46967L0.46967 4.46967L1.53033 5.53033ZM4.46967 1.53033L8.46967 5.53033L9.53033 4.46967L5.53033 0.46967L4.46967 1.53033Z" fill="#67C23A"></path>--}}
{{--                  </svg>--}}
{{--                  10.5%--}}
{{--                </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body p-3">--}}
{{--                    <div class="chart mt-n6">--}}
{{--                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
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

@section('footer_scripts2')
    @include('admin.layouts.footer_scripts2')
@endsection

@section('custom_scripts')
    <script>
        $(document).ready(function () {
            console.log("Working JS");
            check_expiry();
        });

        function check_expiry()
        {
            let order_id = '{{ $order->order_id }}';
            $.ajax({
                url: '{{ route('check_expiry') }}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                },
                data: { order_id: order_id },
                success: function(data){
                    if(data.status)
                    {
                        if(data.expired_status)
                        {
                            $('#order_expiry').html('<span class="badge badge-danger">Expired</span>&nbsp;&nbsp;<div class="d-flex pt-3"><button class="btn btn-success btn-sm" id="activate_btn">Re-Active</button></div>');
                        }
                        else
                        {
                            $('#order_expiry').html(data.order_expiry + ' ' + '<span class="badge badge-success">Active</span>');
                        }
                    }
                },
            });
        }

        $('#order_expiry').on('click', 'button', function(){
            let confirm_activate = confirm('Do you want to re-activate this order');
            if(confirm_activate) {
                let order_id = '{{ $order->order_id }}';
                $.ajax({
                    url: '{{ route('reactivate_order') }}',
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#activate_btn').html('Activating.. <i class="fa fa-spinner fa-spin"></i>');
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                    },
                    data: {order_id: order_id},
                    success: function (data) {
                        if (data.status) {
                            check_expiry();
                        } else {
                            alert("Failed to re-activate the order");
                        }
                    },
                });
            }
        });

        $('#btn_change_status').on('click', function(){
            let confirm_status = confirm('Do you want to change status');
            let status_text = $('#change_status').val();
            if(confirm_status) {
                let order_id = '{{ $order->order_id }}';
                $.ajax({
                    url: '{{ route('change_status') }}',
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#btn_change_status').html('Changing.. <i class="fa fa-spinner fa-spin"></i>');
                    },
                    complete: function () {
                        $('#btn_change_status').html('Change Status');
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                    },
                    data: {order_id: order_id, status_text: status_text},
                    success: function (data) {
                        if (data.status) {
                            check_expiry();
                        } else {
                            alert("Failed to change status of the order");
                        }
                    },
                });
            }
        });


        $('#resend_payment_link').on('click', function(){
            let confirm_activate = confirm('Do you want to re-sent payment link');
            if(confirm_activate) {
                let order_id = '{{ $order->order_id }}';
                let customer_name = '{{ $customer->first_name.' '.$customer->last_name }}';
                let customer_email = '{{ $customer->email }}';
                let order_date = '{{ \Carbon\Carbon::parse($order->order_date)->format('D, d M Y H:i:s')  }}';
                let street_address1 = '{{ $customer_address->street_address1 }}';
                let street_address2 = '{{ $customer_address->street_address2 }}';
                let street_address3 = '{{ $customer_address->street_address3 }}';
                let city = '{{ $customer_address->city }}';
                let state = '{{ $customer_address->state }}';
                let country = '{{ $customer_address->country }}';
                let zip_code = '{{ $customer_address->zip_code }}';
                let phone_number = '{{ $customer_address->phone_number }}';
                let payment_link = '{{ route('pay', ['mi' => $payment_link->token]) }}';

                $.ajax({
                    url: '{{ route('resent_payment_link') }}',
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#resend_payment_link').html('Resending.. <i class="fa fa-spinner fa-spin"></i>');
                        $('#resend_payment_link').attr('disabled', 'disabled');
                    },
                    complete: function() {
                        $('#resend_payment_link').html('Resend Payment Link');
                        $('#resend_payment_link').removeAttr('disabled');
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                    },
                    data: {
                        order_id: order_id,
                        customer_name: customer_name,
                        customer_email: customer_email,
                        order_date: order_date,
                        street_address1: street_address1,
                        street_address2: street_address2,
                        street_address3: street_address3,
                        city: city,
                        state: state,
                        country: country,
                        zip_code: zip_code,
                        phone_number: phone_number,
                        payment_link: payment_link
                    },
                    success: function (data) {
                        if (data.status) {
                            alert('Success! Email Sent');
                        } else {
                            if(data.expired)
                            {
                                alert('Email not sent, order is expired, reactivate order and send email');
                            }
                        }
                    },
                });
            }
        });
    </script>
@endsection
