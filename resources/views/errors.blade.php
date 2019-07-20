<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{--    <script src="{{ asset('js/app.js') }}"></script>--}}
    {{--    <script src="{{ asset('js/codebase.app.js') }}"></script>--}}
    <script src="{{ asset('js/laravel.app.js') }}"></script>
    <script src="{{ asset('js/codebase.core.min.js') }}"></script>
    <script src="{{ asset('js/codebase.app.min.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/bky.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/corporate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/earth.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/elegance.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/flat.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/pulse.css') }}" rel="stylesheet">
</head>
<body>
<div id="page-container" class="main-content-boxed side-trans-enabled">

    <!-- Main Container -->
    <main id="main-container" style="min-height: 669px;">

        <!-- Page Content -->
        <div class="hero bg-white">
            <div class="hero-inner">
                <div class="content content-full">
                    <div class="py-30 text-center">
                        <div class="display-3 text-danger">
                            <i class="fa fa-warning"></i> 404
                        </div>
                        <h1 class="h2 font-w700 mt-30 mb-10">Oops.. You just found an error page..</h1>
                        <h2 class="h3 font-w400 text-muted mb-50">We are sorry but the page you are looking for was not found..</h2>
                        <a class="btn btn-hero btn-rounded btn-alt-secondary" href="be_pages_error_all.html">
                            <i class="fa fa-arrow-left mr-10"></i> Back to all Errors
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>
</body>
</html>
