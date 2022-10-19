@extends('layouts.app')

@section('title', __('Page Settings'))

@section('content')
    <div class="container">
        <div class="main-body">

            <!-- Breadcrumb -->
            <div class="col-md-12 shadow p-3 mb-5 bg-body rounded d-flex">
                <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button><a class="btn btn-outline-secondary">{{ __('ACP') }}</a><a class="btn btn-outline-secondary active">{{ __('Page settings') }}</a>
            </div>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3 shadow p-3 mb-5 bg-body rounded">
                    @include('layouts.elements.admin.sidebar')
                </div>
                <div class="col-md-8 shadow p-3 mb-5 bg-body rounded">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h3 mb-4 page-title">Settings</h2>
                            <div class="my-4">
                                <div class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
                                        <button class="nav-link active" id="nav-page-tab" data-bs-toggle="tab" data-bs-target="#nav-page-settings" type="button" role="tab" aria-controls="nav-page-settings" aria-selected="true">
                                            {{ __('Page') }}</button>
                                        <button class="nav-link" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users-settings" type="button" role="tab" aria-controls="nav-users-settings" aria-selected="false">
                                            {{ __('Users') }}</button>
                                        <button class="nav-link" id="nav-notifications-tab" data-bs-toggle="tab" data-bs-target="#nav-notifications-settings" type="button" role="tab" aria-controls="nav-notifications-settings" aria-selected="false">
                                            {{ __('Notification') }}</button>
                                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact-settings" type="button" role="tab" aria-controls="nav-contact-settings" aria-selected="false">
                                            {{ __('Contact') }}</button>
                                </div>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-page-settings" role="tabpanel" aria-labelledby="nav-page-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.page')</div>
                                    <div class="tab-pane fade" id="nav-users-settings" role="tabpanel" aria-labelledby="nav-users-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.user')</div>
                                    <div class="tab-pane fade" id="nav-notifications-settings" role="tabpanel" aria-labelledby="nav-notifications-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.notifications')</div>
                                    <div class="tab-pane fade" id="nav-contact-settings" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.contact')</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
