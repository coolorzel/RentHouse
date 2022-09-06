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
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Security</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Notifications</a>
                                    </li>
                                </ul>
                                <h5 class="mb-0 mt-5">Security Settings</h5>
                                <p>These settings are helps you keep your account secure.</p>
                                <div class="list-group mb-5 shadow">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <strong class="mb-2">Enable Activity Logs</strong>
                                                <p class="text-muted mb-0">Donec id elit non mi porta gravida at eget metus.</p>
                                            </div>
                                            <div class="col-auto">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="activityLog" checked="">
                                                    <span class="custom-control-label"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <strong class="mb-2">2FA Authentication</strong>
                                                <span class="badge badge-pill badge-success">Enabled</span>
                                                <p class="text-muted mb-0">Maecenas sed diam eget risus varius blandit.</p>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-primary btn-sm">Disable</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <strong class="mb-2">Activate Pin Code</strong>
                                                <p class="text-muted mb-0">Donec id elit non mi porta gravida at eget metus.</p>
                                            </div>
                                            <div class="col-auto">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="pinCode">
                                                    <span class="custom-control-label"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-0">Recent Activity</h5>
                                <p>Last activities with your account.</p>
                                <table class="table border bg-white">
                                    <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Location</th>
                                        <th>IP</th>
                                        <th>Time</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="col"><i class="fe fe-globe fe-12 text-muted mr-2"></i>Chrome - Windows 10</th>
                                        <td>Paris, France</td>
                                        <td>192.168.1.10</td>
                                        <td>Apr 24, 2019</td>
                                        <td><a hreff="#" class="text-muted"><i class="fe fe-x"></i></a></td>
                                    </tr>
                                    <tr>
                                        <th scope="col"><i class="fe fe-smartphone fe-12 text-muted mr-2"></i>App - Mac OS</th>
                                        <td>Newyork, USA</td>
                                        <td>10.0.0.10</td>
                                        <td>Apr 24, 2019</td>
                                        <td><a hreff="#" class="text-muted"><i class="fe fe-x"></i></a></td>
                                    </tr>
                                    <tr>
                                        <th scope="col"><i class="fe fe-globe fe-12 text-muted mr-2"></i>Chrome - iOS</th>
                                        <td>London, UK</td>
                                        <td>255.255.255.0</td>
                                        <td>Apr 24, 2019</td>
                                        <td><a hreff="#" class="text-muted"><i class="fe fe-x"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
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
