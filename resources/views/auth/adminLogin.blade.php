@extends('layouts.admin_login')

@section('content')
    <div class="animate form login_form">
        <section class="login_content">
            <form method="POST" action="{{ route('admin-login') }}">
                @csrf
                <h1>Admin Login</h1>
                <div>
                    <input @if ($errors->has('email')) style="margin-bottom: 10px !important;" @endif id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <p style="text-align: left !important; color: red; margin-bottom: 10px !important;">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
                <div>
                    <input @if ($errors->has('email')) style="margin-bottom: 10px !important;" @endif id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <p style="text-align: left !important; color: red;">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                    {{--<a class="reset_pass" href="#">Lost your password?</a>--}}
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    {{--<p class="change_link">New to site?
                        <a href="#signup" class="to_register"> Create Account </a>
                    </p>--}}

                    <div class="clearfix"></div>
                    <br />

                    <div>
                        <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                        <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                    </div>
                </div>
            </form>
        </section>
    </div>

    {{--<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin {{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin-login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
@endsection