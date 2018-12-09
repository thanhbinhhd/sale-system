<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('sales.default_system_name')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/user/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/user/css/font-awesome.min.css">
    <link rel="stylesheet" href="/user/css/adminlte.min.css">
    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="/user/css/all.css">--}}
    <link rel="stylesheet" href="{{ mix('user/css/app.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
</head>
<body class="hold-transition">

@yield('content')
@section('script')
    <script src={{ mix('user/js/app.js') }}></script>
    <script src="/user/js/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/user/js/bootstrap.bundle.min.js"></script>
    <!-- iCheck -->
    <script>

    </script>
@show
@yield('footer')
</body>
</html>
