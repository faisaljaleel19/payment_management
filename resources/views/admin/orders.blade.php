@extends('admin.layouts.rootlayout')
@section('title', 'Payment Management System | Orders')
@section('custom_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('sidebar')
    @include('admin.layouts.sidebar')
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
                        Open the order to view the details
                    </p>
{{--                    <button type="button" class="btn btn-outline-white btn-blur btn-icon d-flex align-items-center mb-0">--}}
{{--                <span class="btn-inner--icon">--}}
{{--                  <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="d-block me-2">--}}
{{--                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14ZM6.61036 4.52196C6.34186 4.34296 5.99664 4.32627 5.71212 4.47854C5.42761 4.63081 5.25 4.92731 5.25 5.25V8.75C5.25 9.0727 5.42761 9.36924 5.71212 9.52149C5.99664 9.67374 6.34186 9.65703 6.61036 9.47809L9.23536 7.72809C9.47879 7.56577 9.625 7.2926 9.625 7C9.625 6.70744 9.47879 6.43424 9.23536 6.27196L6.61036 4.52196Z" />--}}
{{--                  </svg>--}}
{{--                </span>--}}
{{--                        <span class="btn-inner--text">Watch more</span>--}}
{{--                    </button>--}}
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
                            <h6 class="font-weight-semibold text-lg mb-0">Orders</h6>
                            <p class="text-sm">See information about all orders</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-white me-2">
                                View all
                            </button>
                            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2" onclick="window.location.href='{{ route('customers') }}'">
                    <span class="btn-inner--icon">
                      <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                        <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                      </svg>
                    </span>
                                <span class="btn-inner--text">Create Order</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0 m-2">
                        <table class="table align-items-center mb-0" id="OrderTable">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">ID</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Order No.</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Billing To</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Email</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Grand Total</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Expiry Status</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Action</th>
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
    <script>
        $(document).ready(function () {
            console.log("Working JS");
            order_list();

        });

        function order_list()
        {
            table = $('#OrderTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: "{{ route('order_list') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order_number', name: 'order_number'},
                    { data: 'full_name', name: 'full_name'},
                    { data: 'email', name: 'email'},
                    { data: 'total_price', name: 'total_price'},
                    {
                        data: 'order_status_text', name: 'order_status_text',
                        render: function (data, type, row, meta) {
                            if(data === 'Pending')
                            {
                                return '<span class="badge badge-pill badge-info">Pending</span>';
                            }
                            else if(data === 'Completed')
                            {
                                return '<span class="badge badge-pill badge-success">Completed</span>';
                            }
                            else if(data === 'Cancelled')
                            {
                                return '<span class="badge badge-pill badge-danger">Cancelled</span>';
                            }
                            else
                            {
                                return '<span class="badge bg-gradient-danger">Failed</span>';
                            }
                        }
                    },
                    { data: 'expiry_status', name: 'expiry_status'},
                    { data: 'action', name: 'action'},
                ]
            });
        }

        $('#OrderTable').on('click', 'button', function(){
            let order_id = $(this).data('order-id');
            let url = '{{ route('view_order', ['order_id' => 'o_id']) }}';
            url = url.replace('o_id', order_id);
            window.location = url;
        });
    </script>
@endsection
