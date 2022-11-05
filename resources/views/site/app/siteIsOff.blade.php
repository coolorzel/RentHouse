@extends('layouts.app')

@section('title', __('My profile'))

@section('content')
    <div class="row gutters-sm">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <i class="fa fa-wrench fa-5x text-warning"></i> <h1 class="error-title">{{ __('Technical work') }}</h1>
                    <p class="fs-5 text-gray-600">{{ __('We are sorry but the page is unavailable. Technical works are underway to introduce new functionalities of our application.') }}</p>
                    <p class="fs-5 text-grey-600">{{ __('Regards, Team') }} <b>{{ config('global.page_name', 'RentHouse') }}</b></p>
                </div>
            </div>
        </div>
    </div>

@endsection
