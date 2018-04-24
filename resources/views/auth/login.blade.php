@extends('layouts.app')

@section('content')
    <script>
        document.getElementById('email').title = "";
    </script>
    <div class="login-box">
        <div class="login-logo">
            <img class="image-logon" src="{!! asset('admin/templates/images/login/images/logo/logo.jpg') !!}"
                 alt="User Image">
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"></p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group has-feedback">
                    <input id="email"
                           type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="{{ trans('auth.placeholder_email') }}"
                           autofocus
                    />

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                                        <strong class="invalid-login">{{ $errors->first('email') }}</strong>
                                    </span>

                    @endif
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           placeholder="{{ trans('auth.placeholder_password') }}"
                           name="password">

                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                                        <strong class="invalid-login">{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"
                                       name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="row">
                <div class="col-md-8">
                    @if (Session::has('message'))
                        <div class="alert alert-warning warning-login-register">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.social-auth-links -->
        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
