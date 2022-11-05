@extends('layouts.app')

@section('title', __('Message contacts'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Message contacts') }}</button>
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
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        @if(Auth::user()->can('ACP-contact-message-read'))
                                            <button href="#" type="button" class="btn btn-sm btn-outline-info" data-info="{{ $message->id }}" data-route="{{ route('adminContactTitleShow', $message->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalEditMethod">
                                                {{ __('Read On') }}</button>
                                        @else
                                            <button href="#" type="button" class="btn btn-sm btn-outline-info" disabled>{{ __('Read On') }}</button>
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
@endsection
