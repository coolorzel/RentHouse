@extends('layouts.app')

@section('title', __('Select type offer'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('Offer') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Step 1 (Type offer)') }}</button>
        <button class="btn btn-outline-secondary" disabled>{{ __('Step 2 (Create offer)') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Select type offer.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <style>
        .create-object {
            box-shadow: 0 2px 20px 0 rgba(255, 255, 255, 0.25), 0 3px 10px 14px rgba(0, 0, 0, 0.02) !important;
            display: inline-flex;
            color: #c4c4c4;
            border-radius: 50%;
            text-align: center;
            vertical-align: middle;
            position: relative;
            margin: 20px;
            width: 150px;
            height: 150px;
        }
        .create-object:hover {
            box-shadow: 0 2px 20px 0 rgba(0, 0, 0, .25), 0 3px 10px 14px rgba(0, 0, 0, 0.02) !important;
            color: #888888;
        }

        .link-object {
            font-size: 8rem;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 150px;
        }


        .link-text {
            font-size: 2rem;
            display: inline;
            justify-content: center;
            align-items: center;
        }

        /* HIDE RADIO */
        [type=radio] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* IMAGE STYLES */
        [type=radio] + img {
            cursor: pointer;
        }

        /* CHECKED STYLES */
        [type=radio]:checked + img {
            outline: 2px solid #f00;
        }

    </style>
    <div class="row gutters-sm">
        <div class="col-md-12 p-3 mb-5 bg-body rounded">
            <ul class="nav nav-pills nav-fill">
                @foreach($categories as $category)
                    <li class="nav-item d-flex">
                        <button class="btn btn-outline-warning" data-route="{{ route('offerCreate', strtolower($category['name'])) }}">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <i class="fa {{ $category['photo'] }} fa-5x"></i>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <span class="link-text">{{ $category['name'] }}</span>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
