@extends('layouts.master')

@section('content')
    <div id="page-container"
         class="sidebar-inverse side-scroll page-header-fixed page-header-glass page-header-inverse main-content-boxed enable-page-overlay">
        <!-- Sidebar -->
        <nav id="sidebar">
            <!-- Sidebar Content -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="content-header content-header-fullrow">
                    <div class="content-header-section text-center align-parent">
                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                                data-toggle="layout" data-action="sidebar_close">
                        </button>
                        <!-- END Close Sidebar -->

                        <!-- Logo -->
                        <div class="content-header-item">
                            <a class="link-effect font-w700" href="">
                                <i class="fa fa-cab"></i>
                                <span class="font-size-xl">UNN</span><span class="font-size-xl text-white">TBMS</span>
                            </a>
                        </div>
                        <!-- END Logo -->
                    </div>
                </div>
                <!-- END Side Header -->

                <!-- Side Main Navigation -->
                <div class="content-side content-side-full">
                    <!--
                        Mobile navigation, desktop navigation can be found in #page-header

                        If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                        -->
                    <ul class="nav-main">
                        <li>
                            <a class="active" href="/">
                                <i class="si si-home"></i>Home
                            </a>
                        </li>
                        @guest
                            <li><a href="/login">
                                    <i class="si si-login"></i>
                                    Login</a>
                            </li>
                            <li><a href="/register">
                                    <i class="si si-logout"></i>
                                    Register</a>
                            </li>
                        @else
{{--                            @if(\Illuminate\Support\Facades\Auth::user()->role === '2')--}}
{{--                                <router-link tag="li" to="/driver/dashboard">--}}
{{--                                    <i class="si si-logout"></i>--}}
{{--                                    Dashboard--}}
{{--                                </router-link>--}}
{{--                            @elseif(\Illuminate\Support\Facades\Auth::user()->role === '0'))--}}
{{--                                <router-link tag="li" to="/user/dashboard">--}}
{{--                                    <i class="si si-logout"></i>--}}
{{--                                    Dashboard--}}
{{--                                </router-link>--}}

{{--                            @endif--}}
                            <li>
                                <a class="nav-menu" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power bky-color"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest

                    </ul>
                </div>
                <!-- END Side Main Navigation -->
            </div>
            <!-- Sidebar Content -->
        </nav>
        <!-- END Sidebar -->

        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div class="content-header-section">
                    <!-- Logo -->
                    <div class="content-header-item">
                        <a class="link-effect font-w700 mr-5" href="">
                            <i class="fa fa-cab text-white"></i>
                            <span class="font-size-xl text-primary">UNN</span><span
                                class="font-size-xl text-white">TBMS</span>
                        </a>
                    </div>
                    <!-- END Logo -->
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div class="content-header-section">
                    <!-- Header Navigation -->
                    <!--
                        Desktop Navigation, mobile navigation can be found in #sidebar

                        If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                        If your sidebar menu includes headings, they won't be visible in your header navigation by default
                        If your sidebar menu includes icons and you would like to hide them, you can add the class 'nav-main-header-no-icons'
                        -->
                    <ul class="nav-main-header nav-main-header-no-icons">
                        <li>
                            <a class="active" href="">
                                <i class="si si-home"></i>Home
                            </a>
                        </li>
                        @guest
                            <li class="nav-main-header nav-main-header-no-icons"><a href="/login">Login</a></li>
                        @else
                            <a class="nav-menu" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-power bky-color"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </ul>

                    <!-- Toggle Sidebar -->
                    <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                    <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout"
                            data-action="sidebar_toggle">
                        <i class="fa fa-navicon"></i>
                    </button>
                    <!-- END Toggle Sidebar -->
                </div>
                <!-- END Right Section -->
            </div>
            <!-- END Header Content -->

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
            <!-- Hero -->
            <div class="bg-gd-primary overflow-hidden">
                <div class="hero bg-black-op-25">
                    <div class="hero-inner">
                        <div class="content content-full text-center">
                            <h1 class="display-3 font-w700 text-white mb-10 invisible" data-toggle="appear"
                                data-class="animated fadeInDown">UNN Taxi-Bus Management System</h1>
                            <h2 class="font-w400 text-white-op mb-50 invisible" data-toggle="appear"
                                data-class="animated fadeInDown"></h2>
                            @guest
                                <a class="btn btn-hero btn-noborder btn-rounded btn-success mr-5 mb-10 invisible"
                                   data-toggle="appear" data-class="animated fadeInUp" href="{{route('register')}}">
                                    <i class="fa fa-user mr-10"></i> Join as a rider
                                </a>
                                <a class="btn btn-hero btn-noborder btn-rounded btn-primary mb-10 invisible"
                                   data-toggle="appear" data-class="animated fadeInUp" href="{{route('driverReg')}}">
                                    <i class="fa fa-cab mr-10"></i> Join as a driver

                                </a>
                            @else
                                <a class="btn btn-hero btn-noborder btn-rounded btn-primary mb-10 invisible"
                                   data-toggle="appear" data-class="animated fadeInUp" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power bky-color"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
