@extends('layouts.app')

@section('title', __('Active form in categories'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary" disabled>{{ __('Offer Controller') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Active form in Category') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('List of all form for offers in category. ') }}</span>
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
                    @if(Auth::user()->can('ACP-offers-form-in-category-create'))
                        <a href="#" class="btn btn-primary pull-right" data-info="new" data-route="{{ route('adminOffersFormInCategoryCreate') }}" data-mdb-toggle="modal" data-mdb-target="#modalEditFormInCategory">{{ __('Create new category') }}</a>
                    @else
                        <button href="" class="btn btn-primary pull-right" disabled>{{ __('Create new form') }}</button>
                    @endif
                    <h2 class="h3 mb-4 page-title">{{ __('List of forms available for the category') }}</h2>
                    <table class="table table-striped" id="titleList">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Have options') }}</th>
                            <th>{{ __('Operations') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($elements as $element)
                            <tr>
                                <td>{{ $element->id }}</td>
                                <td>{{ $element->name }}</td>
                                <td>{{ $element->title }}</td>
                                <td>{{ $element->type }}</td>
                                <td>
                                    @if($element->have_options == true)
                                        {{ __('Yes') }}
                                    @else
                                        {{ __('NO') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        @if(Auth::user()->can('ACP-offers-form-incategory-edit'))
                                            <button href="#" type="button" class="btn btn-outline-info" data-info="{{ $element->id }}" data-route="{{ route('adminOffersFormInCategoryShow', $element->id) }}"data-mdb-toggle="modal" data-mdb-target="#modalEditFormInCategory">
                                                {{ __('Edit') }}</button>
                                        @else
                                            <button href="#" type="button" class="btn btn-outline-info" disabled>{{ __('Edit') }}</button>
                                        @endif

                                        @if(Auth::user()->can('ACP-offers-form-in-category-delete')  && Auth::user()->can('ACP-offers-form-in-category-edit'))
                                            <button type="button" class="btn btn-outline-danger" data-info="{{ $element->id }}" data-route="{{ route('adminOffersFormInCategoryShow', $element->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalDeleteFormInCategory">
                                                @if($element->destroy == false)
                                                    {{ __('Delete') }}
                                                @else
                                                    {{ __('Restore') }}
                                                @endif
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
    <div class="modal fade" id="modalEditFormInCategory" tabindex="-1" aria-labelledby="modalEditFormInCategoryLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="categoryFormEdit" enctype="multipart/form-data" class="form" action="{{ route('adminOffersFormInCategoryCreate') }}">
                    @csrf
                    <div class="modal-header ftco-degree-bg">
                        <h5 class="modal-title">{{ __('Form: ')}} <span id="nameCategoryTitle">{{ __('New form in category') }}</span></h5>
                        <button type="reset" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-md-0 text-center">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 col-6 mb-2">
                                        <div class="form-group">
                                            <label for="nameCategory">{{ __('Name form in category') }}</label>
                                            <input type="text" id="nameCategory" class="form-control" placeholder="{{ __('Name category') }}" name="name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-6 mb-2">
                                        <div class="form-group">
                                            <label for="titleCategory">{{ __('Title form in category') }}</label>
                                            <input type="text" id="titleCategory" class="form-control" placeholder="{{ __('Title category') }}" name="title" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-6 mb-2">
                                        <div class="form-group">
                                            <label for="typeFormInCategory">{{ __('Type input') }}</label>
                                            <select name="type" id="typeFormInCategory" class="form-control" aria-label="" required>
                                                <option value="text" selected>{{ __('Text') }}</option>
                                                <option value="file">{{ __('File') }}</option>
                                                <option value="select">{{ __('Select') }}</option>
                                                <option value="checkbox">{{ __('Checkbox') }}</option>
                                                <option value="number">{{ __('Number') }}</option>
                                                <option value="textarea">{{ __('Textarea') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="enableCategory">{{ __('Have options') }}</label>
                                            <div class="btn-group input-group">
                                                <input type="radio" class="btn-check" name="have_options" id="haveOptionsOn" autocomplete="off" value="1" checked />
                                                <label class="btn btn-secondary" for="haveOptionsOn">{{ __('On') }}</label>

                                                <input type="radio" class="btn-check" name="have_options" id="haveOptionsOff" value="0" autocomplete="off" />
                                                <label class="btn btn-secondary" for="haveOptionsOff">{{ __('Off') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('Save form') }}</button>
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
    <div class="modal fade" id="modalDeleteFormInCategory" tabindex="-1" role="dialog" aria-labelledby="modalDeleteFormInCategoryLabel"
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
                    <form action="#" method="post" id="categoryFormDelete">
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

            $('#modalEditFormInCategory').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget);
                let url = btn.data('route');
                if (btn.data('info') === 'new')
                {
                    $('#nameCategoryTitle').text('New category');
                    $('#categoryFormEdit #nameCategory').attr('placeholder', 'Name form in category').attr('value', '');
                    $('#categoryFormEdit').attr('action', btn.data('route'));
                    $('#haveOptionsOn').prop('checked', true);$('#haveOptionsOff').prop('checked', false);
                }
                else
                {
                    $.ajax({
                        url:url,
                        method:'POST',
                        data: {data:btn.data('info')},
                        success:
                            function (data) {
                                $('#nameCategory').attr('value', data.Name);
                                $('#nameCategoryTitle').text(data.Name);
                                $('#titleCategory').attr('value', data.Title);
                                $('#categoryFormEdit').attr('action', data.Edit);
                                $('#typeFormInCategory').val(data.Type);
                                if(data.Model) {
                                    $('#selectModel').val(data.Model);
                                }
                                if(data.HaveOptions === 1){
                                    $('#haveOptionsOn').prop('checked', true);$('#haveOptionsOff').prop('checked', false);
                                }else{
                                    $('#haveOptionsOn').prop('checked', false);$('#haveOptionsOff').prop('checked', true);
                                }
                            }
                    });
                }
            });
        });

        $(document).ready(function(){
            $('#modalDeleteFormInCategory').on('show.bs.modal', function(e) {
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
                            $('#categoryFormDelete').attr('action', data.Delete);
                        }
                });
            });
        });

        $(function (){
            $('#categoryFormDelete').on('submit', function(e){
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
        });

        $('#categoryFormEdit').on('submit', function(e){
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
