<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    @if(auth()->check()) <meta name="user-id" content="{{ Auth::user()->id }}"> @endif--}}

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/codebase.core.min.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

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
    <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed enable-page-overlay">
        <nav id="sidebar" data-simplebar="init">
            <div class="simplebar-track vertical" style="visibility: visible;">
                <div class="simplebar-scrollbar" style="visibility: visible; top: 0px; height: 514px;"></div>
            </div>
            <div class="simplebar-track horizontal" style="visibility: visible;">
                <div class="simplebar-scrollbar" style="visibility: visible; left: 0px; width: 130px;"></div>
            </div>
            <div class="simplebar-scroll-content" style="padding-right: 15px; margin-bottom: -30px;">
                <div class="simplebar-content" style="padding-bottom: 15px; margin-right: -15px;">
                    <!-- Sidebar Content -->
                    <div class="sidebar-content">
                        <!-- Side Header -->
                        <div class="content-header content-header-fullrow px-15">
                            <!-- Mini Mode -->
                            <div class="content-header-section sidebar-mini-visible-b">
                                <!-- Logo -->
                                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                            </span>
                                <!-- END Logo -->
                            </div>
                            <!-- END Mini Mode -->

                            <!-- Normal Mode -->
                            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                                <!-- Close Sidebar, Visible only on mobile screens -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                                        data-toggle="layout" data-action="sidebar_close">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                                <!-- END Close Sidebar -->

                                <!-- Logo -->
                                <div class="content-header-item">
                                    <a class="font-w700" href="/">
                                           <span>
                                               <img style="width: 70%" src="{{asset('media/logoB.png')}}"
                                                    alt="bluekey_logo">

                                            </span>

                                    </a>
                                </div>
                                <!-- END Logo -->
                            </div>
                            <!-- END Normal Mode -->
                        </div>
                        <!-- END Side Header -->

                        <!-- Side User -->
                        <div class="content-side content-side-full content-side-user px-10 align-parent">
                            <!-- Visible only in mini mode -->
                            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                                <img class="img-avatar img-avatar32" src="{{asset('media/avatars/avatar15.jpg')}}"
                                     alt="">
                            </div>
                            <!-- END Visible only in mini mode -->

                            <!-- Visible only in normal mode -->
                            <div class="sidebar-mini-hidden-b text-center">
                                <router-link class="img-link" to="">
                                    <img class="img-avatar" src="{{asset('media/avatars/avatar15.jpg')}}" alt="">
                                </router-link>
                                <ul class="list-inline mt-10">
                                    <li class="list-inline-item">
                                        <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase"
                                           href="#">{{Auth::user()->username}}</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- END Visible only in normal mode -->
                        </div>
                        <!-- END Side User -->

                        <!-- Side Navigation -->
                        <div class="content-side content-side-full">
                            <ul class="nav-main">
                                <router-link to="/management/dashboard" tag="li">
                                    {{--                                <li>--}}
                                    <a class="active" href="">
                                        <i class="si si-compass"></i>
                                        <span class="sidebar-mini-hide">
                                                Dashboard
                                        </span>
                                    </a>
                                    {{--                                </li>--}}
                                </router-link>
                                @can('isSAF')
                                    <li>
                                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                            <i class="si si-bar-chart"></i>
                                            <span class="sidebar-mini-hide">Transactions</span>
                                        </a>
                                        <ul>
                                            <router-link to="deposits" tag="li">
                                                <a href="javascript:void(0)">Deposits</a>
                                            </router-link>

                                            <router-link to="withdrawals" tag="li">
                                                <a href="javascript:void(0)">Withdrawal History</a>
                                            </router-link>
                                        </ul>
                                    </li>
                                @endcan
                                @can('isSAS')
                                    <router-link to="email" tag="li">
                                        <a class="av-menu" href="javascript:void(0)">
                                            <i class="si si-envelope-letter"></i>
                                            Mail
                                        </a>
                                    </router-link>
                                @endcan

                                <router-link to="users" tag="li">
                                    <a class="av-menu" href="javascript:void(0)">
                                        <i class="si si-users"></i>
                                        Users
                                    </a>
                                </router-link>
                                {{--                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))--}}
                                @can('isSA')
                                    <li>
                                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                            <i class="si si-settings"></i>
                                            <span class="sidebar-mini-hide">Site Management</span>
                                        </a>
                                        <ul>
                                            <router-link to="plans" tag="li">
                                                <a href="javascript:void(0)">Plans</a>
                                            </router-link>

                                            <router-link to="gateways" tag="li">
                                                <a href="">Gateways</a>
                                            </router-link>

                                            <router-link to="administration" tag="li">
                                                <a href="javascript:void(0)">Administration</a>
                                            </router-link>

                                            <router-link to="settings" tag="li">
                                                <a href="javascript:void(0)">Settings</a>
                                            </router-link>
                                        </ul>
                                    </li>
                                @endcan
                                {{--                                @endif--}}
                                <li>
                                    <a class="nav-menu" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="si si-power"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!-- END Side Navigation -->
                    </div>
                    <!-- Sidebar Content -->
                </div>
            </div>
        </nav>
        <!-- END Sidebar -->

        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div class="content-header-section">
                    <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout"
                            data-action="sidebar_toggle">
                        <i class="fa fa-navicon"></i>
                    </button>
                </div>
            </div>
            <div id="page-header-search" class="overlay-header">
                <div class="content-header content-header-fullrow">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-secondary px-15" data-toggle="layout"
                                        data-action="header_search_off">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control" placeholder="Search or hit ESC.."
                                   id="page-header-search-input" name="page-header-search-input">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary px-15">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Header Search -->

            <!-- Header Loader -->
            <div id="page-header-loader" class="overlay-header bg-primary">
                <div class="content-header content-header-fullrow text-center">
                    <div class="content-header-item">
                        <i class="fa fa-sun-o fa-spin text-white"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="content">
                {{--                <div id="page-loader" class="show bg-gd-default"></div>--}}
                @yield('content')
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

        <!-- Footer -->
        <footer id="page-footer" class="opacity-0">
            <div class="content py-20 font-size-xs clearfix">
                <div class="float-right">
                    Developed by <a class="font-w600" href="#" target="_blank">BxtLab</a>
                </div>
                <div class="float-left">
                    <a class="font-w600" href="#" target="_blank">BlueKey</a> &copy; <span
                        class="js-year-copy">2019</span>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
    </div>

</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
<script>
    toastr.options = {
        "progressBar": true,
        "timeout": 2
    };
    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}", {});
    @endif

    @if(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif
</script>

<script src="{{ mix('js/codebase.app.js') }}"></script>
<script src="{{ mix('js/laravel.app.js') }}"></script>
<script src="{{ asset('js/vue-app.js') }}"></script>
</html>
