@extends('layouts.app')

@section('title', __('My profile'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
            <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
            <button class="btn btn-outline-secondary active">{{ __('My account') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Edit your profile.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3 shadow p-3 mb-5 bg-body rounded">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div style="position:relative;display:inline-block;text-align:center;">
                                    <div class="user-img d-flex align-items-center">
                                        @if (Auth::check() && Auth::user()->avatar)
                                            <img src="{{ asset('assets/uploads/users/'.Auth::id().'/avatar/'.Auth::user()->avatar) }}" alt="avatar" class="rounded-circle" width="150" height="150">
                                        @else
                                            <img src="{{ asset('project/img/default_avatar.png') }}" alt="default_avatar" class="rounded-circle" width="150" height="150">
                                        @endif
                                    </div>
                                    @if (Auth::check() && Auth::user()->avatar)
                                    <button type="button" class="btn btn-danger btn-floating" style="position: absolute;top: 5px;left: 5px;" data-mdb-toggle="modal" data-mdb-target="#deleteAvatarModal">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                        <div class="modal fade" id="deleteAvatarModal" tabindex="-1" aria-labelledby="deleteAvatarModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="userAvatarDelete" method="post" action="{{ route('myAvatarDelete') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="delete" value="true">
                                                        <div class="modal-header">
                                                            {{ __('Delete your avatar.') }}
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to remove the avatar and set the default one?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-mdb-dismiss="modal">
                                                                {{ __('Cancle') }}</button>
                                                            <button type="submit" name="delete" value="true" class="btn btn-danger btn-ok">{{ __('Delete') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-info btn-floating" style="position: absolute; top: 5px; right: 5px;" data-mdb-toggle="modal" data-mdb-target="#changeAvatarModal">
                                        <i class="fa fa-magic"></i>
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="changeAvatarModal" tabindex="-1" aria-labelledby="changeAvatarModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changeAvatarModalLabel">{{ __('Change avatar') }}</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3 class="jumbotron">{{ __('Add a new avatar to your profile.') }}</h3>
                                                <form method="post" action="{{ route('myAvatarUpdate') }}" enctype="multipart/form-data">
                                                    <div class="dropzone" id="changeAvatarDropzone"></div>
                                                    @csrf
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                                                    {{ __('Close') }}</button>
                                                <button type="button" class="btn btn-primary" id="buttonChangeAvatar">
                                                    {{ __('Save changes') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h4>{{ Auth::user()->name }} {{ Auth::user()->lname }}</h4>
                                    <p class="text-secondary mb-1">{{ strtoupper(Auth::user()->roles->first()->name) }}</p>
                                    <p class="text-muted font-size-sm">{{ Auth::user()->province }} {{ Auth::user()->city }} {{ Auth::user()->street }} {{ Auth::user()->number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            @if(count($issetLink) == count($links))
                                <span class="text-warning mb-1 text-center">{{ __('No links available. Add a new one!') }}</span>
                            @endif
                            @foreach ($links as $key=>$val)
                                @if(Auth::user()->$key)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"> <i class="fa fa-@if($key == 'website')globe @else{{ $key }} @endif fa-2x text-warning" aria-hidden="true"></i>
                                        {{ __(ucfirst($key)) }}</h6>
                                    <span class="text-secondary"><a href="http://{{ Auth::user()->$key }}">{{ Auth::user()->$key }}</a></span>
                                    <button id="buttonEditLinks" type="button" class="btn-sm btn-info btn-floating" style="position: absolute;/* top: 2px; */right: -20px;" data-info="{{$key}}" data-mdb-toggle="modal" data-mdb-target="#exampleModalEdit">
                                        <i class="fa fa-magic"></i>
                                    </button>
                                </li>
                                @endif
                            @endforeach

                            <button type="button" class="btn btn-outline-info btn-rounded" style="position: absolute; top: -15px; left: -15px;" data-mdb-toggle="modal" data-mdb-target="#modalConfirmCreateLink">
                                {{ __('Add new link') }}</button>

                                <!-- Modal -->
                                <div class="modal top fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalEditLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
                                    <div class="modal-dialog modal-dialog-centered modal-warning">
                                        <div class="modal-content">
                                            <form action="#" method="post" id="exampleModalEditForm">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalEditLabel">{{ __('Reload this modal') }}</h5>
                                                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group flex-nowrap form-outline">
                                                        <span class="input-group-text" id="exampleModalEditSymbol">****</span>
                                                        <input name="valueLink" id="exampleModalEditValue" type="text" class="form-control" readonly aria-label="editLinks" aria-describedby="addon-wrapping" value="" disabled />
                                                        <label class="form-label" id="exampleModalEditComment" for="exampleModalEditValue">{{ __('Reload this modal') }}</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                                                        {{ __('Close') }}
                                                    </button>
                                                    <button type="button" id="buttonDelete" class="btn btn-danger" data-mdb-toggle="modal" data-mdb-target="#modalConfirmDeleteLink">
                                                        {{ __('Delete') }}</button>
                                                    <button type="submit" class="btn btn-primary" id="buttonSubmit" disabled>{{ __('Save changes') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!--Modal: modalConfirmDelete-->
                                <div class="modal fade" id="modalConfirmDeleteLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
                                        <!--Content-->
                                        <div class="modal-content text-center">
                                            <!--Header-->
                                            <div class="modal-header d-flex justify-content-center">
                                                <p class="heading">{{ __('Are you sure?') }}</p>
                                            </div>

                                            <!--Body-->
                                            <div class="modal-body">

                                                <i class="fa fa-times fa-4x animated rotateIn text-danger"></i>

                                            </div>

                                            <!--Footer-->
                                            <div class="modal-footer flex-center">
                                                <form action="#" method="post" id="exampleModalDeleteForm">
                                                <button type="submit" class="btn btn-outline-danger" id="buttonSubmitDelete" disabled>{{ __('Yes') }}</button>
                                                </form>
                                                <button type="button" id="buttonEditLinks" class="btn  btn-danger waves-effect noExampleDeleteLink" data-mdb-dismiss="modal">
                                                    {{ __('No') }}</button>
                                            </div>
                                        </div>
                                        <!--/.Content-->
                                    </div>
                                </div>
                                <!--Modal: modalConfirmDelete-->


                                <!--MODAL: modal create links -->
                                <div class="modal top fade" id="modalConfirmCreateLink" tabindex="-1" aria-labelledby="modalConfirmCreateLinkLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
                                    <div class="modal-dialog modal-dialog-centered modal-warning">
                                        <div class="modal-content">
                                            <form action="{{ route('myLinksCreate') }}" method="post" id="createLinkPost">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalEditLabel">{{ __('Create new link') }}</h5>
                                                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="type-link" class="col-form-label">{{ __('Select type link') }}:</label>
                                                        <select id="type-link" name="nameLink" class="form-select" aria-label="Default select example">
                                                            <option selected>{{ __('Open this select menu') }}</option>
                                                            @foreach ($issetLink as $l)
                                                                <option value="{{$l}}">{{$l}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="link-value" class="col-form-label">{{ __('Enter a your name or address') }}:</label>
                                                        <div class="input-group flex-nowrap form-outline">
                                                            <span class="input-group-text" id="symbolCreateLink">****</span>
                                                            <input name="valueLink" id="link-value" type="text" class="form-control" readonly aria-label="editLinks" aria-describedby="addon-wrapping" value="" disabled />
                                                            <label class="form-label" for="link-value" id="commentCreateLink">{{ __('**************') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                                                        {{ __('Close') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--MODAL: modal create links -->


                        </ul>
                    </div>
                </div>
                <div class="col-md-8 shadow p-3 mb-5 bg-body rounded">
                    <form method="post" enctype="multipart/form-data" action="{{ route('myProfileUpdate') }}" id="UserProfileInfoForm">
                        @csrf
                        @method('POST')
                    <div class="card mb-3" id="editData">


                        <span class="alert alert-warning text-danger error-text" style="display:none;" id="errors"><ul id="errors-list"></ul></span>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Name and last name') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group">
                                        <input type="text" readonly name="name" aria-label="First name" class="form-control-sm text-secondary form-control-plaintext" style="width: 50%;" value="{{ $user->name }}">
                                        <input type="text" readonly name="lname" aria-label="Last name" class="form-control-sm text-secondary form-control-plaintext" style="width: 50%;" value="{{ $user->lname }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Email') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="email" readonly class="form-control-plaintext form-control-sm text-secondary" id="editData email" name="email" value="{{ $user->email }}" placeholder="login@domain.com" disabled>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Username') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm text-secondary" id="editData username" name="username" value="{{ $user->username }}" placeholder="{{ __('Nickname') }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Phone') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="tel" readonly class="form-control-plaintext form-control-sm text-secondary phone" id="editData phone_number" name="phone_number" value="{{ $user->phone_number }}" placeholder="583 - 932 - 930">
                                    <span class="text-danger error-text phone_number_error"></span>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Address') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-2">
                                        <input name="country" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistCountryOptions" id="exampleDataList editData" placeholder="{{ __('Country') }}" style="width:50%" value="{{ $user->country }}" disabled>
                                        <input name="province" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistProvinceOptions" id="exampleDataList editData" placeholder="{{ __('Province') }}" value="{{ $user->province }}" style="width:50%">
                                    </div>
                                    <div class="input-group">
                                        <input name="zipcode" readonly class="form-control-plaintext form-control-sm text-secondary zipcode" list="datalistZipcodeOptions" id="exampleDataList editData zipcode" placeholder="{{ __('Zip-Code') }}" value="{{ $user->zipcode }}" style="width:20%">
                                        <input name="city" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistCityOptions" id="exampleDataList editData" placeholder="{{ __('City') }}" value="{{ $user->city }}" style="width:30%">
                                        <input name="street" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistStreetOptions" id="exampleDataList editData" placeholder="{{ __('Street') }}" value="{{ $user->street }}" style="width:30%">
                                        <input name="number" readonly class="form-control-plaintext form-control-sm text-secondary number" list="datalistNumberOptions" id="exampleDataList editData" placeholder="{{ __('Number') }}" value="{{ $user->number }}" style="width:20%">
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-info" id="editButtonSelect" target="__blank" href="#" onclick="editButtonData()" type="button">
                                        {{ __('Edit') }}</button>
                                    <button class="btn btn-warning" id="changePasswordButtonSelect" target="__blank" type="button" data-mdb-toggle="modal" data-mdb-target="#modalChangePasswordPost">
                                        {{ __('Change Password') }}</button>
                                    <button class="btn btn-primary" id="cancelButtonSelect" target="__blank" href="#" onclick="cancelButtonData()" style="display:none;" type="button">
                                        {{ __('Cancel') }}</button>
                                    <button class="btn btn-success" id="saveButtonSelect" target="__blank" href="#" style="display:none;" type="submit">
                                        {{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                    <!--MODAL: modal create links -->
                    <div class="modal top fade" id="modalChangePasswordPost" tabindex="-1" aria-labelledby="modalChangePasswordPostLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
                        <div class="modal-dialog modal-dialog-centered modal-warning">
                            <div class="modal-content">
                                <form action="{{ route('myPasswordUpdate') }}" method="post" id="myPasswordUpdatePost">
                                    @csrf
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title">{{ __('Change password') }}</h5>
                                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="link-value" class="col-form-label">{{ __('Enter a your password.') }}:</label>
                                            <div class="input-group flex-nowrap form-outline">
                                                <span class="input-group-text" id="symbolCreateLink">OLD</span>
                                                <input name="oldPassword" id="link-value" type="password" class="form-control" aria-label="editLinks" aria-describedby="addon-wrapping"/>
                                                <label class="form-label" for="link-value" id="commentCreateLink">{{ __('Enter a your old password') }}</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1">
                                                <label for="link-value" class="col-form-label">{{ __('Enter a your new password.') }}:</label>
                                                <div class="input-group flex-nowrap form-outline">
                                                    <span class="input-group-text" id="symbolCreateLink" style="min-width:65px;">NEW</span>
                                                    <input name="newPassword" id="link-value" type="password" class="form-control" aria-label="editLinks" aria-describedby="addon-wrapping"/>
                                                    <label class="form-label" for="link-value" id="commentCreateLink">{{ __('Enter a your new password') }}</label>
                                                </div>
                                            </div>
                                            <div class="mb-1">
                                                <div class="input-group flex-nowrap form-outline">
                                                    <span class="input-group-text" id="symbolCreateLink" style="min-width:65px;">REP</span>
                                                    <input name="repPassword" id="link-value" type="password" class="form-control" aria-label="editLinks" aria-describedby="addon-wrapping"/>
                                                    <label class="form-label" for="link-value" id="commentCreateLink">{{ __('Repeat new password') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                                            {{ __('Cancel') }}
                                        </button>
                                        <button type="submit" class="btn btn-warning">{{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--MODAL: modal create links -->

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card-header"><h4>{{ __('Billing accounts') }}</h4></div>
                            @if(count($billings) > 0)
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                @foreach($billings as $billing)
                                    @if($billing->destroy == false)
                                        <div class="accordion-item" id="id" data-id="{{ $billing->id }}">
                                            <h2 class="accordion-header" id="flush-heading{{ $billing->id }}">
                                                <button class="accordion-button collapsed position-relative" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $billing->id }}" aria-expanded="false" aria-controls="flush-collapse{{ $billing->id }}">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-sm-1 text-center align-self-center">
                                                                @if($billing->company == true)
                                                                    <i class="fa fa-building-o"></i>
                                                                @else
                                                                    <i class="fa fa-user-secret"></i>
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-3 col align-self-center">
                                                                <div class="row">
                                                                    @if(isset($billing->company_name))
                                                                        <strong class="text-warning">{{ __('Company name: ') }}</strong> {{ $billing->company_name }}
                                                                    @endif
                                                                    <div class="col-12 col-sm-12">
                                                                        <strong>{{ __('First name: ') }}</strong> {{ $billing->name }}
                                                                    </div>
                                                                    <div class="col-12 col-sm-12">
                                                                        <strong>{{ __('Last name: ') }}</strong> {{ $billing->lname }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="row">
                                                                    <div class="col-8 col-sm-6">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-12 text-center">
                                                                                <strong>{{ __('Address:') }}</strong>
                                                                            </div>
                                                                            <div class="col-12 col-sm-12">
                                                                                <strong>{{ __('Country:') }}</strong> {{ $billing->country }}
                                                                            </div>
                                                                            <div class="col-12 col-sm-12">
                                                                                <strong>{{ __('Province:') }}</strong> {{ $billing->province }}
                                                                            </div>
                                                                            <div class="col-12 col-sm-12">
                                                                                <strong>{{ __('City:') }}</strong> {{ $billing->city }}
                                                                            </div>
                                                                            <div class="col-12 col-sm-12">
                                                                                <strong>{{ __('Post Code:') }}</strong> {{ $billing->zipcode }}
                                                                            </div>
                                                                            <div class="col-12 col-sm-12">
                                                                                <strong>{{ __('Street:') }}</strong> {{ $billing->street }} {{ $billing->building_number }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4 col-sm-6 align-self-center">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-12 text-center">
                                                                                <strong>{{ __('Status:') }}</strong>
                                                                            </div>
                                                                            <div class="col-12 col-sm-12 text-center">
                                                                                @if($billing->rejected == 0)
                                                                                    @if($billing->verified == 1)
                                                                                        <i class="fa fa-check-circle-o fa-2x text-success"></i>
                                                                                    @else
                                                                                        <i class="fa fa-spinner fa-2x text-warning"></i>
                                                                                    @endif
                                                                                @else
                                                                                    <i class="fa fa-times-circle-o fa-2x text-danger"></i>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($billing->rejected == false)
                                                        @if($billing->verified == false)
                                                            @if(!$billing->message->sender == Auth::id())
                                                                @if($billing->message->displayed == false)
                                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                                                        {{ __('New message!') }}
                                                                        <span class="visually-hidden">{{ __('New message!') }}</span>
                                                                    </span>
                                                                @else
                                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info" id="statusMessage">
                                                                        {{ __('Do not have new answer') }}
                                                                        <span class="visually-hidden">{{ __('You dont have new answer') }}</span>
                                                                    </span>
                                                                @endif
                                                            @else
                                                                @if($billing->message->displayed == false)
                                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                            {{ __('Your application has not been read!') }}
                                                                            <span class="visually-hidden">{{ __('Your application has not been read!') }}</span>
                                                                        </span>
                                                                @else
                                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info" id="statusMessage">
                                                                        {{ __('Your application is being verified') }}
                                                                        <span class="visually-hidden">{{ __('Your application is being verified') }}</span>
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="statusMessage">
                                                            {{ __('Your application has been rejected. Open and learn more...') }}
                                                            <span class="visually-hidden">{{ __('Your application has been rejected. Open and learn more...') }}</span>
                                                        </span>
                                                    @endif
                                                </button>
                                            </h2>
                                            <div id="flush-collapse{{ $billing->id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $billing->id }}" data-bs-parent="#accordionFlushExample">
                                                @if($billing->verified == true) <!-- Jeżeli konto rozliczeniowe potwierdzone -->
                                                    <div class="accordion-body">
                                                        @if(!empty($billing->offers->toArray()))
                                                            <table class="table caption-top table-responsive">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">{{ __('Picture') }}</th>
                                                                    <th scope="col">{{ __('Title') }}</th>
                                                                    <th scope="col">{{ __('Category') }}</th>
                                                                    <th scope="col">{{ __('Status') }}</th>
                                                                    <th scope="col">{{ __('Options') }}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($billing->offers as $key => $val)
                                                                    @if($val->isCreated == false && $val->archivum == false)
                                                                        <tr>
                                                                            <th scope="row">{{ $val->id }}</th>
                                                                            <td>
                                                                                <img width="80px" height="auto" class="rounded" src="{{asset('images/'.$val->id.'/'.$val->cat_id.'/'.\App\Models\OfferImages::where('id', $val->images_id)->pluck('name')->first())}}" alt="image description"></td>
                                                                            </td>
                                                                            <td>{{ $val->name }}</td>
                                                                            <td>{{ $val->cat_id }}</td>
                                                                            <td>
                                                                                @if($val->isReject == 0)
                                                                                    @if($billing->isAcceptMod == 1)
                                                                                        <i class="fa fa-check-circle-o fa-2x text-success"></i>
                                                                                    @else
                                                                                        <i class="fa fa-spinner fa-2x text-warning"></i>
                                                                                    @endif
                                                                                @else
                                                                                    <i class="fa fa-times-circle-o fa-2x text-danger"></i>
                                                                                @endif
                                                                            </td>
                                                                            <td><div class="">
                                                                                    <ul class="list-inline justify-content-center">
                                                                                        <li class="list-inline-item">
                                                                                            <a data-toggle="tooltip" data-placement="top" title="View" class="view" href="{{ route('offerShow', [$val->category->slug, $val->id, $val->slug]) }}">
                                                                                                <i class="fa fa-eye text-warning fa-2x"></i>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a data-toggle="tooltip" data-placement="top" title="Edit" class="edit" href="{{ route('offerEdit', [$val->category->slug, $val->id, $val->slug]) }}">
                                                                                                <i class="fa fa-pencil text-warning fa-2x"></i>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                        <span data-toggle="modal" data-target="#deleteoffer{{ $val->id }}">
                                                                                        <a data-toggle="tooltip" class="delete" data-placement="top" title="Delete" data-mdb-toggle="modal" data-mdb-target="#modalDelete-{{ $val->id }}"><i class="fa fa-trash text-warning fa-2x"></i></a>
                                                                                        </span>
                                                                                        </li>
                                                                                        <!--Modal: modalConfirmDelete-->
                                                                                        <div class="modal fade" id="modalDelete-{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDelete-{{ $val->id }}-Label"
                                                                                             aria-hidden="true">
                                                                                            <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
                                                                                                <!--Content-->
                                                                                                <div class="modal-content text-center">
                                                                                                    <!--Header-->
                                                                                                    <div class="modal-header d-flex justify-content-center">
                                                                                                        <p class="heading">{{ __('Are you sure?') }}</p>
                                                                                                    </div>

                                                                                                    <!--Body-->
                                                                                                    <div class="modal-body">

                                                                                                        <i id="deleteRestoreIcon" class="fa fa-times fa-4x animated rotateIn text-danger"></i>

                                                                                                    </div>

                                                                                                    <!--Footer-->
                                                                                                    <div class="modal-footer flex-center">
                                                                                                        <form action="{{ route('offerDestroy', [$val->category->slug, $val->id, $val->slug]) }}" method="delete" id="formDelete">
                                                                                                            <input type="hidden" name="btn" value="destroy">
                                                                                                            <button type="submit" class="btn btn-outline-danger" id="buttonSubmitDelete">{{ __('Yes') }}</button>
                                                                                                        </form>
                                                                                                        <button type="button" class="btn btn-danger waves-effect" data-mdb-dismiss="modal">
                                                                                                            {{ __('No') }}</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <!--/.Content-->
                                                                                            </div>
                                                                                        </div>
                                                                                        <!--Modal: modalConfirmDelete-->

                                                                                    </ul>
                                                                                </div></td>
                                                                            </tr>
                                                                    @endif
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <div class="card-body">{{ __('No offers ... Add a new one to be displayed here.') }}</div>
                                                        @endif

                                                        <a href="{{ route('postNewAd') }}" class="btn btn-info" target="__blank" href="#" type="button">
                                                            {{ __('Create new offer') }}</a>
                                                    </div>
                                                @else <!-- Jeżeli konto rozliczeniowe nie zostało potwierdzone -->
                                                    @if ($billing->rejected == true) <!-- Jeżeli konto zostało odrzucone -->
                                                            <div class="accordion-body">
                                                                {{ __('The account is rejected.') }}
                                                                <div class="container mt-4">
                                                                    <div class="card mx-auto" style="max-width:400px">
                                                                        <div class="card-header bg-transparent">
                                                                            <div class="navbar navbar-expand p-0">
                                                                                <ul class="navbar-nav me-auto align-items-center">
                                                                                    <li class="nav-item">
                                                                                        <span class="nav-link" id="userName">{{ __('Administration') }}</span>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div id="messagess" data-messages="{{ $billing->id }}" class="card-body p-4" style="height: 500px; overflow: auto;">
                                                                            @foreach($billing->messages as $message)
                                                                                @if(!$message->sender == Auth::id())
                                                                                    <div class="d-flex align-items-baseline mb-4">
                                                                                        <div class="position-relative avatar">
                                                                                            <img src="{{ asset('project/img/admin_avatar.png') }}"
                                                                                                 class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                                                        </div>
                                                                                        <div class="pe-2">
                                                                                            <div>
                                                                                                <div class="card card-text d-inline-block p-2 px-3 m-1">{{ $message->message }}
                                                                                                </div>
                                                                                            </div>
                                                                                            <div>
                                                                                                <div class="small">{{ $message->created_at }}</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                                                                                        <div class="pe-2">
                                                                                            <div>
                                                                                                <div class="card card-text d-inline-block p-2 px-3 m-1">{{ $message->message }}</div>
                                                                                            </div>
                                                                                            <div>
                                                                                                <div class="small">{{ $message->created_at }}</div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="position-relative avatar">
                                                                                            <img src="{{ asset('assets/uploads/users/'.Auth::id().'/avatar/'.Auth::user()->avatar) }}"
                                                                                                 class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        <form action="{{ route('userSendResponseBillingAccount') }}" method="post" id="sendMessage" data-info="{{ $message->billing_id }}">
                                                                            <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                                                                                <div class="input-group">
                                                                                    <input type="text" name="message" class="form-control border-0" required placeholder="{{ __('Write a message...') }}">
                                                                                    <div class="input-group-text bg-transparent border-0">
                                                                                        <button type="submit" class="btn btn-outline-warning" id="submitMessage">
                                                                                            <i class="fa fa-send-o"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="accordion-body">
                                                                {{ __('The account is awaiting activation.') }}
                                                                <div class="container mt-4">
                                                                    <div class="card mx-auto" style="max-width:400px">
                                                                        <div class="card-header bg-transparent">
                                                                            <div class="navbar navbar-expand p-0">
                                                                                <ul class="navbar-nav me-auto align-items-center">
                                                                                    <li class="nav-item">
                                                                                        <span class="nav-link" id="userName">{{ __('Administration') }}</span>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div id="messagess" data-messages="{{ $billing->id }}" class="card-body p-4" style="height: 500px; overflow: auto;">
                                                                            @foreach($billing->messages as $message)
                                                                                @if(!$message->sender == Auth::id())
                                                                                    <div class="d-flex align-items-baseline mb-4">
                                                                                        <div class="position-relative avatar">
                                                                                            <img src="{{ asset('project/img/admin_avatar.png') }}"
                                                                                                 class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                                                        </div>
                                                                                        <div class="pe-2">
                                                                                            <div>
                                                                                                <div class="card card-text d-inline-block p-2 px-3 m-1">{{ $message->message }}
                                                                                                </div>
                                                                                            </div>
                                                                                            <div>
                                                                                                <div class="small">{{ $message->created_at }}</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                                                                                        <div class="pe-2">
                                                                                            <div>
                                                                                                <div class="card card-text d-inline-block p-2 px-3 m-1">{{ $message->message }}</div>
                                                                                            </div>
                                                                                            <div>
                                                                                                <div class="small">{{ $message->created_at }}</div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="position-relative avatar">
                                                                                            @if(Auth::check() && Auth::user()->avatar)
                                                                                                <img src="{{ asset('assets/uploads/users/'.Auth::id().'/avatar/'.Auth::user()->avatar) }}"
                                                                                                 class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                                                            @else
                                                                                                <img src="{{ asset('project/img/default_avatar.png') }}"
                                                                                                     class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        <form action="{{ route('userSendResponseBillingAccount') }}" method="post" id="sendMessage" data-info="{{ $message->billing_id }}">
                                                                            <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                                                                                <div class="input-group">
                                                                                    <input type="text" name="message" class="form-control border-0" required placeholder="{{ __('Write a message...') }}">
                                                                                    <div class="input-group-text bg-transparent border-0">
                                                                                        <button type="submit" class="btn btn-outline-warning" id="submitMessage">
                                                                                            <i class="fa fa-send-o"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @else
                                <div class="callout">{{ __('You do not have billing account...') }}</div>
                            @endif
                            <a href="{{ route('myBillingVerificationForm') }}" class="btn btn-outline-default" type="button">
                                {{ __('Create new billing account') }}
                            </a>
                        </div>
                    </div>

                <!--    <div class="card chart-container">
                        <canvas id="chart"></canvas>
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
                    </div>-->



                </div>
            </div>

@endsection

@section('scripts')
    <script>

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $('div #formDelete').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                method:'DELETE',
                data:new FormData(this),
                processData: false,
                //dataType:'json',
                contentType:false,
                success:
                    function(data) {
                        Swal.fire({
                            title: data.title,
                            text: data.msg,
                            type: data.type
                        }).then(function(){
                            location.reload();
                        });
                    }
            });
        });

        $(document).ready(function (){
            $('div #sendMessage').on('submit', function(e){
                const thisForm = $(this);
                var input = $(this).find('input[name="message"]');
                const messanger = $('div').find('[data-messages="'+ $(this).data('info') +'"]');
                e.preventDefault();
                $.ajax({
                    url:$(this).attr('action'),
                    method:$(this).attr('method'),
                    data: {data:$(this).data('info'), message:input.val()},
                    success:
                        function(data) {
                            if(data.status === 0){
                                Toastify({
                                    text: data.msg, // "This is a toast",
                                    duration: 3000,
                                    //destination: "https://github.com/apvarun/toastify-js",
                                    newWindow: true,
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "linear-gradient(to right, #aac900, #ff0000)",
                                    },
                                    onClick: function(){} // Callback after click
                                }).showToast();
                            }else{
                                thisForm[0].reset();
                                messanger[0].scrollIntoView();
                                var create_at = new Date(data.create);
                                messanger.append("<div class=\"d-flex align-items-baseline text-end justify-content-end mb-4\">" +
                                    "<div class=\"pe-2\">" +
                                    "<div>" +
                                    "<div class=\"card card-text d-inline-block p-2 px-3 m-1\">" + data.message +
                                    "</div>" +
                                    "</div>" +
                                    "<div>" +
                                    "<div class=\"small\">" + create_at.getFullYear() +
                                    "-" +
                                    create_at.getMonth() + "-" + create_at.getDay() + "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "<div class=\"position-relative avatar\">" +
                                    "<img id=\"avatar_message\" src=\"" + data.user_avatar + "\"" +
                                    "class=\"img-fluid rounded-circle\" alt=\"\" style=\"height: 40px;width:40px;\">" +
                                    "</div>" +
                                    "</div>");
                            }
                        }
                });
            });
        });
        /* $(window).bind("load", function() {
             //let url = '{{ route('checkStatusMessage',1) }}';
            let test = $("#accordionFlushExample #id").data('id');
            console.log(test);
            $.ajax({
                url:url,
                method:'POST',
                data: {data:this.value},
                success:
                    function (data) {
                        if (data.Status == 1)
                        {
                            $('#commentCreateLink').text(data.Comment);
                            $('#symbolCreateLink').text(data.Symbol);
                            const element = document.getElementById('link-value');
                            element.readOnly = false;
                            element.disabled = false;
                        }
                        else
                        {
                            $('#symbolCreateLink').text('****');
                            $('#commentCreateLink').text('**************');
                            const element = document.getElementById('link-value');
                            element.readOnly = true;
                            element.disabled = true;
                        }
                    }
            });
        });*/

        $(function (){
            $('#myPasswordUpdatePost').on('submit', function(e){
               e.preventDefault();

               $.ajax({
                   url:$(this).attr('action'),
                   method:$(this).attr('method'),
                   data:new FormData(this),
                   processData: false,
                   dataType:'json',
                   contentType:false,
                   success:
                       function(data) {
                       if (data.status === 0) {
                           $.each(data.error, function (prefix, val) {
                               Toastify({
                                   text: val[0], // "This is a toast",
                                   duration: 3000,
                                   //destination: "https://github.com/apvarun/toastify-js",
                                   newWindow: true,
                                   close: true,
                                   gravity: "top", // `top` or `bottom`
                                   position: "right", // `left`, `center` or `right`
                                   stopOnFocus: true, // Prevents dismissing of toast on hover
                                   style: {
                                       background: "linear-gradient(to right, #aac900, #ff0000)",
                                   },
                                   onClick: function(){} // Callback after click
                               }).showToast();
                           });
                           } else {
                               Swal.fire({
                                   title: data.title,
                                   text: data.msg,
                                   type: data.type
                               }).then(function(){
                                   location.reload();
                               });
                           }
                       }
               });
            });
        });

        $(function (){
            $('#createLinkPost').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url:$(this).attr('action'),
                    method:$(this).attr('method'),
                    data:new FormData(this),
                    processData: false,
                    dataType:'json',
                    contentType:false,
                    success:
                        function(data) {
                            if (data.status == 0) {
                                $('#errors').show();

                                $.each(data.error, function (prefix, val) {
                                    $('#errors-list').append("<li>" + val[0] + "</li>");
                                });
                            } else {

                                $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.reload();
                                });
                            }
                        }
                });
            });
        });

        $('#type-link').on('change', function() {
            let url = '{{ route('myLinksInfo') }}';
            $.ajax({
                url:url,
                method:'POST',
                data: {data:this.value},
                success:
                    function (data) {
                        if (data.Status == 1)
                        {
                            $('#commentCreateLink').text(data.Comment);
                            $('#symbolCreateLink').text(data.Symbol);
                            const element = document.getElementById('link-value');
                            element.readOnly = false;
                            element.disabled = false;
                        }
                        else
                        {
                            $('#symbolCreateLink').text('****');
                            $('#commentCreateLink').text('**************');
                            const element = document.getElementById('link-value');
                            element.readOnly = true;
                            element.disabled = true;
                        }
                    }
            });
        });

        $(function (){
            $(document).ready(function() {
                //$('#buttonEditLinks').click(function(){
                $('#exampleModalEdit').on('show.bs.modal', function(e) {
                    let url = '{{ route('myLinksEdit').'/' }}';
                    let btn = $(e.relatedTarget);
                    $.ajax({
                        url:url + btn.data('info'),
                        method:'GET',
                        processData: false,
                        dataType:'json',
                        success:
                        function (data) {
                            $('#exampleModalEditLabel').text(data.Name);
                            $('#exampleModalEditSymbol').text(data.Symbol);
                            $('#exampleModalEditComment').text(data.Comment);
                            $('#exampleModalEditValue').val(data.Value);
                            $('#exampleModalEditForm').attr('action', data.Link);
                            $('#exampleModalDeleteForm').attr('action', data.Delete);
                            $('.noExampleDeleteLink').attr('data-info', data.Data);
                            const element = document.getElementById('exampleModalEditValue');
                            element.readOnly = false;
                            element.disabled = false;
                            const e = document.getElementById('buttonSubmit');
                            e.disabled = false;
                            const e2 = document.getElementById('buttonSubmitDelete');
                            e2.disabled = false;
                        }
                    });
                });
            });
        });

        $(function (){
            $('#exampleModalDeleteForm').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url:$(this).attr('action'),
                    method:'DELETE',
                    data:new FormData(this),
                    processData: false,
                    dataType:'json',
                    contentType:false,
                    success:
                        function(data) {
                            if (data.status == 0) {
                                $('#errors').show();

                                $.each(data.error, function (prefix, val) {
                                    $('#errors-list').append("<li>" + val[0] + "</li>");
                                });
                            } else {

                                $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.reload();
                                });
                            }
                        }
                });
            });
        });

        $(function (){
            $('#exampleModalEditForm').on('submit', function(e){
               e.preventDefault();
               $.ajax({
                   url:$(this).attr('action'),
                   method:$(this).attr('method'),
                   data:new FormData(this),
                   processData: false,
                   dataType:'json',
                   contentType:false,
                   success:
                       function(data) {
                           if (data.status == 0) {
                               $('#errors').show();

                               $.each(data.error, function (prefix, val) {
                                   $('#errors-list').append("<li>" + val[0] + "</li>");
                               });
                           } else {

                               $('#errors').hide();
                               Swal.fire({
                                   title: data.title,
                                   text: data.msg,
                                   type: data.type
                               }).then(function(){
                                   location.reload();
                               });
                           }
                       }
               });
           });
        });

        $(function (){

            $('#userAvatarDelete').on('submit', function(e){
                e.preventDefault();

                $.ajax({
                    url:$(this).attr('action'),
                    method:$(this).attr('method'),
                    data:new FormData(this),
                    processData: false,
                    dataType:'json',
                    contentType:false,
                    success:
                        function(data) {
                            if (data.status == 0) {
                                $('#errors').show();

                                $.each(data.error, function (prefix, val) {
                                    $('#errors-list').append("<li>" + val[0] + "</li>");
                                });
                            } else {

                                $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.reload();
                                });
                            }
                        }
                });
            });

        });

        $(function (){

            $('#UserProfileInfoForm').on('submit', function(e){
                e.preventDefault();

                $.ajax({
                   url:$(this).attr('action'),
                   method:$(this).attr('method'),
                   data:new FormData(this),
                   processData: false,
                   dataType:'json',
                   contentType:false,
                   beforeSend:function (){
                       $('#errors-list').text('');
                   },
                    success:
                        function(data){
                        if(data.status == 0) {
                           $('#errors').show();

                           $.each(data.error, function (prefix, val) {
                               $('#errors-list').append("<li>" + val[0] + "</li>");
                           });
                       }else{

                            $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.reload();
                                });
                           //alert(data.msg);
                           if(data.status == 1){
                               formEdit.forEach((index) => {
                                   const element = document.getElementsByName(index.name)[0];
                                   element.readOnly = true;
                                   element.classList.remove('form-control');
                                   element.classList.add('form-control-plaintext');
                                   element.classList.remove('text-black');
                                   element.classList.add('text-secondary');
                               });
                               document.getElementById('editButtonSelect').style.display = '';
                               document.getElementById('cancelButtonSelect').style.display = 'none';
                               document.getElementById('saveButtonSelect').style.display = 'none';
                               document.getElementById('changePasswordButtonSelect').style.display = '';
                               formEdit = [];
                           }
                       }
                    }
                });
            });
        });
    </script>
    <script>

        Dropzone.options.changeAvatarDropzone = {
            url: '{{ route('myAvatarUpdate') }}',
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilesize: 256,
            resizeWidth: 150,
            resizeHeight: 150,
            resizeMethod: "crop",
            maxFiles: 1,
            acceptedFiles: '.png,.jpg,.jpeg',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            name: 'avatarFile',
            init: function () {

                var myDropzone = this;

                // Update selector to match your button
                $("#buttonChangeAvatar").click(function (e) {
                    e.preventDefault();
                    myDropzone.processQueue();
                });

                this.on('sending', function(file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    var data = $('#changeAvatarDropzone').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                });
            },
            success:
                function(file, response){
                    if(response.status == 1) {

                        Swal.fire({
                            title: response.title,
                            text: response.msg,
                            type: response.type
                        }).then(function(){
                                location.reload();
                            });
                    }
                }
        }
    </script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>


    <script>
        const ctx = document.getElementById("chart").getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["sunday", "monday", "tuesday",
                    "wednesday", "thursday", "friday", "saturday"],
                datasets: [{
                    label: 'Last week',
                    backgroundColor: 'rgba(161, 198, 247, 1)',
                    borderColor: 'rgb(47, 128, 237)',
                    data: [3000, 4000, 2000, 5000, 8000, 9000, 2000],
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            },
        });
    </script>
@endsection
