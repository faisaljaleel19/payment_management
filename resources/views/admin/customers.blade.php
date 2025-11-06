@extends('admin.layouts.rootlayout')
@section('title', 'Payment Management System | Customers')
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
                        Check all the advantages and choose the best.
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
                            <h6 class="font-weight-semibold text-lg mb-0">Customer List</h6>
                            <p class="text-sm">See information about all customers</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-white me-2">
                                View all
                            </button>
                            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2" onclick="window.location.href='{{ route('add_customer') }}'">
                    <span class="btn-inner--icon">
                      <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                        <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                      </svg>
                    </span>
                                <span class="btn-inner--text">Add Customer</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0 m-2">
                        <table class="table align-items-center mb-0" id="CustomersTable">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">ID</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Email</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Full Name</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Gender</th>
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
    <div class="modal modal-lg fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="form-group row">
                            <div class="col-3">
                                <label for="first_name">First Name<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="first_name" name="first_name">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="last_name">Last Name</label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="last_name" name="last_name">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="email">Email<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-3">
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
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <label for="street_address1">Street Address<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="street_address1" name="street_address1">
                                    <input type="text" class="form-control mt-3" id="street_address2" name="street_address2">
                                    <input type="text" class="form-control mt-3" id="street_address3" name="street_address3">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="city">City<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="city" name="city">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="state">State/Province<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="state" name="state">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="country">Country<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <select class="form-control" name="country" id="country">
                                        <option value="">--Select Country--</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Bahrain">Bahrain</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="zip_code">Zip/Postal Code<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="zip_code" name="zip_code">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="phone_number">Phone Number<sup class="text-danger font-weight-bolder">*</sup></label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="phone_number" name="phone_number">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="update_details">Submit</button>
                        </div>
                        <div id="error_msg"></div>
                    </form>
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
                    { data: 'action', name: 'action'}
                ]
            });
        }

        $('#CustomersTable').on('click', 'button', function(){
            let customer_id = $(this).data('customer-id');
            let edit_id = $(this).data('edit-id');
            if(customer_id !== undefined) {
                let url = '{{ route('add_order', ['customer_id' => 'cust_id']) }}';
                url = url.replace('cust_id', customer_id);
                window.location = url;
            }
            if(edit_id !== undefined)
            {
                $.ajax({
                    url: '{{ route('get_customer') }}',
                    type: 'post',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                    },
                    data: { id: edit_id },
                    success: function (data) {
                        console.log(data);
                        if (data.status) {
                            $('#customer_id').val(edit_id);
                            $('#first_name').val(data.first_name);
                            $('#last_name').val(data.last_name);
                            $('#email').val(data.email);
                            //$('#gender').val();
                            let gender = data.gender;
                            $("input[name='gender'][value='"+gender+"']").prop("checked",true);
                            $('#street_address1').val(data.street_address1);
                            $('#street_address2').val(data.street_address2);
                            $('#street_address3').val(data.street_address3);
                            $('#city').val(data.city);
                            $('#state').val(data.state);
                            $('#country').val(data.country);
                            $('#zip_code').val(data.zip_code);
                            $('#phone_number').val(data.phone_number);
                            $('#customerModal').modal('show');
                        }
                    },
                });
            }
        });

        $('#update_details').on('click', function(){
           let customer_id = $('#customer_id').val();
           let first_name = $('#first_name').val();
           let last_name = $('#last_name').val();
           let email = $('#email').val();
           let gender = $('#gender').val();
           let street_address1 = $('#street_address1').val();
           let street_address2 = $('#street_address2').val();
           let street_address3 = $('#street_address3').val();
           let city = $('#city').val();
           let state = $('#state').val();
           let country = $('#country').val();
           let zip_code = $('#zip_code').val();
           let phone_number = $('#phone_number').val();
           if((first_name !== '') && (last_name !== '') && (email !== '') && (gender !== '') && (street_address1 !== '') && (city !== '')
               && (state !== '') && (country !== '') && (zip_code !== '') && (phone_number !== ''))
           {
               $.ajax({
                   url: '{{ route('update_customer') }}',
                   type: 'post',
                   dataType: 'json',
                   headers: {
                       'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                   },
                   data: {
                       customer_id: customer_id,
                       first_name: first_name,
                       last_name: last_name,
                       email: email,
                       gender: gender,
                       street_address1: street_address1,
                       street_address2: street_address2,
                       street_address3: street_address3,
                       city: city,
                       state: state,
                       country: country,
                       zip_code: zip_code,
                       phone_number: phone_number
                   },
                   success: function (data) {
                        if(data.status)
                        {
                            $('#error_msg').addClass('alert alert-success');
                            $('#error_msg').html('Customer Data Updated Successfully');
                            $('#error_msg').show();
                            setTimeout(hideMsg, 4000);
                            setTimeout(hideModal, 4000);
                        }
                        else
                        {
                            if(data.message)
                            {
                                $('#error_msg').addClass('alert alert-danger');
                                $('#error_msg').html(data.message);
                                $('#error_msg').show();
                                setTimeout(hideMsg, 4000);
                            }
                            else {
                                $('#error_msg').addClass('alert alert-danger');
                                $('#error_msg').html('Error Occurred while updating');
                                $('#error_msg').show();
                                setTimeout(hideMsg, 4000);
                            }
                        }
                   }
               });
           }
           else
           {
                $('#error_msg').addClass('alert alert-danger');
                $('#error_msg').html('<sup>*</sup> Marked Fields are required');
                setTimeout(hideMsg, 4000);
           }
        });

        function hideMsg()
        {
            $('#error_msg').removeClass('alert alert-danger');
            $('#error_msg').removeClass('alert-success');
            $('#error_msg').html('');
            $('#error_msg').hide();
        }

        function hideModal()
        {
            $('#customerModal').modal('hide');
        }
    </script>
@endsection
