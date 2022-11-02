@extends('layouts.app')

@section('title', __('My profile'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary active">{{ __('User account') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Edit user profile:') }} {{$user->email}}</span>
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
                                @if (Auth::check() && $user->avatar)
                                    <img src="{{ asset('assets/uploads/users/'.$user->id.'/avatar/'.$user->avatar) }}" alt="avatar" class="rounded-circle" width="150" height="150">
                                @else
                                    <img src="{{ asset('project/img/default_avatar.png') }}" alt="default_avatar" class="rounded-circle" width="150" height="150">
                                @endif
                            </div>
                            @if (Auth::check() && $user->avatar)
                                @can('ACP-delete-user-avatar')
                                <button type="button" class="btn btn-danger btn-floating" style="position: absolute;top: 5px;left: 5px;" data-mdb-toggle="modal" data-mdb-target="#deleteAvatarModal">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <div class="modal fade" id="deleteAvatarModal" tabindex="-1" aria-labelledby="deleteAvatarModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="userAvatarDelete" method="post" action="{{ route('deleteUserAvatar',$user->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="delete" value="true">
                                                <div class="modal-header">
                                                    {{ __('Delete user avatar.') }}
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
                                @endcan
                            @endif
                            @can('ACP-update-user-avatar')
                            <button type="button" class="btn btn-info btn-floating" style="position: absolute; top: 5px; right: 5px;" data-mdb-toggle="modal" data-mdb-target="#changeAvatarModal">
                                <i class="fa fa-magic"></i>
                            </button>
                            @endcan
                        </div>
                        @can('ACP-update-user-avatar')
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
                        @endcan
                        <div class="mt-3">
                            <h4>{{ $user->name }} {{ $user->lname }}</h4>
                            <p class="text-secondary mb-1">{{ strtoupper($user->roles->first()->name) }}</p>
                            <p class="text-muted font-size-sm">{{ $user->province }} {{ $user->city }} {{ $user->street }} {{ $user->number }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <ul class="list-group list-group-flush">
                    @if(count($issetLink) == count($links) )
                        <span class="text-warning mb-1 text-center">{{ __('No links available. Add a new one!') }}</span>
                    @endif
                    @foreach ($links as $key=>$val)
                        @if($user->$key)
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"> <i class="fa fa-@if($key == 'website')globe @else{{ $key }} @endif fa-2x text-warning" aria-hidden="true"></i>
                                    {{ __(ucfirst($key)) }}</h6>
                                <span class="text-secondary"><a href="http://{{ $user->$key }}">{{ $user->$key }}</a></span>
                                @can('ACP-user-link-edit')
                                    <button id="buttonEditLinks" type="button" class="btn-sm btn-info btn-floating" style="position: absolute;/* top: 2px; */right: -20px;" data-info="{{$key}}" data-mdb-toggle="modal" data-mdb-target="#exampleModalEdit">
                                        <i class="fa fa-magic"></i>
                                    </button>
                                @endcan
                            </li>
                        @endif
                    @endforeach

                    @can('ACP-user-add-new-link')
                    <button type="button" class="btn btn-outline-info btn-rounded" style="position: absolute; top: -15px; left: -15px;" data-mdb-toggle="modal" data-mdb-target="#modalConfirmCreateLink">
                        {{ __('Add new link') }}
                    </button>

                            <!--MODAL: modal create links -->
                            <div class="modal top fade" id="modalConfirmCreateLink" tabindex="-1" aria-labelledby="modalConfirmCreateLinkLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
                                <div class="modal-dialog modal-dialog-centered modal-warning">
                                    <div class="modal-content">
                                        <form action="{{ route('userLinkCreate',$user->id) }}" method="post" id="createLinkPost">
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
                    @endcan

                        @can('ACP-user-link-edit')
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
                        @endcan
                        @can('ACP-user-link-delete')
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
                        @endcan
                </ul>
            </div>
        </div>
        <div class="col-md-8 shadow p-3 mb-5 bg-body rounded">

                <div class="card mb-3" id="editData">


                    <span class="alert alert-warning text-danger error-text" style="display:none;" id="errors"><ul id="errors-list"></ul></span>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="{{ route('updateUserProfile',$user->id) }}" id="nameandlastname">
                            @csrf
                            @method('POST')
                        <div class="row">
                            <div class="col-sm-3 d-flex align-items-center">
                                <h6 class="mb-0">{{ __('Name and last name') }}</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <div class="input-group">
                                    <input type="text" readonly name="name" aria-label="First name" class="form-control-sm text-secondary form-control-plaintext" style="width: 50%;" value="{{ $user->name }}">
                                    <input type="text" readonly name="lname" aria-label="Last name" class="form-control-sm text-secondary form-control-plaintext" style="width: 50%;" value="{{ $user->lname }}">
                                </div>
                                @can('ACP-user-edit-name-lname')
                                <button id="buttonEditProfile" data-info="nameandlastname" data-set="0" type="button" class="btn btn-info btn-rounded" style="position: absolute;right: -6%;">
                                    {{ __('Edit') }}
                                </button>
                                    @endcan
                            </div>
                        </div>
                        </form>
                        <hr>
                        <form method="post" enctype="multipart/form-data" action="{{ route('updateUserProfile',$user->id) }}" id="email">
                            @csrf
                            @method('POST')
                        <div class="row">
                            <div class="col-sm-3 d-flex align-items-center">
                                <h6 class="mb-0">{{ __('Email') }}</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="email" readonly class="form-control-plaintext form-control-sm text-secondary" id="editData email" name="email" value="{{ $user->email }}" placeholder="login@domain.com" disabled>
                                @can('ACP-user-edit-email')
                                <button id="buttonEditProfile" data-info="email" data-set="0" type="button" class="btn btn-info btn-rounded" style="position: absolute;right: -6%;">
                                    {{ __('Edit') }}
                                </button>
                                @endcan
                            </div>
                        </div>
                        </form>
                        <hr>
                        <form method="post" enctype="multipart/form-data" action="{{ route('updateUserProfile',$user->id) }}" id="username">
                            @csrf
                            @method('POST')
                        <div class="row">
                            <div class="col-sm-3 d-flex align-items-center">
                                <h6 class="mb-0">{{ __('Username') }}</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" readonly class="form-control-plaintext form-control-sm text-secondary" id="editData username" name="username" value="{{ $user->username }}" placeholder="{{ __('Nickname') }}">
                                @can('ACP-user-edit-username')
                                <button id="buttonEditProfile" data-info="username" data-set="0" type="button" class="btn btn-info btn-rounded" style="position: absolute;right: -6%;">
                                    {{ __('Edit') }}
                                </button>
                                @endcan
                            </div>
                        </div>
                        </form>
                        <hr>
                        <form method="post" enctype="multipart/form-data" action="{{ route('updateUserProfile',$user->id) }}" id="phone">
                            @csrf
                            @method('POST')
                        <div class="row">
                            <div class="col-sm-3 d-flex align-items-center">
                                <h6 class="mb-0">{{ __('Phone') }}</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="tel" readonly class="form-control-plaintext form-control-sm text-secondary phone" id="editData phone_number" name="phone_number" value="{{ $user->phone_number }}" placeholder="583 - 932 - 930">
                                <span class="text-danger error-text phone_number_error"></span>
                                @can('ACP-user-edit-phone')
                                <button id="buttonEditProfile" data-info="phone" data-set="0" type="button" class="btn btn-info btn-rounded" style="position: absolute;right: -6%;">
                                    {{ __('Edit') }}
                                </button>
                                @endcan
                            </div>
                        </div>
                        </form>
                        <hr>
                        <form method="post" enctype="multipart/form-data" action="{{ route('updateUserProfile',$user->id) }}" id="address">
                            @csrf
                            @method('POST')
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
                                @can('ACP-user-edit-address')
                                <button id="buttonEditProfile" data-info="address" data-set="0" type="button" class="btn btn-info btn-rounded" style="position: absolute;right: -6%;">
                                    {{ __('Edit') }}
                                </button>
                                @endcan
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            <!--MODAL: modal create links -->
            <!--
                <div class="card mb-3" id="editData">
                    <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>1</td>
                            <td>nazwa</td>
                            <td>
                                OPERATION
                            </td>
                        </tr>


                        </tbody>
                    </table>
                    </div>
                </div>

                <div class="card chart-container">
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

        $(function (){
            $(document).ready(function() {
                $('#editData button').click(function(){
                    var formEdit = [];
                    var btn = $(this).data('info');
                    var divNode = document.getElementById($(this).data('info'));
                    var inputNodes = divNode.getElementsByTagName('input');
                    formEdit[divNode.id] = [];
                    for(var i = 0; i < inputNodes.length; i++){
                        formEdit[divNode.id].push({
                            name: inputNodes[i].name,
                            value: inputNodes[i].value
                        });
                    }
                    if($(this).data('set') == 0)
                    {
                        formEdit[divNode.id].forEach((index) => {
                            const element = document.getElementsByName(index.name)[0];
                            element.readOnly = false;
                            element.classList.remove('form-control-plaintext');
                            element.classList.add('form-control');
                            element.classList.remove('text-secondary');
                            element.classList.add('text-black');
                        });
                        $(this).text('Save');
                        $(this).removeClass('btn-info');
                        $(this).addClass('btn-success');
                        $(this).data('set', '1');
                        $(this).attr('type', 'button');
                    }
                    else
                    {
                        $(this).attr('type', 'submit');
                        $('#'+$(this).data('info')).on('submit', function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: $(this).attr('action'),
                                method: $(this).attr('method'),
                                data: new FormData(this),
                                processData: false,
                                dataType: 'json',
                                contentType: false,
                                success:
                                    function (data) {
                                        if (data.status == 0) {
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
                                                    onClick: function () {
                                                    } // Callback after click
                                                }).showToast();
                                            });
                                        } else {
                                            Swal.fire({
                                                title: data.title,
                                                text: data.msg,
                                                type: data.type
                                            });/*.then(function () {
                                                location.reload();
                                            });*/
                                        }
                                    }
                            });
                        });
                        formEdit[divNode.id].forEach((index) => {
                            const element = document.getElementsByName(index.name)[0];
                            element.readOnly = true;
                            element.classList.add('form-control-plaintext');
                            element.classList.remove('form-control');
                            element.classList.add('text-secondary');
                            element.classList.remove('text-black');
                        });
                        formEdit[divNode.id] = [];
                        $(this).text('Edit');
                        $(this).addClass('btn-info');
                        $(this).removeClass('btn-success');
                        $(this).data('set', '0');
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

        $('#type-link').on('change', function() {
            let url = '{{ route('userLinksInfo', $user->id) }}';
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

        $(function (){
            $(document).ready(function() {
                //$('#buttonEditLinks').click(function(){
                $('#exampleModalEdit').on('show.bs.modal', function(e) {
                    let url = '{{ route('userLinkEdit').'/'.$user->id.'/' }}';
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


    /*


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
                            if (data.status == 0) {
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
        });*/
    </script>
    <script>

        Dropzone.options.changeAvatarDropzone = {
            url: '{{ route('updateUserAvatar', $user->id) }}',
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

    JS
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
