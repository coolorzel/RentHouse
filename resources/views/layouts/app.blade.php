<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RentHouse') }} - @yield('title')</title>
    <!-- Style sheet -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('project/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('project/css/sidebars.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">


                @include('layouts.elements.navbar')


        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- JAVASCRIPTS -->
    <script src="{{ url('project/js/sidebars.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

</body>
</html>
