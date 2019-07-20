@extends('layouts.master')

@section('content')
    <div class="bg-image" style="background-image: url({{asset('media/photos/photo34@2x.jpg')}});">
        <div class="row mx-0 bg-earth-op">
            <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                <div class="p-30 invisible" data-toggle="appear">
                    <p class="font-size-h3 font-w600 text-white mb-5">
                        We're very happy you are joining our community!
                    </p>
                    <p class="font-size-h5 text-white">
                        <i class="fa fa-angles-right"></i> Create your account today and receive 50% off.
                    </p>
                    <p class="font-italic text-white-op">
                        Copyright &copy; <span class="js-year-copy">2017</span>
                    </p>
                </div>
            </div>
            <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white">
                <div class="content content-full">
                    <!-- Header -->
                    <div class="px-30 py-10">
                        <a class="link-effect font-w700" href="/">
                            <i class="si si-fire"></i>
                            <span class="font-size-xl text-primary-dark">Blue</span><span
                                class="font-size-xl">key</span>
                        </a>
                        <h1 class="h3 font-w700 mt-30 mb-10">Create New Account</h1>
                        <h2 class="h5 font-w400 text-muted mb-0">Please add your details</h2>
                    </div>
                    <form class="js-validation-signup px-30" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        @if($reflink)
                            <input name="reflink" type="hidden" value="{{$reflink}}">
                        @else
                            <input name="reflink" type="hidden" value="null">
                        @endif
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                           id="signup-username" name="username" required>
                                    <label for="signup-username">Username</label>
                                    @error('username')
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
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="signup-email" name="email" required>
                                    <label for="signup-email">Email</label>
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
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="signup-password" name="password" required>
                                    <label for="signup-password">Password</label>
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
                                <div class="form-material floating">
                                    <input type="password" class="form-control" id="signup-password-confirm"
                                           name="password_confirmation" required>
                                    <label for="signup-password-confirm">Password Confirmation</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-hero btn-alt-success">
                                <i class="fa fa-plus mr-10"></i> Register
                            </button>
                            <div class="mt-30">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{'login'}}">
                                    <i class="fa fa-user text-muted mr-5"></i> Login
                                </a>
                            </div>
                        </div>
                    </form>
                    <!-- END Sign Up Form -->
                </div>
            </div>
        </div>
    </div>

@endsection
