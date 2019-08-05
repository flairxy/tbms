@extends('layouts.master')

@section('content')
    {{--    <main id="main-container">--}}
    <!-- Page Content -->
    <div class="bg-image" style="background-image: url({{asset('media/photos/slide_2.jpg')}})">
        <div class="row mx-0 bg-black-op">
            <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                <div class="p-30 invisible" data-toggle="appear">
                    <p class="font-size-h3 font-w600 text-white">
                    </p>
                    <p class="font-italic text-white-op">
                        Copyright &copy; <span class="js-year-copy">2019</span>
                    </p>
                </div>
            </div>
            <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white">
                <div class="content content-full">
                    <!-- Header -->
                    <div class="px-30 py-10">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a class="font-w700" href="/">
                            <i class="fa fa-cab"></i>
                            <span class="font-size-xl">UNN</span><span
                                class="font-size-xl text-primary-dark">TBMS</span>
                        </a>
                        <h1 class="h3 font-w700 mt-30 mb-10">Sign In</h1>
{{--                        <h2 class="h5 font-w400 text-muted mb-0">Please sign in</h2>--}}
                    </div>

                    <form class="js-validation-signin px-30" action="{{ route('login') }}" method="POST" id="login">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                           name="email"
                                           id="login-username" value="{{ old('email') }}" autofocus required>
                                    <label for="login-username">Email</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="password" class="form-control" id="login-password" name="password">
                                    <label for="login-password">Password</label>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           {{ old('remember') ? 'checked' : '' }} class="custom-control-input"
                                           id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
                                <i class="si si-login mr-10"></i> Sign In
                            </button>
                            <div class="mt-30">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{'register'}}">
                                    <i class="fa fa-plus mr-5"></i> Create Account
                                </a>
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block"
                                   href="{{ route('password.request') }}">
                                    <i class="fa fa-warning mr-5"></i> Forgot Password
                                </a>
                            </div>
                        </div>
                    </form>
                    <!-- END Sign In Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

    {{--    </main>--}}
@endsection
