<!doctype html>
<html lang="en" dir="ltr">
@include('layout.assets_head')
@yield('_style')
<link href="{{ asset('css/menu-left.css') }}" rel="stylesheet"/>
<!-- Alertify -->
<link href="{{ asset('assets/plugins/alertify/alertify.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<body class="app">
<style>
    .right {
        float: right;
    }

    .pad {
        margin-left: 1%;
    }

    .bot {
        margin-bottom: 2%;
    }

    label {
        font-weight: 600;
    }

    thead > tr th {
        background: #3b8fec;
        color: #fff;
    }

    tr th, td {
        background: #fff;
        border-right: 1px solid #e7effc !important;
        border-left: 1px solid #e7effc !important;
        border-bottom: 1px solid #e7effc !important;
    }

    label.required:after {
        content: " *";
        color: red;
    }

    .datepicker-panel > ul > li.picked, .datepicker-panel > ul > li.picked:hover {
        color: #fff;
        font-weight: bold;
        background-color: black;

    }

    .datepicker-panel > ul > li.highlighted {
        background-color: rgb(99 177 255);
        font-weight: bold;
        color: #fff;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    }

    tr td {
        font-size: 14px;
        font-weight: 300;
        font-family: 'Poppins', sans-serif;
    }

    .tooltip-nav .tooltiptext {
        visibility: hidden;
        min-width: 130px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        font-size: 12px;
        font-weight: 400;
        position: absolute;
        z-index: 1;
        top: -27px;
        left: -9px;
    }

    .tooltip-nav:hover .tooltiptext {
        visibility: visible;
        font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    }

    .modal-footer {
        background: #f7f8f9;
    }

    .modal-header {
        background: #0fa2e8;
    }

    .modal-header h2,.modal-header h3,.modal-header h4,.modal-header h5,.modal-header button {
        color: #fff !important;
    }
    .small-tip {
        font-size: 11px;
        color: #999;
    }
    a{
        cursor: pointer;
    }
</style>
<div id="global-loader">
    <div class="showbox">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
@php
    $permissions = setting('permissions');
    $roleGlobal = auth()->user()?:[];
@endphp
<div class="page">
    <div class="page-main">
        <!-- Navbar-->
    @include('menu.navbar')
    <!-- Horizantal menu-->
    @include('menu.horizantal')
    <!-- Menu left-->
    @include('menu.menu_left')
    <!-- Horizantal menu-->
        <div class="container content-custom">
            <div class="side-app">
                <div class="page-header">

                </div>
                <div class="row row-cards">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="page-title-box">
                                <h4 class="page-title float-left">@yield('title')</h4>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        @if(Session::has('status'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>{{ Session::get('status') }}</strong>
                                @php
                                    Session::forget('status');
                                @endphp
                            </div>
                        @elseif(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>{{ Session::get('error') }}</strong>
                                @php
                                    Session::forget('error');
                                @endphp
                            </div>
                        @endif
                    </div>
                    @yield('content')
                </div>
            </div>
            <!--footer-->
        </div>
        <!--footer-->
    @include('layout.footer')
    <!-- End Footer-->
    </div>
</div>

<!-- Back to top -->
<a href="#top" id="back-to-top" style="display: inline;"><i class="fas fa-angle-up"></i></a>
@include('layout.assets_script')
@yield('_script')
</body>
</html>
