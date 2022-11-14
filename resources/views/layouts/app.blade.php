<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('global.page_name', 'RentHouse') }} - @yield('title')</title>
    <!-- Style sheet -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('project/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.37/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Dropzone -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('project/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('project/css/sidebars.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>

    </style>

</head>
<body>
    <div id="app">


                @include('layouts.elements.navbar')


        <div class="container">
            @role('user')
            <div class="alert alert-primary" role="alert">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 text-center col align-self-center">
                            <i class="align-middle fa fa-info fa-3x"></i>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-8 col-sm-12">
                                    @if(isset(Auth::user()->email_verified_at))
                                        <span class="badge rounded-pill text-bg-success"><i class="text-white fa fa-check"></i></span>
                                        {{ __('Verification of the e-mail address has been completed') }}.
                                        @else
                                        <span class="badge rounded-pill text-bg-danger"><i class="text-white fa fa-times"></i></span>
                                    {{ __('Verification has not been carried out. If you do not have the verification email in your mailbox, please resend it ...') }}
                                        <strong><a href="{{ route('verification.notice') }}"><i class="fa fa-arrow-right"></i>{{ __('THERE') }}<i class="fa fa-arrow-left"></i></a></strong>
                                        @endif
                                </div>
                                <div class="col-4 col-sm-12">
                                    <span class="badge rounded-pill text-bg-danger"><i class="text-white fa fa-times"></i></span>
                                    {{ (__('Choose if your account will be used for letting or if you are the owner of the property you want to rent. If you are a landlord, please complete the verification form.')) }}
                                    <strong><a href="{{ route('myBillingVerificationForm') }}"><i class="fa fa-arrow-right"></i>{{ __('THERE') }}<i class="fa fa-arrow-left"></i></a></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endrole
            <div class="main-body">

                    @yield('menu')

        <!--<main class="py-4">-->
            @yield('content')
        <!--</main>-->
            </div>
        </div>
    </div>
    <!-- JAVASCRIPTS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ url('project/js/jquery.mask.min.js') }}"></script>
    <script src="{{ url('mdb/js/mdb.min.js') }}"></script>
    <script src="{{ url('project/js/maskform.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <script src="{{ url('project/js/sidebars.js') }}"></script>
    <script src="{{ url('project/js/changeForm.js') }}"></script>
    <script src="{{ url('project/simple-datatables/simple-datatables.js') }}"></script>
    <!-- tether js -->
    <script src="{{ url('/project/plugins/tether/js/tether.min.js') }}"></script>
    <script src="{{ url('/project/plugins/slick-carousel/slick/slick.min.js') }}"></script>
    <script src="{{ url('/project/plugins/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ url('/project/plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
    <!-- sweet alert -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('sweetalert::alert')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            $('#notificationList li div').on('click', function (e) {
                e.preventDefault()
                var change = $("li").find('[data-info="'+ $(this).data('info') +'"]');
                $.ajax({
                    url:$(this).data('route'),
                    method:'POST',
                    data: {data: $(this).data('info')},
                    dataType:'json',
                    success:
                        function(data) {
                                if(data.data === true){
                                    change.removeClass('fw-bold');
                                }else{
                                    change.addClass('fw-bold');
                                }
                                $('#countNotification').text(data.countNotification);
                                if(data.countNotification > 0) {
                                    $('#iconNotification').addClass('text-warning');
                                }else {
                                    $('#iconNotification').removeClass('text-warning');
                                }
                            Toastify({
                                    text: data.message, // "This is a toast",
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
                            /*} else {
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
                            }*/
                        }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
