@extends('layouts.app')

@section('title', __('Element form:').$form->name)

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary" disabled>{{ __('Offer Controller') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Element: ').$form->name }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('List of element form: '.$form->name.'. Edit change and create new') }}</span>
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
                    @if(Auth::user()->can('ACP-element-form-control-create'))
                        <a href="#" class="btn btn-primary pull-right" data-info="new" data-route="{{ route('adminElementFormCreate', $form->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalEdit">{{ __('Create new option') }}</a>
                    @else
                        <button href="" class="btn btn-primary pull-right" disabled>{{ __('Create new option') }}</button>
                    @endif
                    <h2 class="h3 mb-4 page-title">{{ $form->name. __(' list') }}</h2>
                    <table class="table table-striped" id="titleList">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Operations') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($options as $option)
                            <tr>
                                <td>{{ $option->id }}</td>
                                <td>{{ $option->name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        @if(Auth::user()->can('ACP-element-form-control-edit'))
                                            <button href="#" type="button" class="btn btn-outline-info" data-info="{{ $option->id }}" data-route="{{ route('adminElementFormShow', [$form->id, $option->id]) }}" data-mdb-toggle="modal" data-mdb-target="#modalEdit">
                                                {{ __('Edit') }}</button>
                                        @else
                                            <button href="#" type="button" class="btn btn-outline-info" disabled>{{ __('Edit') }}</button>
                                        @endif

                                        @if(Auth::user()->can('ACP-element-form-control-delete')  && Auth::user()->can('ACP-element-form-control-edit'))
                                            <button type="button" class="btn btn-outline-danger" data-info="{{ $option->id }}" data-route="{{ route('adminElementFormShow', [$form->id, $option->id]) }}" data-mdb-toggle="modal" data-mdb-target="#modalDelete">
                                                    {{ __('Delete') }}
                                            </button>
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
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="formEdit" enctype="multipart/form-data" class="form" action="{{ route('adminElementFormCreate', $form->id) }}">
                    @csrf
                    <div class="modal-header ftco-degree-bg">
                        <h5 class="modal-title">{{ __($form->name)}}: <span id="nameTitle">{{ __('New Options name') }}</span></h5>
                        <button type="reset" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-md-0">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="row col-md-12 col-sm-12 col-12 col-lg-12 text-center">
                                        <div class="col-md-12 col-12 mb-2">
                                            <div class="form-group">
                                                <label for="name">{{ __('Options name') }}</label>
                                                <input type="text" id="name" class="form-control" placeholder="{{ __('Options name') }}" name="name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('Save options') }}</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">{{ __('Reset') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal: modalConfirmDelete-->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel"
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
                    <form action="#" method="post" id="formDelete">
                        <button type="submit" class="btn btn-outline-danger" id="buttonSubmitDelete" disabled>{{ __('Yes') }}</button>
                    </form>
                    <button type="button" class="btn btn-danger waves-effect" data-mdb-dismiss="modal">
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
            $('#modalEdit').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget)
                let url = btn.data('route')
                if (btn.data('info') === 'new')
                {
                    $('#nameTitle').text('New options')
                    $('#formEdit #name').attr('placeholder', 'Name options in element form').attr('value', '')
                    $('#formEdit').attr('action', btn.data('route'))
                }
                else
                {
                    $.ajax({
                        url:url,
                        method:'POST',
                        data: {data:btn.data('info')},
                        success:
                            function (data) {
                                $('#name').attr('value', data.Name)
                                $('#nameTitle').text(data.Name)
                                $('#formEdit').attr('action', data.Edit)
                                if(data.Model) {
                                    $('#selectModel').val(data.Model)
                                }
                            }
                    })
                }
            })

            $('#formEdit').on('submit', function(e){
                e.preventDefault()

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
                                $('#errors').show()

                                $.each(data.error, function (prefix, val) {
                                    $('#errors-list').append("<li>" + val[0] + "</li>")
                                })
                            }else{

                                $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.reload()
                                })
                            }
                        }
                })
            })

            $('#modalDelete').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget)
                let url = btn.data('route')
                $.ajax({
                    url:url,
                    method:'POST',
                    data: {data:btn.data('info')},
                    success:
                        function (data) {
                            const element = document.getElementById('buttonSubmitDelete')
                            element.disabled = false
                            $('#formDelete').attr('action', data.Delete)
                        }
                });
            });

            $('#formDelete').on('submit', function(e){
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

        })
    </script>

@endsection
