@extends('layouts.authlayout')

@section('main_content')
    <section>
        <div class="page-header mt-7">
            <div class="container">
                <div class="row border-bottom-sm">
                    <div class="col-md-12">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-black text-dark display-6">Page Not Found</h3>
                                <p class="mb-0">Please check the url, or try again later</p>
                            </div>
                            <div class="card-body">

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



