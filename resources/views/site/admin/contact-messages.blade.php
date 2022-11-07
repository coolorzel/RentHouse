@extends('layouts.app')

@section('title', __('Message contacts'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Message list') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('List of all message contacts. ') }}</span>
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
                    <h2 class="h3 mb-4 page-title">{{ __('Messages list') }}</h2>
                    <table class="table table-striped" id="messagesList">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('eMail') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Operations') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>
                                    @if(isset($message->user->email))
                                        <a class="text-black" href="{{ route('viewUserProfile', $message->user->id) }}" data-toggle="tooltip" data-placement="top" title="{{ $message->user->name }} {{ $message->user->lname }}">{{ $message->user->email }}</a>
                                    @else
                                        <span class="text-black-75" data-toggle="tooltip" data-placement="top" title="{{ $message->name }} {{ $message->lname }}">{{ $message->email }} <b>({{ __('Guest') }})</b></span>
                                    @endif
                                </td>
                                <td>{{ $message->title->name }}</td>
                                <td>{{ substr($message->message, 0, 25) }}...</td>
                                <td>
                                    @if($message->closed == false)
                                        @if($message->displayed == false)
                                            <span class="badge badge-success">{{ __('New') }}</span>
                                        @else
                                            @if($message->response == false)
                                                <span class="badge badge-secondary">{{ __('Displayed') }}</span>
                                            @else
                                                <span class="badge badge-primary">{{ __('Displayed / Response') }}</span>
                                            @endif
                                        @endif
                                    @else
                                        @if($message->response == false)
                                            <span class="badge badge-danger">{{ __('Closed') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('Closed / Response') }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example" id="operations">
                                        @if(Auth::user()->can('ACP-contact-message-read'))
                                            <button data-route="{{ route('contactMessageOperations', $message->id) }}" data-info="read" type="button" id="readMessage" value="{{ $message->id }}" class="btn btn-outline-info btn-sm">
                                                {{ __('Read') }}</button>
                                        @else
                                            <button href="#" type="button" class="btn btn-outline-info btn-sm" disabled>{{ __('Read') }}</button>
                                        @endif
                                        @if(Auth::user()->can('ACP-contact-message-history'))
                                            <button href="#" type="button" class="btn btn-outline-warning btn-sm" data-info="history" data-route="{{ route('contactMessageOperations', $message->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalHistoryView">
                                                <i class="fa fa-history"></i></button>
                                        @else
                                            <button href="#" type="button" class="btn btn-outline-warning btn-sm" disabled><i class="fa fa-history"></i></button>
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

    <!--MODAL: modal create links -->
    <div class="modal top fade" id="modalHistoryView" tabindex="-1" aria-labelledby="modalHistoryViewLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-dialog-centered modal-warning">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalEditLabel">{{ __('History message') }}: <span id="userEmail">###</span></h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type-link" class="col-form-label">{{ __('History') }}</label>
                        </div>
                        <div class="mb-3">
                            <ul class="list-group" id="historyList">
                                <li class="list-group-item">###</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                            {{ __('Close') }}
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover">
                            Popover on top
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Right popover">
                            Popover on right
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Bottom popover">
                            Popover on bottom
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Left popover">
                            Popover on left
                        </button>
                        </div>
            </div>
        </div>
    </div>
    <!--MODAL: modal create links -->
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
        $("#operations button").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).data('route'),
                data: {
                    id: $(this).val(),
                    operation: $(this).data('info'),
                },
                beforeSend:function (){
                    $('#historyList').text('');
                },
                success: function(result) {
                    if(typeof result.route !== 'undefined') {
                        window.location.assign(result.route);
                    }else{
                        $('#userEmail').text(result.email);
                        $.each(result.history, function (prefix, val) {
                            if(typeof val['user'] !== 'undefined') {
                                $('#historyList').append(
                                    "<li class=\"list-group-item d-flex justify-content-between align-items-center\">" +
                                    "<i class=\"fa fa-question-circle-o\"></i>"
                                    + val['information'] +
                                    "<span style=\"font-size: xx-small\" class=\"badge badge-primary badge-pill\">" +
                                    "MODERATOR: " + val['user'] + "<br>"
                                    + val['created_at'] +
                                    "</span></li>"
                                );
                            }else{
                                $('#historyList').append(
                                    "<li class=\"list-group-item d-flex justify-content-between align-items-center\">" +
                                    "<i class=\"fa fa-question-circle-o\"></i>"
                                    + val['information'] +
                                    "<span style=\"font-size: xx-small\" class=\"badge badge-primary badge-pill\">"
                                    + val['created_at'] +
                                    "</span></li>"
                                );
                            }
                        });
                    }
                },
                error: function(result) {
                    alert('error');
                }
            });
        });
    </script>
    <script>
    </script>
@endsection

