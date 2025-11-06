@extends('layouts.authlayout')

@section('main_content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg blur border-radius-sm top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid px-1">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 " href="#">
                            <img src="{{ asset('assets/img/moreideas-logo-color.png') }}" alt="More Ideas Logo" class="img-fluid" style="width: 10%"><img src="{{ asset('assets/img/byjus_new.png') }}" alt="More Ideas Logo" style="width: 10%; margin-left: 20px">
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                          </span>
                        </button>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    @if($expired)
    <section>
        <div class="page-header mt-7">
            <div class="container">
                <div class="row border-bottom-sm">
                    <div class="col-md-12">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-black text-dark display-6">Your Payment Link is Expired</h3>
                                <p class="mb-0">Please contact support for more details</p>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
    <section>
        <div class="page-header mt-7">
            <div class="container">
                <div class="row border-bottom-sm">
                    <div class="col-md-12">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-black text-dark display-6">Hi {{ $customer->first_name.' '.$customer->last_name }},</h3>
                                <p class="mb-0">Please check the details below, and pay your payment</p>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 border-bottom-sm">
                    <div class="col-6">
                        <div class="card card-plain">
                            <div class="card-header pb-0 bg-transparent">
                                <h6 class="font-weight-black text-dark">Order Information</h6>
                            </div>
                            <div class="card-body">
                                <div>Order #{{ $order->order_id }}</div>
                                <div>Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('D, d M Y H:i:s')  }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-plain">
                            <div class="card-header pb-0 bg-transparent">
                                <h6 class="font-weight-black text-dark">Account Information</h6>
                            </div>
                            <div class="card-body">
                                <div>Email: {{ $customer->email }}</div>
                                <div class="font-weight-black">Billing Address:</div>
                                <div>
                                    <div>{{ $customer_address->street_address1 }} {{ $customer_address->street_address2 }} {{ $customer_address->street_address3 }}</div>
                                    <div>{{ $customer_address->city }}</div>
                                    <div>{{ $customer_address->state }}</div>
                                    <div>{{ $customer_address->country }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card card-plain">
                            <div class="card-header pb-0 bg-transparent">
                                <h6 class="font-weight-black text-dark">Items Ordered</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center justify-content-center mb-0">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Product</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Price</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Qty</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($product as $p)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm">{{ $p->product_name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-normal mb-0">{{ $p->product_price.' '.$order->currency }}</p>
                                                </td>
                                                <td>
                                                    <span class="text-sm font-weight-normal">{{ $p->product_quantity }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-sm font-weight-normal">{{ $p->product_price * $p->product_quantity.' '.$order->currency }}</span>
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
                @if(($order_status->order_status_text === 'Pending'))
                <div class="row mt-2">
                    <input type="hidden" id="payment_option" value="creditcard">
                    <input type="hidden" id="amount" value="{{ $product_details->total_price }}">
                    <input type="hidden" id="currency" value="{{ $order->currency }}">
                    <input type="hidden" id="email" value="{{ $customer->email }}">
                    <input type="hidden" id="order" value="{{ $order->order_id }}">
                    <div class="d-flex justify-content-end">
                        <button type="button" id="pay_btn" class="btn btn-primary">Proceed with Payment &nbsp;<i aria-hidden="true" class="fas fa-check-circle"></i></button>
                    </div>
                </div>
                @elseif($order_status->order_status_text === 'Completed')
                <div class="row mt-2">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success text-white" disabled>Already Paid &nbsp; <i aria-hidden="true" class="far fa-credit-card"></i></button>
                    </div>
                </div>
                @elseif($order_status->order_status_text === 'Cancelled')
                <div class="row mt-2">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger" disabled>Cancelled &nbsp; <i aria-hidden="true" class="fa fa-exclamation-triangle"></i></button>
                    </div>
                </div>
                @elseif($order_status->order_status_text === 'Transaction Declined')
                    <div class="row mt-2">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-danger" disabled>Transaction Declined &nbsp; <i aria-hidden="true" class="fa fa-times-circle"></i></button>
                        </div>
                    </div>
                @else
                <div class="row mt-2">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger" disabled>Error!</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif
@endsection

@section('footer_scripts')
    @include('layouts.footer_scripts')
@endsection
@section("custom_scripts")
    <script
        src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/checkout.js') }}"></script>
    <script>
        $('#pay_btn').on('click',function () {
            let paymentMethod = $('#payment_option').val();
            let amount = $('#amount').val();
            let currency = $('#currency').val();
            let email = $('#email').val();
            let order = $('#order').val();
            let csrf = '{{ @csrf_token() }}';
            let url = '{{ route('payment_route', ['r' => 'getPaymentPage']) }}';
            if(paymentMethod == '' || paymentMethod === undefined || paymentMethod === null) {
                alert('Pelase Select Payment Method!');
                return;
            }
            if(paymentMethod == 'cc_merchantpage' || paymentMethod == 'installments_merchantpage') {
                window.location.href = 'confirm-order.php?payment_method='+paymentMethod;
            }
            if(paymentMethod == 'cc_merchantpage2') {
                var isValid = payfortFortMerchantPage2.validateCcForm();
                if(isValid) {
                    getPaymentPage(paymentMethod, amount, currency, email, order);
                }
            }
            else{
                $('#pay_btn').html('Proceeding... <i class="fas fa-spinner fa-spin"></i>');
                $('#pay_btn').attr('disabled', 'disabled');
                getPaymentPage(url, paymentMethod, amount, currency, email, order, csrf);
            }
        });
    </script>
@endsection



