@extends('layouts.app')

@section('title', __('Title contacts'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Title contacts') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('List of all title contacts. ') }}</span>
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
                    @if(Auth::user()->can('ACP-contact-title-create'))
                        <a href="#" class="btn btn-primary pull-right" data-info="new" data-route="{{ route('adminContactTitleCreate') }}" data-mdb-toggle="modal" data-mdb-target="#modalEditTitle">{{ __('Create new title') }}</a>
                    @else
                        <button href="" class="btn btn-primary pull-right" disabled>{{ __('Create new title') }}</button>
                    @endif
                    <h2 class="h3 mb-4 page-title">{{ __('Title contacts list') }}</h2>
                    <table class="table table-striped" id="titleList">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Operations') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($titles as $title)
                            <tr>
                                <td>{{ $title->id }}</td>
                                <td>{{ $title->name }}</td>
                                <td>{{ $title->description }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        @if(Auth::user()->can('ACP-contact-title-edit'))
                                            <button href="#" type="button" class="btn btn-outline-info" data-info="{{ $title->id }}" data-route="{{ route('adminContactTitleShow', $title->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalEditTitle">
                                                {{ __('Edit') }}</button>
                                        @else
                                            <button href="#" type="button" class="btn btn-outline-info" disabled>{{ __('Edit') }}</button>
                                        @endif

                                        @if(Auth::user()->can('ACP-contact-title-delete')  && Auth::user()->can('ACP-contact-title-edit'))
                                            <button type="button" class="btn btn-outline-danger" data-info="{{ $title->id }}" data-route="{{ route('adminContactTitleShow', $title->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalDeleteTitle">{{ __('Delete') }}</button>
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

    <!--MODAL: modal title edit or create -->
    <div class="modal fade" id="modalEditTitle" tabindex="-1" aria-labelledby="modalEditTitleLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header ftco-degree-bg">
                    <h5 class="modal-title">{{ __('Title contact: ')}} <span id="nameTitle">{{ __('New title') }}</span></h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-md-0 text-center">
                    <div class="card-content">
                        <div class="card-body">

                            <form method="post" id="titleFormEdit" enctype="multipart/form-data" class="form" action="{{ route('adminContactTitleCreate') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nameTitle">{{ __('Name title') }}</label>
                                            <input type="text" id="nameTitle" class="form-control" placeholder="{{ __('Name title') }}" name="name">
                                            @if ($errors->has('name'))
                                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="nameTitle">{{ __('Description title') }}</label>
                                            <input type="text" id="descriptionTitle" class="form-control" placeholder="{{ __('Description title') }}" name="description">
                                            @if ($errors->has('description'))
                                                <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('Save title') }}</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">{{ __('Reset') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modal: modalConfirmDelete-->
    <div class="modal fade" id="modalDeleteTitle" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitleLabel"
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
                    <form action="#" method="post" id="titleFormDelete">
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
        let titleList = document.querySelector('#titleList');
        let dataTable = new simpleDatatables.DataTable(titleList);
    </script>
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            $('#modalEditTitle').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget);
                let url = btn.data('route');
                if (btn.data('info') == 'new')
                {
                    $('#nameTitle').text('New title');
                    $('#titleFormEdit #name').attr('placeholder', 'Name title').attr('value', '');
                    $('#titleFormEdit').attr('action', btn.data('route'))
                }
                else
                {
                    $.ajax({
                        url:url,
                        method:'POST',
                        data: {data:btn.data('info')},
                        success:
                            function (data) {
                                $('#nameTitle').text(data.Name);
                                $('#titleFormEdit #nameTitle').attr('value', data.Name);
                                $('#titleFormEdit #descriptionTitle').attr('value', data.Description);
                                $('#titleFormEdit').attr('action', data.Edit)
                            }
                    });
                }
            });
        });

        $(document).ready(function(){
            $('#modalDeleteTitle').on('show.bs.modal', function(e) {
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
                            $('#titleFormDelete').attr('action', data.Delete)
                        }
                });
            });
        });

        $(function (){
            $('#titleFormDelete').on('submit', function(e){
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

        $('#titleFormEdit').on('submit', function(e){
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
                        }
                    }
            });
        });
    </script>
@endsection
