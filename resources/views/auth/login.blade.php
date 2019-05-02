<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#0061da">
    <meta name="theme-color" content="#1643a3">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <!-- Title -->
    <title>Hệ Thống Spa Linh anh, chuyên nghiệp, uy tín...</title>

    <!--Font Awesome-->
    <link href="assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">

    <!-- Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

    <!-- Custom scroll bar css-->
    <link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!-- Dashboard Css -->
    <link href="assets/css/dashboard.css" rel="stylesheet" />

    <!-- c3.js Charts Plugin -->
    <link href="assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

    <!---Font icons-->
    <link href="assets/plugins/iconfonts/plugin.css" rel="stylesheet" />

</head>
<body class="login-img bg-gradient">
<!-- Header Background Animation-->
<div id="particles-js"  class=""></div>
<div id="global-loader" ><div class="showbox"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div></div>
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto">
{{--                    <div class="text-center mb-6 ">--}}
{{--                        <img src="assets/images/brand/logo_login.png" class="h-6" alt="">--}}
{{--                    </div>--}}
                    @if ($errors->has('phone') || $errors->has('password'))
                        <div class="alert alert-danger" role="alert" style="font-size: 14px">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form class="card" method="POST" action="{{ url('login') }}">
                        {{ csrf_field() }}
                        <div class="card-body p-6">
                            <img src="assets/images/brand/logo_login.png" class="h-6" alt="">

                            <div class="card-title text-center">Đăng nhập vào hệ thống</div>
                            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">
                            </div>
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="form-label">Mật khẩu
                                    {{--<a href="./forgot-password.html" class="float-right small">Quên mật khẩu</a>--}}
                                </label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" />
                                    <span class="custom-control-label">Nhớ mật khẩu</span>
                                </label>
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Dashboard js -->
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="assets/js/vendors/selectize.min.js"></script>
<script src="assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="assets/js/vendors/circle-progress.min.js"></script>
<script src="assets/plugins/rating/jquery.rating-stars.js"></script>

<!-- Custom scroll bar Js-->
<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- animation -->
<script src="assets/plugins/particles/particles.js"></script>
<script src="assets/plugins/particles/particlesapp_default.js"></script>

<!--Counters -->
<script src="assets/plugins/counters/counterup.min.js"></script>
<script src="assets/plugins/counters/waypoints.min.js"></script>

<!-- custom js -->
<script src="assets/js/custom.js"></script>
<script>
    var colors = new Array(
        [94,114,228],
        [130,94,228],
        [45,206,137],
        [45,206,204],
        [17,205,239],
        [17,113,239],
        [245,54,92],
        [245,96,54]);
</script>
</body>
</html>
