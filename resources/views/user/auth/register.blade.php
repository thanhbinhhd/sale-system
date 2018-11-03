@extends('user.master')
@section('content')
    <div class="container login-screen">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign Up to <span class="link-color">{{ config("sales.default_system_name") }}</span></h5>
                        @if ($errors->has('error'))
                            <div class="{{ $errors->has('error') ? ' has-error' : '' }}">
                                <span class="help-block">
                                    <strong>{{ $errors->first('error') }}</strong>
                                </span>
                            </div>
                        @endif
                        <form class="form-signin" action="{{route('user.register')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-label-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <input type="text" id="inputName" name="name" class="form-control" placeholder="Your Name" required autofocus>
                                <label for="inputName">Your Name</label>
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                            <div class="form-label-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" id="inputEmailRegister" name="email" class="form-control" placeholder="Email address" required>
                                <label for="inputEmailRegister">Email address</label>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                            <div class="form-label-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" id="inputPasswordRegister" name="password" class="form-control" placeholder="Password" required>
                                <label for="inputPasswordRegister">Password</label>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif

                            <div class="form-label-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input type="password" id="inputConfirmPassword" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                                <label for="inputConfirmPassword">Confirm Password</label>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif


                            <button class="btn btn-lg btn-primary btn-block text-uppercase margin-top-10" type="submit">Sign Up</button>

                        </form>

                        <form class="form-signin margin-top-10" action="{{route('user.oauth-google-login')}}" method="GET">
                            <button class="btn btn-lg btn-google btn-block text-uppercase"><i class="fa fa-google mr-2"></i> Sign up with Google</button>
                        </form>
                        <form class="form-signin margin-top-10" action="{{route('user.oauth-facebook-login')}}" method="GET">
                            <button class="btn btn-lg btn-facebook btn-block text-uppercase"><i class="fa fa-facebook-f mr-2"></i> Sign up with Facebook</button>
                        </form>

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
