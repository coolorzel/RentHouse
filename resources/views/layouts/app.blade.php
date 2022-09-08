<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RentHouse') }} - @yield('title')</title>
    <!-- Style sheet -->

    <link rel="stylesheet" href="{{ asset('project/css/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('project/css/bootstrap-reboot.min.css') }}">
    <link rel="stylesheet" href="{{ asset('project/css/bootstrap-utilities.min.css') }}">
    <link rel="stylesheet" href="{{ asset('project/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('project/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('project/css/sidebars.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <div id="app">


                @include('layouts.elements.navbar')


        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- JAVASCRIPTS-->
    <script src="{{ url('mdb/js/mdb.min.js') }}"></script>
    <script src="{{ url('project/js/bootstrap.js') }}"></script>
    <script src="{{ url('project/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ url('project/js/sidebars.js') }}"></script>
    <script src="{{ url('project/js/changeForm.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ url('project/js/jquery.mask.min.js') }}"></script>
    <!-- tether js -->
    <script src="{{ url('/project/plugins/tether/js/tether.min.js') }}"></script>
    <script src="{{ url('/project/plugins/raty/jquery.raty-fa.js') }}"></script>
    <script src="{{ url('/project/plugins/slick-carousel/slick/slick.min.js') }}"></script>
    <script src="{{ url('/project/plugins/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ url('/project/plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ url('/project/plugins/smoothscroll/SmoothScroll.min.js') }}"></script>
    <!-- google map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
    <script src="{{ url('/project/plugins/google-map/gmap.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>



    <script>
        (function( $ ) {
            $(function() {
                $('.date').mask('00/00/0000');
                $('.time').mask('00:00:00');
                $('.date_time').mask('00/00/0000 00:00:00');
                $('.cep').mask('00000-000');
                $('.zipcode').mask('00-000');
                $('.number').mask('00000');
                $('.phone').mask('000-000-000');
                $('.phone_with_ddd').mask('000-000-000');
                $('.phone_us').mask('(000) 000-0000');
                $('.mixed').mask('AAA 000-S0S');
                $('.ip_address').mask('099.099.099.099');
                $('.percent').mask('##0,00%', {reverse: true});
                $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
                $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
                $('.fallback').mask("00r00r0000", {
                    translation: {
                        'r': {
                            pattern: /[\/]/,
                            fallback: '/'
                        },
                        placeholder: "__/__/____"
                    }
                });

                $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});

                $('.cep_with_callback').mask('00000-000', {onComplete: function(cep) {
                        console.log('Mask is done!:', cep);
                    },
                    onKeyPress: function(cep, event, currentField, options){
                        console.log('An key was pressed!:', cep, ' event: ', event, 'currentField: ', currentField.attr('class'), ' options: ', options);
                    },
                    onInvalid: function(val, e, field, invalid, options){
                        var error = invalid[0];
                        console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
                    }
                });

                $('.crazy_cep').mask('00000-000', {onKeyPress: function(cep, e, field, options){
                        var masks = ['00000-000', '0-00-00-00'];
                        mask = (cep.length>7) ? masks[1] : masks[0];
                        $('.crazy_cep').mask(mask, options);
                    }});

                $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
                $('.cpf').mask('000.000.000-00', {reverse: true});
                $('.money').mask('#.##0,00', {reverse: true});

                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };

                $('.sp_celphones').mask(SPMaskBehavior, spOptions);

                $(".bt-mask-it").click(function(){
                    $(".mask-on-div").mask("000.000.000-00");
                    $(".mask-on-div").fadeOut(500).fadeIn(500)
                })

                $('pre').each(function(i, e) {hljs.highlightBlock(e)});
            });
        })(jQuery);
    </script>
</body>
</html>
