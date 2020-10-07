<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#0061da">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="theme-color" content="#1643a3">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{asset('assets/images/brand/logo.png')}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/brand/logo.png')}}"/>

    <!-- Title -->
    <title>Hệ Thống Spa Royal</title>

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <link href="{{asset('assets/plugins/fontawesome-free/css/all.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Font family -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

    <!-- Dashboard Css -->
    <link href="{{asset('assets/css/dashboard.css')}}" rel="stylesheet"/>

    <!-- Custom scroll bar css-->
    <link href="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>

    <!-- Sidemenu Css -->
    <link href="{{asset('assets/plugins/toggle-sidebar/css/sidemenu.css')}}" rel="stylesheet">

    <!-- c3.js Charts Plugin -->
    <link href="{{asset('assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet"/>

    <!---Font icons-->
    <link href="{{asset('assets/plugins/iconfonts/plugin.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css')}}" rel="stylesheet"/>

    <!-- Date Picker Plugin -->
    <link href="{{ asset('assets/plugins/date-picker/spectrum.css') }}" rel="stylesheet"/>
@yield('vuejs')
    <!-- Select2 Plugin -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap.css') }}" rel="stylesheet"/>

    <link href="{{ asset('css/common.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/toggle-switch-custom.css') }}" rel="stylesheet"/>
</head>
