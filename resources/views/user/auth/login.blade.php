@extends('user.master')
@section('content')
    <div class="container login-screen">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign In to <span class="link-color">{{ config("sales.default_system_name") }}</span></h5>
                        @if ($errors->has('error'))
                            <div class="{{ $errors->has('error') ? ' has-error' : '' }}">
                                <span class="help-block">
                                    <strong>{{ $errors->first('error') }}</strong>
                                </span>
                            </div>
                        @endif
                        <form class="form-signin" action="{{route('user.login')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-label-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
                                <label for="inputEmail">Email address</label>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                            <div class="form-label-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif

                            <div class="custom-control custom-checkbox mb-3 margin-top-10">
                                <input type="checkbox" name="remember_token" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Remember password</label>
                                <label class="pull-right link-color cursor-pointer"><a href="{{route('user.forgot_password')}}">Forgot Password</a></label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>

                        </form>

                        <div class="text-center position-relative full-with height-30">
                            <label class="cursor-pointer position-absolute link-register"><a class="" href="{{route('user.register')}}">Sign Up New Account</a></label>
                            <hr class="my-4">
                        </div>

                        <form class="form-signin" action="{{route('user.oauth-google-login')}}" method="GET">
                            <button class="btn btn-lg btn-google btn-block text-uppercase"><i class="fa fa-google mr-2"></i> Sign in with Google</button>
                        </form>
                        {{--<form class="form-signin margin-top-10" action="{{route('user.oauth-twitter-login')}}" method="GET">--}}
                            {{--<button class="btn btn-lg btn-twitter btn-block text-uppercase"><i class="fa fa-twitter mr-2"></i> Sign in with Twitter</button>--}}
                        {{--</form>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>

    </script>
@endsection
