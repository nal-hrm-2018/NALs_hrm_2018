<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/templates/css/drop/css/style.css') }} ">
    <!-- Custom Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/templates/css/login/css/custom.css') }} ">
    
    <!-- Custom js -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/templates/js/login/js/custom.js') }} ">

    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/templates/css/bower_components/bootstrap/dist/css/bootstrap.css') }} ">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/templates/css/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/templates/css/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!-- Theme style -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('admin/templates/css/dist/css/AdminLTE.css') }} "> -->
    <!-- iCheck -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/templates/css/plugins/iCheck/square/blue.css') }}">

<!-- login_frontend Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/templates/css/login/css/login.css') }} ">
<!-- Custom Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/templates/css/login/css/reset.css') }} ">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


</head> 
<body class="hold-transition login-page background-black">
@yield('content')
<script>
    var count = 0; // needed for safari
    window.onload = function () {
        if (typeof history.pushState === "function") {
            history.pushState("back", null, null);
            window.onpopstate = function () {
                history.pushState('back', null, null);
                if (count == 1) {
                    location.href = '{{ URL::previous()}}';
                }
            };
        }
    }
    setTimeout(function () {
        count = 1;
    }, 200);
</script>
<!-- jQuery 3 -->
<script src="{{ asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin/templates/js/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
