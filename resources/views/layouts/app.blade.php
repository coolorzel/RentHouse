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

    <!-- Dropzone -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">

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


        <!--<main class="py-4">-->
            @yield('content')
        <!--</main>-->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('sweetalert::alert')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')


</body>
</html>
