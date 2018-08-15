 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

@extends('layouts.app')
@section('content')
<div class="con background-login">
    <header>
        <a href="#"><img src="{!! asset('admin/templates/images/login/images/logo-header.png') !!}"
                 alt="User Image"></a>
    </header>
    <div class="mg-top-90">
        <div class="content">
             
                <a href="#"><img class="logo-nal" src="{!! asset('admin/templates/images/login/images/logo-nal.png') !!}"
                         alt="User Image"></a>
                <!-- /.login-logo -->
                <form class="form-login" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group has-feedback">
                        <input id="email" type="email" 
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ trans('auth.placeholder_email') }}"
                                   autofocus
                            />
                    </div>
                    <div class="form-group has-feedback">
                        <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   placeholder="{{ trans('auth.placeholder_password') }}"
                                   name="password">
                    </div>
                    <div class="">
                        @if(session()->has('msg_fail')||$errors->has('password')||$errors->has('email'))
                            <div>
                                <ul class='error_msg'>
                                    <li>{{trans('auth.failed')}}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    {{--<a href="#" class="forget-pass">Foget your password</a><br><br><br>--}}

                    <div class="checkbox icheck" style="position: absolute;">
                        <label>
                            <input type="checkbox"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                        </label>
                    </div>
                    <br><br><br>
                    <button type="submit" class="btn btn-dark button-login">{{ __('Login') }}</button>
                </form>
                <!-- /.social-auth-links -->

            </div>

    </div>
</div>
@endsection
