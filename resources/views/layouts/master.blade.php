<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>


    <!-- Styles -->
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/bky.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/themes/corporate.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/themes/earth.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/themes/elegance.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/themes/flat.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/themes/pulse.css') }}" rel="stylesheet">--}}
</head>
<body>
<div id="app">
    <main id="main-container">
        <div id="page-loader" class="show bg-gd-default"></div>
        @yield('content')
    </main>
</div>


</body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5d2b4adebfcb827ab0cbb3c7/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
<script src="{{ mix('js/codebase.app.js') }}"></script>
<script src="{{ mix('js/laravel.app.js') }}"></script>

</html>
