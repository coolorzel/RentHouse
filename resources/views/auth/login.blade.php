@extends('layouts.app')

@section('title', __('Login or register'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 shadow p-3 mb-5 bg-body rounded">
            <p class="h2 text-secondary align-self-center">{{ __('Login') }}</p>
        </div>
        <div class="col-md-6">
            <div class="shadow p-3 mb-5 bg-body rounded">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <p class="w-100 text-center">{{ __('— Or Sign In With —') }}</p>
                        <div class="col d-flex text-center">
                            <a href="#" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><span class="fa fa-facebook-square mr-1"></span> Facebook</a>
                            <a href="#" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><span class="fa fa-twitter-square mr-1"></span> Twitter</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 align-self-center">
            <div class="shadow p-3 mb-5 bg-body rounded">
                <div class="card-body">
                    <p class=" h4 text-secondary align-self-center text-center">{{ __('Do you don\'t have account?') }}</p>
                    @if(config('global.user_register_available', '1'))
                        <a href="{{ route('register') }}" class="btn btn-success col-md-12 my-1" type="submit">{{ __('Register new account') }}</a>
                    @else
                        <button href="#" class="btn btn-success col-md-12 my-1" disabled>{{ __('Register new account') }}</button>
                        <p>{{ __('Register new user is off.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
