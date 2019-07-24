@extends('layouts.master')

@section('content')
    <div class="bg-image" style="background-image: url({{asset('media/photos/photo34@2x.jpg')}});">
        <div class="row mx-0 bg-default-op">
            <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                <div class="p-30 invisible" data-toggle="appear">
                    <p class="font-size-h3 font-w600 text-white">
                        You are awesome! Build something amazing!
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
                            <img src="{{asset('media/logoB.png')}}" alt="bluekey_logo">
                        </a>
                        <h1 class="h3 font-w700 mt-30 mb-10">Don’t worry, we’ve got your back</h1>
                        <h2 class="h5 font-w400 text-muted mb-0">Please enter your username or email</h2>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="js-validation-reminder px-30" action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                           id="reminder-credential" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    <label for="reminder-credential">Email</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
                                <i class="fa fa-asterisk mr-10"></i> Send Password Reset Link
                            </button>
                            <div class="mt-30">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{route('login')}}">
                                    <i class="fa fa-user text-muted mr-5"></i> Sign In
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
