@extends('layouts.app')

@section('title', __('Page Settings'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Page settings') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('All settings in one place. ') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
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
                                        <!--<button class="nav-link" id="nav-notifications-tab" data-bs-toggle="tab" data-bs-target="#nav-notifications-settings" type="button" role="tab" aria-controls="nav-notifications-settings" aria-selected="false">
                                            {{ __('Notification') }}</button>-->
                                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact-settings" type="button" role="tab" aria-controls="nav-contact-settings" aria-selected="false">
                                            {{ __('Contact') }}</button>
                                </div>
                                <form action="{{ route('adminSettingsStore') }}" method="POST" id="settingsFormPost">
                                    @csrf
                                <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-page-settings" role="tabpanel" aria-labelledby="nav-page-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.page')</div>
                                        <div class="tab-pane fade" id="nav-users-settings" role="tabpanel" aria-labelledby="nav-users-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.user')</div>
                                        <!--<div class="tab-pane fade" id="nav-notifications-settings" role="tabpanel" aria-labelledby="nav-notifications-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.notifications')</div>-->
                                        <div class="tab-pane fade" id="nav-contact-settings" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">@include('layouts.elements.admin.pageSettings.contact')</div>

                                        <div class="align-right">
                                            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('scripts')
    <script>
        $(function (){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#settingsFormPost').on('submit', function(e){
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
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#availableSite').on('click', function() {
            var url = $(this).data('link');
            $.ajax({
                url:url,
                method:'POST',
                data: {data:this.value},
                success:
                    function (data) {
                        $('#availableSite').text(data.Button);
                        $('#status').text(data.Status);
                        if (data.Status == true)
                        {
                            $('#status').removeClass('badge-danger');
                            $('#status').addClass('badge-success');
                            $('#availableSite').removeClass('btn-success');
                            $('#availableSite').addClass('btn-danger');
                        }
                        else
                        {
                            $('#status').removeClass('badge-success');
                            $('#status').addClass('badge-danger');
                            $('#availableSite').removeClass('btn-danger');
                            $('#availableSite').addClass('btn-success');
                        }
                    }
            });
        });
    </script>
@endsection
