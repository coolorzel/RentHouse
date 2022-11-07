@extends('layouts.app')

@section('title', __('Show message'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Message list') }}</button>
        @if($message->email)
            <button class="btn btn-outline-secondary active">{{ __('Message') }} [<b>{{ $message->email}}</b> ({{ __('Guest') }})]</button>
        @else
            <button class="btn btn-outline-secondary active">{{ __('Message') }} [<b>{{ $message->user->email}}</b>]</button>
        @endif
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Reading the message.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <div class="row gutters-sm">
        <div class="col-md-3 mb-3 shadow p-3 mb-5 bg-body rounded">
            @include('layouts.elements.admin.sidebar')
        </div>
        <div class="col-md-9 shadow p-3 mb-5 bg-body rounded">
            <div class="row">
                <div class="col-md-4 mb-3 shadow p-3 mb-5 bg-body rounded">
                    <div class="card-body">
                            <div class="d-flex align-items-center text-center">
                                @if($message->email)
                                <h4><span class="badge bg-secondary">{{ __('Guest') }}</span></h4>
                                @else
                                    <a href="{{ route('viewUserProfile', $message->user->id) }}"><h4><span class="badge bg-info">{{ __('User') }}</span></h4></a>
                                @endif
                            </div>
                        <div class="d-flex align-items-center text-center">
                            {{ __('Message ID') }}: <b>@if($message->email) {{ $message->name }}@else {{ $message->user->name }}@endif</b>
                        </div>
                        <div class="d-flex align-items-center text-center">
                                {{ __('First name') }}: <b>@if($message->email) {{ $message->name }}@else {{ $message->user->name }}@endif</b>
                        </div>
                        <div class="d-flex align-items-center text-center">
                                {{ __('Last name') }}: <b>@if($message->email) {{ $message->lname }}@else {{ $message->user->lname }}@endif</b>
                        </div>
                        <div class="d-flex align-items-center text-center">
                            {{ __('Email') }}: <b>@if($message->email) {{ $message->email }}@else {{ $message->user->email }}@endif</b>
                        </div>
                        <div class="align-items-center text-center d-grid gap-2" id="operation">
                            @if(!$message->email)
                            <a href="{{ route('viewUserProfile', $message->user->id) }}" type="button" class="btn btn-light">{{ __('Open profile') }}</a>
                            @endif
                            @can('ACP-contact-message-change-status-read-un-read')
                                <form id="statusReadUnRead" action="{{ route('adminContactMessageReadUnRead', $message->id) }}" method="POST" class="d-grid gap-2">
                                    @csrf
                                    <button id="btnReadUnRead" type="submit" class="btn btn-secondary">@if($message->displayed == 1) {{ __('Mark as unread') }}@else {{ __('Mark as read') }}@endif</button>
                                </form>
                            @endcan
                            @can('ACP-contact-message-change-status-close')
                                <form id="statusClose" action="{{ route('adminContactMessageClose', $message->id) }}" method="POST" class="d-grid gap-2">
                                    @csrf
                                    <button id="btnClose" type="submit" class="btn btn-danger">@if($message->closed == 1) {{ __('Open') }}@else {{ __('Close') }}@endif</button>
                                </form>
                            @endcan
                            <button type="button" class="btn btn-warning" disabled>{{ __('Response') }}</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 shadow p-3 mb-5 bg-body rounded">
                    <div class="card-body">
                        <h2 class="h3 mb-4 page-title fw-bold position-relative">{{ __('Title') }}: {{ $message->title->name }}
                            <span id="messageStatus" class="position-absolute top-0 start-100 translate-middle badge rounded-pill @if($message->closed == false) bg-success @else bg-danger @endif">
                                @if($message->closed == false)
                                    @if($message->displayed == true) {{ __('Has been read') }}@else {{ __('Has not been read') }}@endif
                                @else
                                    {{ __('Has been CLOSE') }}
                                @endif
                            </span>
                        </h2>
                        <hr>
                        <div class="fw-italic">
                            {{ $message->message }}
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
        let messagesList = document.querySelector('#messagesList');
        let dataTable = new simpleDatatables.DataTable(messagesList);
    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function (){
            $('#operation form').on('submit', function(e){
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
                            } else {
                                if(data.typepost == 'readunread')
                                {
                                    $('#messageStatus').text(data.description);
                                    $('#btnReadUnRead').text(data.btn);
                                }
                                if(data.typepost == 'close')
                                {
                                    $('#messageStatus').text(data.description);
                                    $('#btnClose').text(data.btn);
                                }

                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                });
                            }
                        }
                });
            });
        });
    </script>
@endsection
