@extends('admin.layouts.rootlayout')
@section('title', 'Payment Management System | Transaction')
@section('custom_styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('sidebar')
@include('admin.layouts.sidebar')
@endsection

@section('first_page')
    <a href="#">Transaction</a>
@endsection
@section('current_page')
    Transaction
@endsection
@section('page_title')
    Transaction
@endsection

@section('navbar')
@include('admin.layouts.navbar')
@endsection

@section('main_content')
<div class="row">
    <div class="col-12">
        <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
            <div class="full-background" style="background-image: url('{{ asset('assets/img/header-blue-purple.jpg') }}')"></div>
            <div class="card-body text-start p-4 w-100">
                <h3 class="text-white mb-2">Payment Management System</h3>
                <p class="mb-4 font-weight-semibold">
                    Transactions
                </p>
                <img src="{{ asset('assets/img/3d-cube.png') }}" alt="3d-cube" class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Transactions</h6>
                        <p class="text-sm">Check below for all transactions</p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="table-responsive p-0 m-2">
                    <table class="table align-items-center mb-0" id="TransactionTable">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Order ID</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Request Type</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Email</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Command</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Response Message</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">View</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" style="font-size: 0.8em; width: 100%">
                        <tr>
                            <th>Order No.</th>
                            <td id="order_id"></td>
                        </tr>
                        <tr>
                            <th>Request Type</th>
                            <td id="request_type"></td>
                        </tr>
                        <tr>
                            <th>Currency</th>
                            <td id="currency"></td>
                        </tr>
                        <tr>
                            <th>Customer Email</th>
                            <td id="customer_email"></td>
                        </tr>
                        <tr>
                            <th>Command</th>
                            <td id="command"></td>
                        </tr>
                        <tr>
                            <th>Language</th>
                            <td id="language"></td>
                        </tr>
                        <tr>
                            <th>Return Url</th>
                            <td id="return_url"></td>
                        </tr>
                        <tr>
                            <th>Response Code</th>
                            <td id="response_code"></td>
                        </tr>
                        <tr>
                            <th>Payment Option</th>
                            <td id="payment_option"></td>
                        </tr>
                        <tr>
                            <th>Customer IP</th>
                            <td id="customer_ip"></td>
                        </tr>
                        <tr>
                            <th>Fort ID</th>
                            <td id="fort_id"></td>
                        </tr>
                        <tr>
                            <th>Response Message</th>
                            <td id="response_message"></td>
                        </tr>
                        <tr>
                            <th>Transaction Status</th>
                            <td id="transaction_status"></td>
                        </tr>
                        <tr>
                            <th>Transaction Date</th>
                            <td id="transaction_date"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
{{--                <button type="button" class="btn btn-primary">Save changes</button>--}}
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

@section('footer_scripts2')
@include('admin.layouts.footer_scripts2')
@endsection

@section('custom_scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script>
    $(document).ready(function () {
        console.log("Working JS");
        customer_list();
    });

    function customer_list()
    {
        table = $('#TransactionTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "{{ route('transaction_list') }}",
            columns: [
                {data: 'order_id', name: 'order_id'},
                {
                    data: 'request_type', name: 'request_type',
                    render: function (data, type, row, meta) {
                        if(data === 'Request')
                        {
                            return '<span class="badge badge-sm border border-danger text-danger bg-danger">Request <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="16 12 12 8 8 12"></polyline><line x1="12" y1="16" x2="12" y2="8"></line></svg> </span>';
                        }
                        else
                        {
                            return '<span class="badge badge-sm border border-success text-success bg-success">Response <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="8 12 12 16 16 12"></polyline><line x1="12" y1="8" x2="12" y2="16"></line></svg></span>';
                        }
                    }
                },
                {data: 'customer_email', name: 'customer_email'},
                {data: 'command', name: 'command'},
                {
                    data: 'response_message', name: 'response_message',
                    render: function (data, type, row, meta) {
                        if(data === 'Success')
                        {
                            return '<span class="badge badge-pill bg-success text-success">Success</span>';
                        }
                        else if(data === null)
                        {
                            return '-';
                        }
                        else
                        {
                            return '<span class="badge badge-pill bg-danger text-danger">'+ data +'</span>';
                        }
                    }
                },
                {data: 'action', name: 'action'},
            ]
        });
    }

    $('#TransactionTable').on('click', 'button', function(){
       console.log($(this).data('id'));
        let transaction_id = $(this).data('id');
        if(transaction_id !== undefined) {
            $.ajax({
                url: '{{ route('get_transaction') }}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                },
                data: {transaction_id: transaction_id},
                success: function (data) {
                    console.log(data);
                    if (data.data) {
                        $('#order_id').html(data.data.order_id);
                        $('#request_type').html(data.data.request_type);
                        $('#currency').html(data.data.currency);
                        $('#customer_email').html(data.data.customer_email);
                        $('#command').html(data.data.command);
                        $('#language').html(data.data.language);
                        $('#return_url').html(data.data.return_url);
                        $('#response_code').html(data.data.response_code);
                        $('#payment_option').html(data.data.payment_option);
                        $('#customer_ip').html(data.data.customer_ip);
                        $('#fort_id').html(data.data.fort_id);
                        $('#response_message').html(data.data.response_message);
                        $('#transaction_status').html(data.data.transaction_status);
                        let momentObj = moment.utc(data.data.created_at);
                        let formattedDateTime = momentObj.format('DD MMM YYYY h:mm:ss A');
                        $('#transaction_date').html(formattedDateTime);
                        $('#transactionModal').modal('show');
                    }
                },
            });
        }
    });
</script>
@endsection
