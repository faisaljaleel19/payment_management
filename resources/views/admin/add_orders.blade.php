@extends('admin.layouts.rootlayout')
@section('title', 'Payment Management System | Add Order')
@section('custom_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('sidebar')
    @include('admin.layouts.sidebar')
@endsection

@section('first_page')
    <a href="{{ route('orders') }}">Orders</a>
@endsection
@section('current_page')
    Add Order
@endsection
@section('page_title')
    Add Order
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
                        Add Order
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
                            <h6 class="font-weight-semibold text-lg mb-0">Add New Order</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="container mt-2">
                        <form class="form" method="POST" action="{{ route('create_order') }}" id="create_order">
                            @csrf
                            <p class="text-sm">Add Product</p>
                            <div id="productsContainer">
                                <!-- Product details will be dynamically added here -->
                            </div>
                            <div class="my-2">
                                <button id="addProduct" class="btn btn-primary">Add Product</button>
                            </div>
                            <input type="hidden" id="customer_id" name="customer_id" value="{{ $customers->id }}">
                            <label for="customer_details">Select Customer Address Details</label>
                            <div class="mb-3">
                                <select class="form-control" id="customer_details" name="customer_details">
                                @foreach($customer_address as $cs)
                                    <option value="{{ $cs->id }}">{{ $customers->first_name. ' '.$customers->last_name.', '.$cs->street_address1.', '.$cs->street_address2  }}</option>
                                @endforeach
                                </select>
                            </div>
                            <label for="first_name">First Name</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="first_name" name="first_name" required value="{{ $customers->first_name }}">
                            </div>
                            <label for="last_name">Last Name</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $customers->last_name }}">
                            </div>
                            <div>
                                <p class="text-sm">Billing Information</p>
                            </div>
                            <label for="street_address1">Street Address</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="street_address1" name="street_address1" value="{{ $customers->street_address1 }}" required>
                                <input type="text" class="form-control mt-3" id="street_address2" name="street_address2" value="{{ isset($customers->street_address2) ? $customers->street_address2 : '' }}">
                                <input type="text" class="form-control mt-3" id="street_address3" name="street_address3" value="{{ isset($customers->street_address3) ? $customers->street_address3 : '' }}">
                            </div>
                            <label for="city">City</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="city" name="city"  value="{{ $customers->city }}" required>
                            </div>
                            <label for="state">State/Province</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="state" name="state" value="{{ isset($customers->state) ? $customers->state: ''}}" required>
                            </div>
                            <label for="country">Country</label>
                            <div class="mb-3">
                                <select class="form-control" name="country" id="country" required>
                                    <option value="">--Select Country--</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Bahrain">Bahrain</option>
                                </select>
                            </div>
                            <label for="zip_code">Zip/Postal Code</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                            </div>
                            <label for="phone_number">Phone Number</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                            </div>
                            <label for="currency">Currency</label>
                            <div class="mb-3">
                                <select class="form-control" name="currency" id="currency">
                                    <option value="">--Select currency--</option>
                                    <option value="AED">AED</option>
                                    <option value="BHD">BHD</option>
                                    <option value="OMR">OMR</option>
                                    <option value="KWD">KWD</option>
                                    <option value="SAR">SAR</option>
                                    <option value="QAR">QAR</option>
                                </select>
                            </div>
                            <label for="remarks">Remarks</label>
                            <div class="mb-3">
                                <textarea class="form-control" name="remarks" id="remarks">

                                </textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" id="submit_order">Submit</button>
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
            @foreach($customer_address as $cs)
            $('#country').val('{{ $cs->country }}');
            $('#city').val('{{ $cs->city }}');
            $('#state').val('{{ $cs->state }}');
            $('#zip_code').val('{{ $cs->zip_code }}');
            $('#street_address1').val('{{ $cs->street_address1 }}');
            $('#street_address2').val('{{ $cs->street_address2 }}');
            $('#street_address3').val('{{ $cs->street_address3 }}');
            $('#phone_number').val('{{ $cs->phone_number }}');
            @endforeach
            console.log("Working JS");
            customer_list();
            var productCount = 0; // Counter for dynamically added products

            // Add product button click event
            $("#addProduct").click(function() {
                var productHtml = `
                  <div class="product mb-3 row">
                    <h5>Item ${productCount + 1}</h5>
                    <div class="col-3">
                    <input type="text" name="product_name[]" placeholder="Product Name" class="form-control" required>
                    </div>
                    <div class="col-3">
                    <input type="text" name="product_description[]" placeholder="Product Description" class="form-control" required>
                    </div>
                    <div class="col-2">
                    <input type="number" name="product_price[]" placeholder="Product Price" step="0.01" class="form-control" required>
                    </div>
                    <div class="col-2">
                    <input type="number" name="product_quantity[]" placeholder="Product Qty" class="form-control" required>
                    </div>
                    <div class="col-2">
                    <button class="removeProduct btn btn-danger">Remove</button>
                    </div>
                  </div>
                `;
                $("#productsContainer").append(productHtml);
                productCount++;
                $("#submit_order").removeAttr('disabled') // Show the "Submit Products" button
            });

            // Remove product button click event
            $("#productsContainer").on("click", ".removeProduct", function() {
                $(this).closest(".product").remove();
                productCount--;
                if (productCount === 0) {
                    $("#submit_order").attr('disabled', 'disabled'); // Hide the "Submit Products" button if there's only one product left
                }
            });
            if (productCount === 0) {
                $("#submit_order").attr('disabled', 'disabled'); // Hide the "Submit Products" button if there's only one product left
            }
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

        $('#customer_details').on('change', function(){
            let cust_address_id = $('#customer_details').val();
            let c_id ='';
            console.log(cust_address_id);
            @foreach($customer_address as $ca)
                c_id = '{{ $ca->id }}';
                if(cust_address_id === c_id)
                {
                    $('#country').val('{{ $ca->country }}');
                    $('#city').val('{{ $ca->city }}');
                    $('#state').val('{{ $ca->state }}');
                    $('#zip_code').val('{{ $ca->zip_code }}');
                    $('#street_address1').val('{{ $ca->street_address1 }}');
                    $('#street_address2').val('{{ $ca->street_address2 }}');
                    $('#street_address3').val('{{ $ca->street_address3 }}');
                    $('#phone_number').val('{{ $ca->phone_number }}');
                }
            @endforeach
        });

        $("#create_order").submit(function (e) {

            //stop submitting the form to see the disabled button effect
            //disable the submit button
            $("#submit_order").attr("disabled", "disabled");

            return true;
        });
    </script>
@endsection
