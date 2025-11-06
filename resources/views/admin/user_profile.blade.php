@extends('admin.layouts.rootlayout')
@section('title', 'Customers')
@section('custom_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('sidebar')
    @include('admin.layouts.sidebar')
@endsection
@section('first_page')
    <a href="#">Your Profile</a>
@endsection
@section('current_page')
    Your Profile
@endsection
@section('page_title')
    Your Profile
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
                        Your Profile
                    </p>
                    <img src="{{ asset('assets/img/3d-cube.png') }}" alt="3d-cube" class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
{{--            @if ($errors->any())--}}
{{--                <div class="alert alert-danger">--}}
{{--                    <ul>--}}
{{--                        @foreach ($errors->all() as $error)--}}
{{--                            <li>{{ $error }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            @endif--}}
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('current_password'))
                <div class="alert alert-danger">
                    {{ session()->get('current_password') }}
                </div>
            @endif
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Change your Profile</h6>
                            <p class="text-sm">Account Information</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="container mt-2">
                        <form class="form" method="POST" action="{{ route('update_profile') }}">
                            @csrf
                            <label for="full_name">Full Name</label>
                            <div class="mb-3">
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ $get_current_user->name }}"  required>
                                @error('full_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="email">Email</label>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" value="{{ $get_current_user->email }}" required readonly>
                            </div>
                            <label for="current_password">Enter Current Password</label>
                            <div class="mb-3">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                @error('current_password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="password">New Password</label>
                            <div class="mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="mb-3">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
