<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#0061da">
    <meta name="theme-color" content="#1643a3">
    <meta name="google-site-verification" content="pW_9z8rjLjVBk5bXJK9HFG0SXZFXXn_fElFSY5v1_dw" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta property="og:image" content="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}"/>
    <link rel="icon" href="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" />
    <style>
        @font-face {
            font-family: sopher;
            src: url("{{asset('layout/fonts/Philosopher-Regular.ttf')}}");
        }
        body {
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .content {
            background-color: #131313;
            height: 100vh;
            width: 1440px;
        }

        .bg {
            background: url({{asset('layout/images/Group_login.png')}});
            width: 773px;
            height: 515px;
            background-repeat: no-repeat;
            position: absolute;
            bottom: 0;
            z-index: 0;
        }

        .login {
            width: 645px;
            height: 572px;
            /* background: red; */
            z-index: 1;
            border-radius: 44px;
            background: linear-gradient(black, black) padding-box, linear-gradient(128.23deg, #FAF9F7 9.05%, #579DE2 51.94%, #2185A5 94.82%) border-box;
            border: 1px solid transparent;
        }
        input {
            height: 48px;
            border-radius: 8px;
            background: #2E2E2E;
            color: #fff;
            width: calc(100% - 16px);
            border: none;
            outline: none;
            font-size: 18px;
            padding-left: 16px;
        }
        .btn-login {
            width: 100%;
            height: 48px;
            border-radius: 8px;
            border: none;
            font-size: 18px;
            color: #fff;
            background: linear-gradient(130.35deg, #FAF9F7 -2.76%, #2AABE2 53.97%);
            cursor: pointer;
        }
        .has-errors {

        }
        .has-error input {
            border: 1px solid #FF7577;
        }
        .has-error .error {
            color: #FF7577;
            margin: 6px 0 0 16px;
            display: inline-block;
        }
    </style>
</head>

<body>
<div class="content">
    <div class="bg"></div>
    <div style="height: 100vh;display: flex;justify-content: center;align-items: center;">
        <div class="login">

            @if ($errors->has('phone') || $errors->has('password'))
                <div class="alert alert-danger" role="alert" style="font-size: 14px">
                    {{ $errors->first() }}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert" style="font-size: 14px">
                    {{ Session::get('error') }}
                </div>
            @endif
            <form class="card" method="POST" action="{{ url('login') }}">
                @csrf
                <div class="" style="padding: 60px 88px;text-align: center;">
                    <div class="logo">
                        <img src="{{asset('layout/images/Logo_login.png')}}" alt="">
                    </div>
                    <div style="margin-top: 30px;font-family: sopher;font-size: 32px;color: #fff;">
                        Đăng nhập
                    </div>
                    <div class="{{ $errors->has('phone') ? ' has-error' : '' }}" style="margin-top: 30px; text-align: left;">
                        <span style="font-size: 16px;color: #999999;">Số điện thoại</span>
                        <div class="" style="margin-top: 8px;">
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">
                            <span class="error">Số điện thoại không tồn tại</span>
                        </div>
                    </div>
                    <div class="{{ $errors->has('password') ? ' has-error' : '' }}" style="margin-top: 24px; text-align: left;">
                        <span style="font-size: 16px;color: #999999;">Mật khẩu</span>
                        <div class="" style="text-align: left; position: relative;margin-top: 8px;">
                            <input type="password"  name="password" id="exampleInputPassword1" placeholder="Mật khẩu">
                            <img src="{{asset('layout/images/eye_password.png')}}" alt="" style="position: absolute;right: 12px;top: 13px;">
                            <span class="error">Password không đúng</span>
                        </div>
                    </div>
                    <div class="" style="margin-top: 36px;">
                        <button class="btn-login" type="submit">Đăng nhập</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</body>

</html>




{{--<!doctype html>--}}
{{--<html lang="en" dir="ltr">--}}
{{--<head>--}}
    {{--<meta charset="UTF-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta name="msapplication-TileColor" content="#0061da">--}}
    {{--<meta name="theme-color" content="#1643a3">--}}
    {{--<meta name="google-site-verification" content="pW_9z8rjLjVBk5bXJK9HFG0SXZFXXn_fElFSY5v1_dw" />--}}
    {{--<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>--}}
    {{--<meta name="apple-mobile-web-app-capable" content="yes">--}}
    {{--<meta name="mobile-web-app-capable" content="yes">--}}
    {{--<meta name="HandheldFriendly" content="True">--}}
    {{--<meta name="MobileOptimized" content="320">--}}
    {{--<meta property="og:image" content="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}"/>--}}
    {{--<link rel="icon" href="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" type="image/x-icon"/>--}}
    {{--<link rel="shortcut icon" type="image/x-icon" href="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" />--}}

    {{--<!-- Title -->--}}
    {{--<title>{{!empty(setting('title_website'))?setting('title_website'):'Hệ Thống Royal Spa'}}</title>--}}

    {{--<!--Font Awesome-->--}}
    {{--<link href="assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">--}}

    {{--<!-- Font Family -->--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">--}}

    {{--<!-- Custom scroll bar css-->--}}
    {{--<link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />--}}

    {{--<!-- Dashboard Css -->--}}
    {{--<link href="assets/css/dashboard.css" rel="stylesheet" />--}}

    {{--<!-- c3.js Charts Plugin -->--}}
    {{--<link href="assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />--}}

    {{--<!---Font icons-->--}}
    {{--<link href="assets/plugins/iconfonts/plugin.css" rel="stylesheet" />--}}

{{--</head>--}}
{{--<body class="login-img bg-gradient">--}}
{{--<!-- Header Background Animation-->--}}
{{--<div id="particles-js"  class=""></div>--}}
{{--<div class="page">--}}
    {{--<div class="page-single">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col col-login mx-auto">--}}

                    {{--@if ($errors->has('phone') || $errors->has('password'))--}}
                        {{--<div class="alert alert-danger" role="alert" style="font-size: 14px">--}}
                            {{--{{ $errors->first() }}--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    {{--@if(Session::has('error'))--}}
                        {{--<div class="alert alert-danger" role="alert" style="font-size: 14px">--}}
                            {{--{{ Session::get('error') }}--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    {{--<form class="card" method="POST" action="{{ url('login') }}">--}}
                        {{--@csrf--}}
                        {{--<div class="card-body p-6">--}}
                            {{--<img src="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" class="h-6" alt="">--}}

                            {{--<div class="card-title linear-text fs-24 text-center">Đăng nhập vào hệ thống</div>--}}
                            {{--<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">--}}
                                {{--<label class="form-label">Số điện thoại</label>--}}
                                {{--<input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">--}}
                            {{--</div>--}}
                            {{--<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">--}}
                                {{--<label class="form-label">Mật khẩu--}}
                                    {{--<a href="./forgot-password.html" class="float-right small">Quên mật khẩu</a>--}}
                                {{--</label>--}}
                                {{--<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu">--}}
                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="custom-control custom-checkbox">--}}
                                    {{--<input type="checkbox" class="custom-control-input" />--}}
                                    {{--<span class="custom-control-label">Nhớ mật khẩu</span>--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            {{--<div class="form-footer">--}}
                                {{--<button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}


{{--<!-- Dashboard js -->--}}
{{--<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>--}}
{{--<script src="assets/js/vendors/bootstrap.bundle.min.js"></script>--}}
{{--<script src="assets/js/vendors/jquery.sparkline.min.js"></script>--}}
{{--<script src="assets/js/vendors/selectize.min.js"></script>--}}
{{--<script src="assets/js/vendors/jquery.tablesorter.min.js"></script>--}}
{{--<script src="assets/js/vendors/circle-progress.min.js"></script>--}}
{{--<script src="assets/plugins/rating/jquery.rating-stars.js"></script>--}}

{{--<!-- Custom scroll bar Js-->--}}
{{--<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>--}}

{{--<!-- animation -->--}}
{{--<script src="assets/plugins/particles/particles.js"></script>--}}
{{--<script src="assets/plugins/particles/particlesapp_default.js"></script>--}}

{{--<!--Counters -->--}}
{{--<script src="assets/plugins/counters/counterup.min.js"></script>--}}
{{--<script src="assets/plugins/counters/waypoints.min.js"></script>--}}

{{--<!-- custom js -->--}}
{{--<script src="assets/js/custom.js"></script>--}}
{{--<script>--}}
    {{--var colors = new Array(--}}
        {{--[94,114,228],--}}
        {{--[130,94,228],--}}
        {{--[45,206,137],--}}
        {{--[45,206,204],--}}
        {{--[17,205,239],--}}
        {{--[17,113,239],--}}
        {{--[245,54,92],--}}
        {{--[245,96,54]);--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
