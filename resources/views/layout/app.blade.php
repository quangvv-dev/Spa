<!doctype html>
<html lang="en" dir="ltr">
@include('layout.assets_head')
@yield('_style')

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
<div class="page">
    <div class="page-main">
        <!-- Navbar-->
    @include('menu.navbar')
    <!-- Horizantal menu-->
    @include('menu.horizantal')
    <!-- Horizantal menu-->
        <div class="container content-custom">
            <div class="side-app">
                <div class="page-header">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard 01</li>
                    </ol>
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
                    <div class="row">
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
