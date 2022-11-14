@extends('layouts.app')

@section('title', __('My profile'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary active">{{ __('About us') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Contact and about us.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <style>
        .row .left{
            background: #ff9b00;
            padding: 4%;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }
        .row .right{
            background: #ff9b00;
            padding: 4%;
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
        .contact-info{
            margin-top:10%;
        }
        .contact-info img{
            margin-bottom: 15%;
        }
        .contact-info h2{
            margin-bottom: 10%;
        }
        .contact-form label{
            font-weight:600;
        }
    </style>
    <div class="row gutters-sm">
        <div class="col-md-12 p-3 mb-5 bg-body rounded">
            <div class="container contact">
                <div class="row">
                    <div class="col-md-3 left">
                        <div class="contact-info">
                            <i class="fa fa-envelope fa-4x text-white"></i>
                            <h2>{{ __('Contact Us') }}</h2>
                            <h4>{{ __('Write if you need help with any issue!') }}</h4>
                        </div>
                    </div>
                        <div class="col-md-6">
                            <form id="formContactPost" action="{{ route('contactSendMessage') }}" method="POST">
                                @csrf
                                <div class="contact-form">
                                    <div class="form-group">
                                        <label class="control-label col-sm-10" for="fname">{{ __('First Name') }}:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" placeholder="Enter First Name" name="name" @if(Auth::user()) readonly value="{{ Auth::user()->name }}" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-10" for="lname">{{ __('Last Name') }}:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" @if(Auth::user()) readonly value="{{ Auth::user()->lname }}" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-10" for="email">{{ __('Email') }}:</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" @if(Auth::user()) readonly value="{{ Auth::user()->email }}" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-10" for="title">{{ __('Title contacts') }}:</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" id="title" aria-label="{{ __('Select title method contact.') }}" name="title" required>
                                                <option selected>{{ __('Select title method contact.') }}</option>
                                                @foreach($methods as $method)
                                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="control-label col-sm-10" for="comment">{{ __('Comment') }}:</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="5" id="comment" name="message" required></textarea>
                                            <span class="">{{ __('You have') }} <span id="counter"></span> {{ __('characters left') }}.</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-warning">{{ __('Send') }} <i class="fa fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3 text-center right">
                            <ul class="list-unstyled mb-0">
                                <li><i class="fa fa-map-marker fa-3x text-white"></i>
                                    <p>{{ config('global.contact_address', 'Warsaw, 01-597, POLAND') }}</p>
                                </li>

                                <li><i class="fa fa-phone mt-4 fa-3x text-white"></i>
                                    <p>+48 {{ config('global.contact_phone_number', '***-***-***') }}</p>
                                </li>

                                <li><i class="fa fa-envelope mt-4 fa-3x text-white"></i>
                                    <p>{{ config('global.contact_email', 'contact@domain.com') }}</p>
                                </li>
                                <li><i class="fa fa-calendar-times-o fa-3x text-white"></i>
                                    <p>{{ __('Work time') }}: {{ config('global.contact_start_work', '8:00') }} - {{ config('global.contact_end_work', '16:00') }}</p>
                                </li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#formContactPost').on('submit', function(e) {
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
                if(data.status == 0)
                {
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
                }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 6000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Swal.fire(
                             data.title,
                             data.msg,
                             data.type
                        );
                        document.getElementById('formContactPost').reset();
                    }
                },
            error: function (error) {
                $.each(error.responseJSON.errors, function (prefix, val) {
                    Toastify({
                        text: val, // "This is a toast",
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
                });
            }
        });
    });
</script>

    <script>
        window.onload = function(){
            var maxLength = 240;
            var oSpan = document.getElementById('counter');
            oSpan.innerHTML = maxLength +'';
            $('#comment').on('keyup', function(){
                var string = document.getElementById('comment')
                console.log(string.value.length);
                oSpan.innerHTML = (maxLength - ( string.value.length ) ) +'';
                if( maxLength < string.value.length ) {
                    whenBeMaxLength = string.value.substring(0, maxLength);
                    string.value = whenBeMaxLength;
                    oSpan.innerHTML = (maxLength - ( string.value.length ) ) +'';
                }
            });
        }
    </script>
@endsection
