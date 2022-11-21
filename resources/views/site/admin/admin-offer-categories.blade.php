@extends('layouts.app')

@section('title', __('Offer categories'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary" disabled>{{ __('Offer Controller') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Categories') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('List of all categories for offers. ') }}</span>
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
                    @if(Auth::user()->can('ACP-offers-category-create'))
                        <a href="#" class="btn btn-primary pull-right" data-info="new" data-route="{{ route('adminOffersCategoryCreate') }}" data-mdb-toggle="modal" data-mdb-target="#modalEditCategory">{{ __('Create new category') }}</a>
                    @else
                        <button href="" class="btn btn-primary pull-right" disabled>{{ __('Create new category') }}</button>
                    @endif
                    <h2 class="h3 mb-4 page-title">{{ __('Categories list') }}</h2>
                    <table class="table table-striped" id="titleList">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Enabled') }}</th>
                            <th>{{ __('Icon') }}</th>
                            <th>{{ __('Operations') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        @if($category->destroy == false)
                                            @if($category->enable == true)
                                                <i class="fa fa-power-off text-warning btn-outline-warning"></i>
                                            @else
                                                <i class="fa fa-power-off text-secondary btn-outline-secondary"></i>
                                            @endif
                                        @else
                                            <i class="fa fa-trash-o text-danger btn-outline-danger"></i>
                                        @endif
                                    </td>
                                    <td><i class="fa {{ $category->icon }} fa-2x text-warning"></i></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            @if(Auth::user()->can('ACP-offers-category-edit'))
                                                <button href="#" type="button" class="btn btn-outline-info" data-info="{{ $category->id }}" data-route="{{ route('adminOffersCategoryShow', $category->slug) }}" data-mdb-toggle="modal" data-mdb-target="#modalEditCategory">
                                                    {{ __('Edit') }}</button>
                                            @else
                                                <button href="#" type="button" class="btn btn-outline-info" disabled>{{ __('Edit') }}</button>
                                            @endif

                                            @if(Auth::user()->can('ACP-offers-category-delete')  && Auth::user()->can('ACP-offers-category-edit'))
                                                <button type="button" class="btn btn-outline-danger" data-info="{{ $category->id }}" data-route="{{ route('adminOffersCategoryShow', $category->slug) }}" data-mdb-toggle="modal" data-mdb-target="#modalDeleteCategory">
                                                    @if($category->destroy == false)
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
    <div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="modalEditCategoryLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form method="post" id="categoryFormEdit" enctype="multipart/form-data" class="form" action="{{ route('adminOffersCategoryCreate') }}">
                    @csrf
                    <div class="modal-header ftco-degree-bg">
                        <h5 class="modal-title">{{ __('Category: ')}} <span id="nameCategoryTitle">{{ __('New category') }}</span></h5>
                        <button type="reset" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-md-0">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="row col-md-6 col-sm-6 col-6 col-lg-6 text-center">
                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="nameCategory">{{ __('Name category') }}</label>
                                                <input type="text" id="nameCategory" class="form-control" placeholder="{{ __('Name category') }}" name="name" onkeyup="tranSlug()" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="slugCategory">{{ __('Slug category') }}</label>
                                                <input type="text" readonly id="slugCategory" class="form-control" placeholder="{{ __('Name category') }}" name="slug">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mb-2">
                                            <div class="form-group">
                                                <label for="descriptionCategory">{{ __('Description category') }}</label>
                                                <input type="text" id="descriptionCategory" class="form-control" placeholder="{{ __('Description category') }}" name="description" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="iconCategory">{{ __('Icon category') }}</label>
                                                <div class="input-group">
                                                <select name="icon" id="iconCategory" class="form-control" aria-label="" required>
                                                    <option value="fa-home" selected>{{ __('Home') }}</option>
                                                    <option value="fa-building-o">{{ __('Apartments') }}</option>
                                                    <option value="fa-map-o">{{ __('Map') }}</option>
                                                    <option value="fa-tree">{{ __('Tree') }}</option>
                                                    <option value="fa-bed">{{ __('Bed') }}</option>
                                                    <option value="fa-shopping-basket">{{ __('Shop') }}</option>
                                                    <option value="fa-car">{{ __('Garage') }}</option>
                                                </select>
                                                    <label class="input-group-text" for="icon">
                                                        <i id="view-fa" class="fa fa-home" aria-hidden="true" style="font-size: 24px;"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="enableCategory">{{ __('Enabled') }}</label>
                                                <div class="btn-group input-group">
                                                    <input type="radio" class="btn-check" name="enable" id="enableOn" autocomplete="off" value="1" checked />
                                                    <label class="btn btn-secondary" for="enableOn">{{ __('On') }}</label>

                                                    <input type="radio" class="btn-check" name="enable" id="enableOff" value="0" autocomplete="off" />
                                                    <label class="btn btn-secondary" for="enableOff">{{ __('Off') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <label class="text-warning" id="other_all_permission">{{ __('Select active form of this Category') }}</label>
                                        <div id="formLists">
                                            @foreach($forms as $form)
                                                <li class="list-group-item">
                                                    <input class="form-check-input me-1 other_permission" type="checkbox" name="form[{{ $form->id }}]" value="{{ $form->id }}" id="form-{{ $form->id }}">
                                                    <label class="form-check-label stretched-link" for="form-{{ $form->id }}">{{ $form->name }} <i class="fa fa-arrow-right text-warning"></i> [{{ $form->type }}]</label>
                                                </li>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('Save title') }}</button>
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
    <div class="modal fade" id="modalDeleteCategory" tabindex="-1" role="dialog" aria-labelledby="modalDeleteCategoryLabel"
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

        function tranSlug()
        {
            let text = document.getElementById("nameCategory");
            let value1 = text.value;
            let replaceText1 = value1.replace(/ /g, "-");
            document.getElementById("slugCategory").value = (replaceText1.toLowerCase());
        }


        $('#iconCategory').on('change', function() {
            $('#view-fa').removeClass().addClass('fa ' + $(this).val());
        });

    </script>
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            $('#modalEditCategory').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget);
                let url = btn.data('route');
                if (btn.data('info') === 'new')
                {
                    $('#nameCategoryTitle').text('New category');
                    $('#categoryFormEdit #nameCategory').attr('placeholder', 'Name category').attr('value', '');
                    $('#categoryFormEdit #slugCategory').attr('placeholder', 'Slug category').attr('value', '');
                    $('#categoryFormEdit').attr('action', btn.data('route'));
                    $('#categoryFormEdit #descriptionCategory').attr('placeholder', 'Description category').attr('value', '');
                    $('#slugCategory').prop('readonly', false).text('').prop('readonly', true);
                    $('#enableOn').prop('checked', true);$('#enableOff').prop('checked', false);
                    $('#iconCategory').attr('value', 'fa-home');
                    $('#view-fa').removeClass().addClass('fa ' + $('#iconCategory').val());

                    var formInputChecked = [];
                    var divNod = document.getElementById("formLists");
                    var inputNod = divNod.getElementsByTagName('INPUT');
                    for(var i = 0; i < inputNod.length; i++){
                        formInputChecked.push({
                            name: inputNod[i].name,
                            value: inputNod[i].value
                        });
                    }
                    formInputChecked.forEach((index) => {
                        const element = document.getElementsByName(index.name)[0];
                        element.checked = false;
                    });

                }
                else
                {
                    $('#formLists').text('');
                    $.ajax({
                        url:url,
                        method:'POST',
                        data: {data:btn.data('info')},
                        success:
                            function (data) {
                                let Forms = data.Forms;
                                $('#nameCategory').attr('value', data.Name);
                                $('#slugCategory').prop('readonly', false).val(data.Slug).prop('readonly', true);
                                $('#descriptionCategory').text(data.Description);
                                $('#nameCategoryTitle').text(data.Name);
                                $('#categoryFormEdit #descriptionCategory').attr('value', data.Description);
                                $('#categoryFormEdit').attr('action', data.Edit)
                                if(data.Enable === 1){
                                    $('#enableOn').prop('checked', true);$('#enableOff').prop('checked', false);
                                }else{
                                    $('#enableOn').prop('checked', false);$('#enableOff').prop('checked', true);
                                }
                                $('#iconCategory').val(data.Icon);
                                $('#view-fa').removeClass().addClass('fa ' + data.Icon);
                                if(data.Destroy === 1){
                                    $('#enableOn').prop('disabled', true);
                                    $('#enableOff').prop('disabled', true);
                                }else{
                                    $('#enableOn').prop('disabled', false);
                                    $('#enableOff').prop('disabled', false);
                                }
                                $.each(data.AllForms, function(prefix, val){
                                    if(Forms.includes(val['id'])){
                                        $('#formLists').append("<li class=\"list-group-item\">" +
                                            "<input class=\"form-check-input me-1 other_permission\" type=\"checkbox\" name=\"form[" + val['id'] + "]\" value=\"" + val['id'] + " \" id=\"form-" + val['id'] + "\" checked>" +
                                            "<label class=\"form-check-label stretched-link\" for=\"form-" + val['id'] + "\">" + val['name'] + " <i class=\"fa fa-arrow-right text-warning\"></i> [" + val['name'] + "]</label>" +
                                            "\"</li>");
                                    }else {
                                        $('#formLists').append("<li class=\"list-group-item\">" +
                                            "<input class=\"form-check-input me-1 other_permission\" type=\"checkbox\" name=\"form[" + val['id'] + "]\" value=\"" + val['id'] + " \" id=\"form-" + val['id'] + "\">" +
                                            "<label class=\"form-check-label stretched-link\" for=\"form-" + val['id'] + "\">" + val['name'] + " <i class=\"fa fa-arrow-right text-warning\"></i> [" + val['name'] + "]</label>" +
                                            "\"</li>");
                                    }
                                })
                            }
                    });
                }
            });
        });

        $(document).ready(function(){
            $('#modalDeleteCategory').on('show.bs.modal', function(e) {
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
                            if(data.Destroy === 1){
                                $('#deleteRestoreIcon').removeClass('fa-times', 'text-danger').addClass('fa-check', 'text-success');
                            }else{
                                $('#deleteRestoreIcon').removeClass('fa-check', 'text-success').addClass('fa-times', 'text-danger');
                            }
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
