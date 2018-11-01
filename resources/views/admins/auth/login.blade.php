@extends('admin.auth.master')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin HapoJC</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Đăng nhập</p>
            @if ($errors->has('error'))
                <div class="{{ $errors->has('error') ? ' has-error' : '' }}">
                <span class="help-block">
                                    <strong>{{ $errors->first('error') }}</strong>
                                </span>
                </div>
            @endif
            <form action="{{route('admin.post-login')}}" method="POST">
                {{csrf_field()}}
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember_token"> Ghi nhớ
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->

            <a href="{{route('admin.forgot_password')}}">Quên mật khẩu</a><br>

        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
@section('footer')
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
@endsection
