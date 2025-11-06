@extends('admin.layouts.rootlayout')
@section('title', 'Customers')
@section('custom_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('sidebar')
    @include('admin.layouts.sidebar')
@endsection
@section('first_page')
    <a href="{{ route('customers') }}">Customers</a>
@endsection
@section('current_page')
    Add Customer
@endsection
@section('page_title')
    Add Customer
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
                        Add Customer
                    </p>
                    <img src="{{ asset('assets/img/3d-cube.png') }}" alt="3d-cube" class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
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
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Add New Customer</h6>
                            <p class="text-sm">Account Information</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="container mt-2">
                        <form class="form" method="POST" action="{{ route('create_customer') }}">
                            @csrf
                            <label for="first_name">First Name<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                            </div>
                            <label for="last_name">Last Name</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
                            </div>
                            <label for="email">Email<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <label for="gender">Gender<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="Male">
                                    <label class="form-check-label" for="gender">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="Female">
                                    <label class="form-check-label" for="gender">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm">Billing Information</p>
                            </div>
                            <label for="street_address1">Street Address<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="street_address1" name="street_address1" value="{{ old('street_address1')  }}" required>
                                <input type="text" class="form-control mt-3" id="street_address2" name="street_address2" value="{{ old('street_address2')  }}">
                                <input type="text" class="form-control mt-3" id="street_address3" name="street_address3" value="{{ old('street_address3')  }}">
                            </div>
                            <label for="city">City<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                            </div>
                            <label for="state">State/Province<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required>
                            </div>
                            <label for="country">Country<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <select class="form-control" name="country" id="country" required>
                                    <option value="" {{ old('country') === '' ? 'selected' : '' }}>--Select Country--</option>
                                    <option value="United Arab Emirates" {{ old('country') === 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                    <option value="Kuwait" {{ old('country') === 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                    <option value="Qatar" {{ old('country') === 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                    <option value="Oman" {{ old('country') === 'Oman' ? 'selected' : '' }}>Oman</option>
                                    <option value="Saudi Arabia" {{ old('country') === 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                    <option value="Bahrain" {{ old('country') === 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                                </select>
                            </div>
                            <label for="zip_code">Zip/Postal Code<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                            </div>
                            <label for="phone_number">Phone Number<sup class="text-danger font-weight-bolder">*</sup></label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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
            customer_list();

        });

        function customer_list()
        {
            table = $('#CustomersTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer_list') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'email', name: 'email'},
                    { data: 'full_name', name: 'full_name'},
                    { data: 'gender', name: 'gender'},
                ]
            });
        }
    </script>
@endsection
