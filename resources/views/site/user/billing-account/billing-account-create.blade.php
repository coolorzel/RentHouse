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
                <div class="card">
                    <div class="card-body">

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6 border-right">
                                <div class="p-3 py-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-header">Wniosek</h4>
                                    </div>
                                    <form action="">
                                        <div class="row mt-2">
                                            <div class="col-md-6"><label class="labels">Imię</label><input type="text" class="form-control" required pattern="[A-Z]{1}[a-z]{1,20}"></div>
                                            <div class="col-md-6"><label class="labels">Nazwisko</label><input type="text" class="form-control" required pattern="[A-Z]{1}[a-z]{1,30}"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12"><label class="labels">Pesel</label><input type="text" class="form-control" required pattern="[0-9]{11}"></div>
                                            <div class="col-md-12"><label class="labels">Numer telefonu</label><input type="text" class="form-control" required pattern="[0-9]{9}"></div>
                                            <div class="col-md-12"><label class="labels">Państwo</label><input type="text" class="form-control" required pattern="[A-Z]{1}[a-z]{1,20}"></div>
                                            <div class="col-md-12"><label class="labels">Województwo</label><input type="text" class="form-control" required pattern="[A-Z]{1}[a-z]{1,20}"></div>
                                            <div class="col-md-12"><label class="labels">Miasto</label><input type="text" class="form-control" required pattern="[A-Z]{1}[a-z]{1,20}"></div>
                                            <div class="col-md-12"><label class="labels">Ulica</label><input type="text" class="form-control" required pattern="[A-Z]{1}[a-z]{1,50}"></div>
                                            <div class="col-md-12"><label class="labels">Numer domu</label><input type="text" class="form-control" required pattern="[0-9]{1,3}"></div>
                                            <div class="col-md-12"><label class="labels">Nazwa firmy</label><input type="text" class="form-control" required pattern="[A-Z]{1}[a-z]{1,50}"></div>
                                        </div>

                                        <style>
                                            input:invalid {
                                                border: red solid 3px;
                                            }
                                        </style>
                                    </form>
                                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Złóż wniosek</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
