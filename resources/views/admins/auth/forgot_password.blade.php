@extends('admin.auth.master')

<!-- Main Content -->
@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a>HapoJC</a>
        </div>
        <div class="register-box-body">
            <p class="login-box-msg">Đăng ký tài khoản</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form role="form" method="POST" action="{{ route('admin.email') }}">
                {{ csrf_field() }}
                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="text" name="email" title="Email"
                           class="form-control" placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            Khôi phục mật khẩu
                        </button>
                    </div>
                </div>
            </form>
            <div class="margin-top-50 text-center">
                <a href="{{ route('admin.login') }}">Quay lại trang đăng nhập</a>
            </div>
        </div>
    </div>
@endsection
