@extends('layouts.app')

@section('title', __('First Installation'))

@section('content')
    {{Form::open(array('route' => 'firstInstallStore', 'method' => 'post'))}}

    <div class="searching" style="height: 100vh">
        <div class="container" style="height: 100%">
            <div class="row py-5" style="height: 100%; align-content: center;">
                <h3 class="col-md-12 p-2 text-center text-light">Znajdź dom dla siebie</h3>
                {{Form::submit(__('Install'), array('class' => 'btn btn-success col-md-3 my-1 mx-auto'))}}
            </div>
        </div>
    </div>
    {{Form::close()}}
@endsection
