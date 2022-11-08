@extends('layouts.app')

@section('title', __('Create billing account'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary active">{{ __('My account') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Billing account') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Create new') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Create new billing account to post rental offers.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="{{ route('newBillingAccountCreate') }}" id="UserProfileInfoForm">
                    @csrf
                    @method('POST')
                    <div class="card mb-3">


                        <span class="alert alert-warning text-danger error-text" style="display:none;" id="errors"><ul id="errors-list"></ul></span>

                        <div class="card-body">
                            <div class="card-header mb-3">
                                <h4>{{ __('Create new billing account') }}</h4>
                                <p>{{ __('The created account for settlements must be created with truth. If there are any errors, you will be informed. All data must be true. The data relates to your company or relevant billing data. This data will be available in the announcement.') }}</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Type account') }}</h6>
                                </div>
                                <div class="col-sm-9 row mb-2 align-items-center">
                                    <div class="col-auto">
                                    <select id="company" name="company" class="form-select form-select-lg" aria-label=".form-select-lg example">
                                        <option value="0">{{ __('Private') }}</option>
                                        <option value="1">{{ __('Company') }}</option>
                                    </select>
                                    </div>
                                    <div class="col-auto">
                                        <span class="d-flex form-text">
                                            {{ __('Private - Private data for billing') }}
                                        </span>
                                        <span class="d-flex form-text">
                                            {{ __('Company - Company data for billing') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Name and last name') }}</h6>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" name="name" aria-label="First name" class="form-control-sm form-control" style="width: 50%;" value="{{ $user->name }}">
                                        <input type="text" name="lname" aria-label="Last name" class="form-control-sm form-control" style="width: 50%;" value="{{ $user->lname }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Pesel') }}</h6>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="pesel" name="pesel" value="" placeholder="91061160095">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Company name') }}</h6>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="company_name" name="company_name" placeholder="Rent-House SP.Z.O.O">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Company nip') }}</h6>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="company_nip" name="company_nip" placeholder="123-456-78-90">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Company name') }}</h6>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="company_name" name="company_name" placeholder="Rent-House SP.Z.O.O">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Company website') }}</h6>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group flex-nowrap form-outline">
                                        <span class="input-group-text" id="symbolCreateLink">http://</span>
                                        <input name="company_website" id="company_website" type="text" class="form-control form-control-sm" aria-label="editLinks" aria-describedby="addon-wrapping" value="">
                                        <label class="form-label" for="company_website" id="commentCreateLink" style="margin-left: 53px;">{{ __('Your website address') }}.</label>
                                        <div class="form-notch"><div class="form-notch-leading" style="width: 62px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Address') }}</h6>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input name="country" class="form-control form-control-sm" list="datalistCountryOptions" id="country" placeholder="{{ __('Country') }}" style="width:50%" value="{{ $user->country }}">
                                        <input name="province" class="form-control form-control-sm" list="datalistProvinceOptions" id="province" placeholder="{{ __('Province') }}" value="{{ $user->province }}" style="width:50%">
                                    </div>
                                    <div class="input-group">
                                        <input name="zipcode" class="form-control form-control-sm zipcode" list="datalistZipcodeOptions" id="zipcode" placeholder="{{ __('Zip-Code') }}" value="{{ $user->zipcode }}" style="width:20%">
                                        <input name="city" class="form-control form-control-sm" list="datalistCityOptions" id="city" placeholder="{{ __('City') }}" value="{{ $user->city }}" style="width:30%">
                                        <input name="street" class="form-control form-control-sm" list="datalistStreetOptions" id="street" placeholder="{{ __('Street') }}" value="{{ $user->street }}" style="width:30%">
                                        <input name="building_number" class="form-control form-control-sm number" list="datalistNumberOptions" id="building_number" placeholder="{{ __('Number') }}" value="{{ $user->number }}" style="width:20%">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-header">{{ __('Comment on your application') }}.</div>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
                                <span class="">{{ __('You have') }} <span id="counter"></span> {{ __('characters left') }}.</span>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-warning">{{ __('Send') }} <i class="fa fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
