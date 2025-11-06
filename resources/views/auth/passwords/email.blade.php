@extends('layouts.authlayout')

@section('main_content')
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-black text-dark display-6">Password Reset</h3>
                                <p class="mb-0">Enter Your email Address which registered with us.</p>
                            </div>
                            <div class="card-body">
                                <form role="form"  method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <label>Email Address</label>
                                    <div class="mb-3">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-label="Email" aria-describedby="email-addon">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Send Password Reset Link</button>
                                    </div>
                                </form>
                            </div>
                            {{--                            <div class="card-footer text-center pt-0 px-lg-2 px-1">--}}
                            {{--                                <p class="mb-4 text-xs mx-auto">--}}
                            {{--                                    Don't have an account?--}}
                            {{--                                    <a href="javascript:;" class="text-dark font-weight-bold">Sign up</a>--}}
                            {{--                                </p>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                            <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8" style="background-image:url('{{ url('assets/img/image-sign-in.jpg') }}')">
                                <div class="blur mt-12 p-4 text-center border border-white border-radius-md position-absolute fixed-bottom m-4">
                                    <h2 class="mt-3 text-dark font-weight-bold">Payment Management System</h2>
                                    <h6 class="text-dark text-sm mt-5">Copyright © 2023 More Ideas</h6>
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
