@extends('layouts.app')

@section('title', __('Roles lists'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Roles View') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('List of all roles. ') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <div class="row gutters-sm">
        <div class="col-md-3 mb-3 shadow p-3 mb-5 bg-body rounded">
            @include('layouts.elements.admin.sidebar')
        </div>
        <div class="col-md-9 shadow p-3 mb-5 bg-body rounded">
            <div class="card mb-3">
                <div class="card-body">
                    @if(Auth::user()->can('ACP-role-create'))
                        <a href="#" class="btn btn-primary pull-right" data-info="new" data-route="{{ route('adminRoleCreate') }}" data-mdb-toggle="modal" data-mdb-target="#modalEditRole">{{ __('Create new role') }}</a>
                    @else
                        <button href="" class="btn btn-primary pull-right" disabled>{{ __('Create new role') }}</button>
                    @endif
                    <h2 class="h3 mb-4 page-title">{{ __('Roles list') }}</h2>
                    <table class="table table-striped" id="rolesList">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Operation') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        @if(Auth::user()->can('ACP-role-edit'))
                                            <button href="#" type="button" class="btn btn-outline-info" data-info="{{ $role->id }}" data-route="{{ route('adminRoleShow', $role->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalEditRole">
                                                {{ __('Edit') }}</button>
                                        @else
                                            <button href="#" type="button" class="btn btn-outline-info" disabled>{{ __('Edit') }}</button>
                                        @endif

                                        @if(Auth::user()->can('ACP-role-delete')  && Auth::user()->can('ACP-role-edit'))
                                            <button type="button" class="btn btn-outline-danger" data-info="{{ $role->id }}" data-route="{{ route('adminRoleShow', $role->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalDeleteRole">{{ __('Delete') }}</button>
                                        @else
                                            <button href="#" type="button" class="btn btn-outline-danger" disabled>
                                                {{ __('Delete') }}</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL: modal roles edit or create -->
    <div class="modal fade" id="modalEditRole" tabindex="-1" aria-labelledby="modalEditRoleLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header ftco-degree-bg">
                    <h5 class="modal-title">{{ __('Role: ')}} <span id="nameRole">{{ __('New role') }}</span></h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-md-0 text-center">
                    <div class="card-content">
                        <div class="card-body">

                            <form method="post" id="roleFormEdit" enctype="multipart/form-data" class="form" action="{{ route('adminRoleCreate') }}">
                                @csrf
                                <div class="row mb-2" id="roleEditLists">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nameRole">{{ __('Name role') }}</label>
                                            <input type="text" id="nameRole" class="form-control" placeholder="{{ __('Name role') }}" name="name">
                                            @if ($errors->has('name'))
                                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <ul class="list-group">
                                            <label class="text-warning" id="admin_all_permission">{{ __('Admin permission') }}</label>
                                            @foreach($adminPermission as $permission)
                                                    <li class="list-group-item">
                                                        <input class="form-check-input me-1 admin_permission" type="checkbox" name="permission[{{ $permission }}]" value="{{ $permission }}" id="role-{{ $permission }}">
                                                        <label class="form-check-label stretched-link" for="role-{{ $permission }}">{{ $permission }}</label>
                                                    </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-warning" id="user_all_permission">{{ __('User permission') }}</label>
                                        @foreach($userPermission as $permission)
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1 user_permission" type="checkbox" name="permission[{{ $permission }}]" value="{{ $permission }}" id="role-{{ $permission }}">
                                                <label class="form-check-label stretched-link" for="role-{{ $permission}}">{{ $permission }}</label>
                                            </li>
                                        @endforeach
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-warning" id="other_all_permission">{{ __('Other permission') }}</label>
                                        @foreach($otherPermission as $permission)
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1 other_permission" type="checkbox" name="permission[{{ $permission }}]" value="{{ $permission }}" id="role-{{ $permission }}">
                                                <label class="form-check-label stretched-link" for="role-{{ $permission }}">{{ $permission }}</label>
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('Save role') }}</button>
                                    <button type="reset" id="reset" class="btn btn-light-secondary me-1 mb-1">{{ __('Reset') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modal: modalConfirmDelete-->
    <div class="modal fade" id="modalDeleteRole" tabindex="-1" role="dialog" aria-labelledby="modalDeleteRoleLabel"
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
                    <form action="#" method="post" id="roleFormDelete">
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
@endsection

@section('scripts')
    <script>
        // Simple Datatable
        let rolesList = document.querySelector('#rolesList');
        let dataTable = new simpleDatatables.DataTable(rolesList);
    </script>

    <script>
        $(document).ready(function() {
            $('#admin_all_permission').on('click', function() {
                if($(this).hasClass('text-warning')) {
                    $(this).removeClass('text-warning').addClass('text-success');
                    $.each($('.admin_permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $(this).removeClass('text-success').addClass('text-warning');
                    $.each($('.admin_permission'), function() {
                        $(this).prop('checked',false);
                    });
                }
            });

            $(".admin_permission").change(function(){
                if ($('.admin_permission:checked').length == $('.admin_permission').length) {
                    $('#admin_all_permission').removeClass('text-warning').addClass('text-success');
                }
                else {
                    $('#admin_all_permission').removeClass('text-success').addClass('text-warning');
                }
            });

            $('#user_all_permission').on('click', function() {
                if($(this).hasClass('text-warning')) {
                    $(this).removeClass('text-warning').addClass('text-success');
                    $.each($('.user_permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $(this).removeClass('text-success').addClass('text-warning');
                    $.each($('.user_permission'), function() {
                        $(this).prop('checked',false);
                    });
                }
            });

            $(".user_permission").change(function(){
                if ($('.user_permission:checked').length == $('.user_permission').length) {
                    $('#user_all_permission').removeClass('text-warning').addClass('text-success');
                }
                else {
                    $('#user_all_permission').removeClass('text-success').addClass('text-warning');
                }
            });

            $('#other_all_permission').on('click', function() {
                if($(this).hasClass('text-warning')) {
                    $(this).removeClass('text-warning').addClass('text-success');
                    $.each($('.other_permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $(this).removeClass('text-success').addClass('text-warning');
                    $.each($('.other_permission'), function() {
                        $(this).prop('checked',false);
                    });
                }
            });

            $(".other_permission").change(function(){
                if ($('.other_permission:checked').length == $('.other_permission').length) {
                    $('#other_all_permission').removeClass('text-warning').addClass('text-success');
                }
                else {
                    $('#other_all_permission').removeClass('text-success').addClass('text-warning');
                }
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            $('#modalEditRole').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget);
                let url = btn.data('route');
                if (btn.data('info') == 'new')
                {
                    $('#nameRole').text('New role');
                    $('#roleFormEdit #nameRole').attr('placeholder', 'Name role').attr('value', '');
                    $('#roleFormEdit').attr('action', btn.data('route'))
                    $("#roleEditLists").find(".list-group-item .form-check-input").prop('checked', false);
                    $('#admin_all_permission').removeClass('text-success').addClass('text-warning');
                    $('#user_all_permission').removeClass('text-success').addClass('text-warning');
                    $('#other_all_permission').removeClass('text-success').addClass('text-warning');
                }
                else
                {
                    $.ajax({
                        url:url,
                        method:'POST',
                        data: {data:btn.data('info')},
                        beforeSend:function (){
                            $("#roleEditLists").find(".list-group-item .form-check-input").prop('checked', false);

                        },
                        success:
                            function (data) {
                                $('#nameRole').text(data.Name);
                                $('#roleFormEdit #nameRole').attr('value', data.Name);
                                $('#roleFormEdit').attr('action', data.Edit);
                                $.each(data.Active, function (prefix, val) {
                                    $('#role-' + val).prop('checked', true);
                                });
                                if ($('.admin_permission:checked').length == $('.admin_permission').length) {
                                    $('#admin_all_permission').removeClass('text-warning').addClass('text-success');
                                }
                                else {
                                    $('#admin_all_permission').removeClass('text-success').addClass('text-warning');
                                }
                                if ($('.user_permission:checked').length == $('.user_permission').length) {
                                    $('#user_all_permission').removeClass('text-warning').addClass('text-success');
                                }
                                else {
                                    $('#user_all_permission').removeClass('text-success').addClass('text-warning');
                                }
                                if ($('.other_permission:checked').length == $('.other_permission').length) {
                                    $('#other_all_permission').removeClass('text-warning').addClass('text-success');
                                }
                                else {
                                    $('#other_all_permission').removeClass('text-success').addClass('text-warning');
                                }
                            }
                    });
                }
            });
        });

        $(document).ready(function(){
            $('#modalDeleteRole').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget);
                let url = btn.data('route');
                $.ajax({
                    url:url,
                    method:'POST',
                    data: {data:btn.data('info')},
                    success:
                        function (data) {
                            const element = document.getElementById('buttonSubmitDelete');
                            element.disabled = false;
                            $('#roleFormDelete').attr('action', data.Delete)
                        }
                });
            });
        });

        $(function (){
            $('#roleFormDelete').on('submit', function(e){
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


                                $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        }
                });
            });
            $('#roleFormEdit').on('reset', function(){
                    $('#admin_all_permission').removeClass('text-success').addClass('text-warning');
                    $('#user_all_permission').removeClass('text-success').addClass('text-warning');
                    $('#other_all_permission').removeClass('text-success').addClass('text-warning');
            });
        });

        $('#roleFormEdit').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:new FormData(this),
                processData: false,
                dataType:'json',
                contentType:false,
                success:
                    function(data){
                        if(data.status == 0) {
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
                        }else{

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
    </script>
@endsection
