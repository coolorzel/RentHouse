@extends('layouts.app')

@section('title', __('Message contacts'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Message list') }}</button>
        @if($message->email)
            <button class="btn btn-outline-secondary active">{{ __('Message') }} [<b>{{ $message->email}}</b>]</button>
        @else
            <button class="btn btn-outline-secondary active">{{ __('Message') }} [<b>{{ $message->user->email}}</b> ({{ __('Guest') }})]</button>
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
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="h3 mb-4 page-title">{{ __('Messages list') }}</h2>

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
