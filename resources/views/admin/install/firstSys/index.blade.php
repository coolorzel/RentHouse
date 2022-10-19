@extends('layouts.app')

@section('title', __('First Installation'))

@section('content')

    <div class="searching">
        <div class="container col-md-8 py-4">
            <div class="row">
                <div class="col-md-12 p-2 text-center text-shadow">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h3 mb-4 page-title">First install software</h2>
                            <div class="my-4">
                                @if($errors->any())
                                    <ul class="alert alert-warning">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="nav nav-tabs mb-4">
                                    @for($i = 0; $i < count($forms); $i++)
                                        <button class="nav-link @if($step == $i) active @endif" type="button">
                                            {{ __($forms[$i]['name']) }}
                                        </button>
                                        <i class="fa fa-arrow-right"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="tab-content">
                                <form method="post" action="{{ route('firstInstallStore') }}">
                                    @csrf

                                    <div class="tab-pane fade show active">
                                        <h5 class="mb-0 mt-5">{{ __($forms[$step]['name']) }}</h5>
                                        <p>{{ __($forms[$step]['description']) }}</p>
                                        <div class="list-group mb-5 shadow">

                                            @foreach(array_slice($forms[$step], $quantityDefaultInputs) as $key => $value)
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="row mb-2 align-items-center">
                                                            <div class="col">
                                                                <input type="hidden" name="name_settings[]" value="{{ $value['name_settings'] }}">
                                                                <input type="hidden" name="type[]" value="{{ $value['type'] }}">
                                                                <strong class="mb-2">{{ __($value['title_settings']) }}</strong>
                                                                <p class="text-muted mb-0">{{ __($value['description_settings']) }}  </p>
                                                            </div>
                                                            <div class="col-auto">
                                                                @switch($value['input_tag'])
                                                                    @case('input')
                                                                        @switch($value['type'])
                                                                            @case('text')
                                                                                <input name="response[]" type="{{ $value['type'] }}" class="form-control" placeholder="{{ $value['placeholder'] }}">
                                                                            @break
                                                                            @case('checkbox')
                                                                                <input name="response[]" class="form-check-input" type="{{ $value['type'] }}" role="switch" id="flexSwitchCheckDefault" {{ $value['checked'] }}>
                                                                            @break
                                                                            @case('password')
                                                                                <input name="response[]" type="{{ $value['type'] }}" class="form-control" placeholder="{{ $value['placeholder'] }}">
                                                                            @break
                                                                            @case('email')
                                                                                <input name="response[]" type="{{ $value['type'] }}" class="form-control" placeholder="{{ $value['placeholder'] }}">
                                                                            @break
                                                                            @case('time')
                                                                                <input name="response[]" type="{{ $value['type'] }}" class="form-control" placeholder="{{ $value['placeholder'] }}" value="{{ $value['value'] }}">
                                                                            @break
                                                                            @case('tel')
                                                                                <input name="response[]" type="{{ $value['type'] }}" class="form-control" placeholder="{{ $value['placeholder'] }}">
                                                                            @break
                                                                        @endswitch
                                                                    @break
                                                                    @case('select')
                                                                    <select name="response[]" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                                        @foreach($value['response'] as $k => $val)
                                                                            <option value="{{ $k }}">{{ $val }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @break
                                                                @endswitch
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            @if($step+1 == count($forms))
                                                <input type="hidden" name="_step" value="end">
                                                <button class="btn btn-success col-md-3 my-1 mx-auto" type="submit">
                                                    {{ __('Save and Go') }}</button>
                                            @else
                                                @if($step == 0)
                                                    <input type="hidden" name="_step" value="{{ $step+1 }}">
                                                    <button class="btn btn-success col-md-3 my-1 mx-auto" type="submit">
                                                        {{ __('Next step') }} <i class="fa fa-arrow-right"></i></button>
                                                @else
                                                    <input type="hidden" name="_step" value="{{ $step+1 }}">
                                                    <button class="btn btn-success col-md-3 my-1 mx-auto" type="button" onclick="history.back()">
                                                        <i class="fa fa-arrow-left"> {{ __('Back') }}</i></button>
                                                    <button class="btn btn-success col-md-3 my-1 mx-auto" type="submit">
                                                        {{ __('Next step') }} <i class="fa fa-arrow-right"></i></button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
