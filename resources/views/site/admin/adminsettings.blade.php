@extends('layouts.app')

@section('title', __('Page Settings'))

@section('content')
    <div class="container">
        <div class="main-body">

            <!-- Breadcrumb -->
            <div class="col-md-12 shadow p-3 mb-5 bg-body rounded">
                <p class="h2 text-secondary align-self-center">{{ __('Page settings') }}</p>
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
                                    <div class="tab-pane fade" id="nav-users-settings" role="tabpanel" aria-labelledby="nav-users-tab" tabindex="0">Users</div>
                                    <div class="tab-pane fade" id="nav-notifications-settings" role="tabpanel" aria-labelledby="nav-notifications-tab" tabindex="0">Notifications</div>
                                    <div class="tab-pane fade" id="nav-contact-settings" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">Contact</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="post" action="{{ route('adminSettingsStore') }}">
                                @csrf
                                <div class="row mb-2 g-3 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="inputPageTitle" class="col-form-label">Title</label>
                                    </div>
                                    <div class="col-auto">
                                        <input name="title" type="text" id="inputPageTitle" class="form-control" aria-describedby="titleHelpInline">
                                    </div>
                                    <div class="col-auto">
                                        <span id="titleHelpInline" class="form-text">
                                          {{ __('Must be 1-20 characters long.') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2 g-3 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="inputPageDescription" class="col-form-label">{{ __('Description') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        <input name="description" type="text" id="inputPageDescription" class="form-control" aria-describedby="descriptionHelpInline">
                                    </div>
                                    <div class="col-auto">
                                        <span id="descriptionHelpInline" class="form-text">
                                          {{ __('Must be 1-20 characters long.') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2 g-3 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="inputPageStatus" class="col-form-label">{{ __('Page status (ON/OFF)') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="pageStatus" value="1" id="onPageStatus" autocomplete="off" checked>
                                        <label class="btn btn-outline-success" for="onPageStatus">ON</label>

                                        <input type="radio" class="btn-check" name="pageStatus" value="0" id="offPageStatus" autocomplete="off">
                                        <label class="btn btn-outline-danger" for="offPageStatus">OFF</label>
                                    </div>
                                    <div class="col-auto">
                                        <span id="titleHelpInline" class="form-text">
                                          {{ __('It must be checked for the website to be available to users.') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2 g-3 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="inputPageStatus" class="col-form-label">{{ __('Adding offers (ON/OFF)') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="offersStatus" value="1" id="onOffersStatus" autocomplete="off" checked>
                                        <label class="btn btn-outline-success" for="onOffersStatus">ON</label>

                                        <input type="radio" class="btn-check" name="offersStatus" value="0" id="offOffersStatus" autocomplete="off">
                                        <label class="btn btn-outline-danger" for="offOffersStatus">OFF</label>
                                    </div>
                                    <div class="col-auto">
                                        <span id="titleHelpInline" class="form-text">
                                          {{ __('It must be checked for the adding offers to users.') }}
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-light">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="row gutters-sm">
                        <div class="col-sm-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                    <small>Web Design</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Website Markup</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>One Page</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Mobile Template</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Backend API</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                    <small>Web Design</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Website Markup</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>One Page</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Mobile Template</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Backend API</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>

@endsection
