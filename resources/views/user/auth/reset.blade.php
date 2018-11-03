@extends('user.master')

@section('content')

    <div class="register-box">
        <div class="register-logo">
            <a>{{config("sales.default_system_name")}}</a>
        </div>
        <div class="register-box-body">
            <p class="login-box-msg">Reset Password</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form role="form" method="POST" action="{{ route('user.reset') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input name="email" title="Email"
                           class="form-control" placeholder="Email" type="email" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">

                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </div>
                </div>
            </form>
            <div class="margin-top-50 text-center">
                <a href="{{ route('user.login') }}">Back to login screen</a>
            </div>
        </div>
    </div>
@endsection