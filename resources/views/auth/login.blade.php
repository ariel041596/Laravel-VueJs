@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    
</body>
</html>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 col-sm-12 ">
            <div class="card">
                <!-- <div class="card-header">{{ __('Login') }}</div> -->
                <div class="row justify-content-center">
                <img  src="/img/Header.png" alt="Asset Management Logo" id="loginlogo">
                </div>
                <div class="card-body mt-2 ml-5">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-lg-3 col-sm-12 col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-lg-8 col-sm-11  col-md-7">
                                <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-lg-3 col-sm-12 col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-lg-8 col-sm-11 col-md-7">
                                <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4 col-md-8 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row ">
                            <div class="col-lg-6 col-sm-11 col-md-12 offset-md-3">
                                <button id="loginbtn" type="submit" class="btn col-md-6">
                                    {{ __('Login') }}
                                </button>

                                <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
