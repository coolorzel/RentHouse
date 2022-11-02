@extends('layouts.app')

@section('title', __('User Lists'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('User View') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('List of all users. ') }}</span>
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
                    <h2 class="h3 mb-4 page-title">{{ __('User list') }}</h2>
                                <table class="table table-striped" id="table1">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Last name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Verified</th>
                                        <th>Operation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
@foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->lname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ strtoupper($user->roles->pluck('name')->first()) }}</td>
                                        <td>@if(isset($user->email_verified_at)) <span class="text-success"><i class="fa fa-check fa-2x"></i></span> @else <span class="text-danger"><i class="fa fa-close fa-2x"></i></span> @endif</td>
                                        <td>
                                            <button id="view-profile" type="button" class="btn btn-outline-success btn-floating" data-info="{{ $user->id }}" data-route="{{ route('adminUserInfo') }}" data-mdb-toggle="modal" data-mdb-target="#modalUserProfile" data-mdb-ripple-color="dark" data-bs-html="true" data-bs-toogle="tooltip" title="<em>{{ __('Preview user profile.') }}<em>">
                                                <i class="fa fa-user"></i>
                                            </button>

                                            <button type="button" class="btn btn-outline-primary btn-floating" data-mdb-ripple-color="dark" data-bs-html="true" data-bs-toogle="tooltip" title="<em>{{ __('Send message for users.') }}<em>" disabled>
                                                <i class="fa fa-envelope"></i>
                                            </button>
                                        </td>
                                    </tr>
@endforeach

                                    </tbody>
                                </table>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL: modal user profile link -->
    <div class="modal fade" id="modalUserProfile" tabindex="-1" aria-labelledby="modalUserProfileLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header ftco-degree-bg">
                    <h5 class="modal-title">{{ __('User: ').Auth::user()->email }}</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-md-0 text-center">
                        <div class="container py-4 h-100">
                            <div class="row d-flex align-items-center h-100">
                                <div class="col col-md-9 col-lg-7 col-xl-5">
                                    <div class="card" style="border-radius: 15px;">
                                        <div class="card-body p-4">
                                            <div class="d-flex text-black">
                                                <div class="flex-shrink-0">
                                                    <div class="user-img d-flex align-items-center">
                                                        @if (Auth::check() && Auth::user()->avatar)
                                                            <img id="userAvatar" src="{{ asset('assets/uploads/users/'.Auth::id().'/avatar/'.Auth::user()->avatar) }}" alt="avatar" class="rounded-circle" width="150" height="150">
                                                        @else
                                                            <img src="{{ asset('project/img/default_avatar.png') }}" alt="default_avatar" class="rounded-circle" width="150" height="150">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mb-1"><span id="name">{{ Auth::user()->name }}</span> <span id="lname">{{ Auth::user()->lname }}</span></h5>
                                                    <p class="mb-2 pb-1" style="color: #2b2a2a;"><span id="role">{{ strtoupper(Auth::user()->roles->first()->name) }}</span></p>
                                                    <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                                                         style="background-color: #efefef;">
                                                        <div>
                                                            <p class="small text-muted mb-1">{{ __('Telephone') }}</p>
                                                            <p class="mb-0">{{ Auth::user()->phone_number }}</p>
                                                        </div>
                                                        <div class="px-3">
                                                            <p class="small text-muted mb-1">{{ __('City') }}</p>
                                                            <p class="mb-0">{{ Auth::user()->city }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="small text-muted mb-1">{{ __('Zip-Code') }}</p>
                                                            <p class="mb-0">{{ Auth::user()->zipcode }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex pt-1">
                                                        <button type="button" class="btn btn-outline-primary me-1 flex-grow-1" disabled>
                                                            {{ __('Chat') }}</button>
                                                        <a href="#" id="userlink" type="button" class="btn btn-primary flex-grow-1">{{ __('View Profile') }}</a>
                                                    </div>
                                                </div>
                                            </div>
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

@section('scripts')
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            $('button').tooltip();
            $('#modalUserProfile').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget);
                let url = btn.data('route');

                $.ajax({
                    url:url,
                    method:'POST',
                    data: {data:btn.data('info')},
                    success:
                        function (data) {
                            $('#name').text(data.Name);
                            $('#lname').text(data.Lname);
                            $('#role').text(data.Role);
                            $('#userlink').attr('href', data.Link);
                            $('#userAvatar').attr('src', data.Avatar);
                            /*$('#exampleModalEditLabel').text(data.Name);
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
                            e2.disabled = false;*/
                        }
                });
            });
        });
    </script>
@endsection
