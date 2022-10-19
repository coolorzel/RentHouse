@extends('layouts.app')

@section('title', __('Admin Dashboard'))

@section('content')
    <div class="container">
        <div class="main-body">

            <!-- Breadcrumb -->
            <div class="col-md-12 shadow p-3 mb-5 bg-body rounded">
                <p class="h2 text-secondary align-self-center">{{ __('Admin Dashboard') }}</p>
            </div>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3 shadow p-3 mb-5 bg-body rounded">
                    @include('layouts.elements.admin.sidebar')
                </div>
                <div class="col-md-8 shadow p-3 mb-5 bg-body rounded">
                    <div class="card mb-3">

                    </div>

                    <div class="row gutters-sm">
                        <div class="col-sm-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>

@endsection
