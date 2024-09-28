<!doctype html>
<html lang="en" dir="ltr">
@include('layout.assets_head')
@yield('_style')
<link href="{{ asset('css/menu-left.css') }}" rel="stylesheet"/>

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
    }
    tr th,td {
        background: #fff;
        border-right: 1px solid #e7effc !important;
        border-left: 1px solid #e7effc !important;
        border-bottom: 1px solid #e7effc !important;
    }
    label.required:after {
        content: " *";
        color: red;
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
{{--                    <div class="row">--}}
{{--                        <div class="col-xl-12">--}}
{{--                            <div class="page-title-box">--}}
{{--                                <h4 class="page-title float-left">@yield('title')</h4>--}}
{{--                                <div class="clearfix"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div>--}}
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
{{--                    </div>--}}
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
{{--@include('layout.assets_script')--}}
{{--Script--}}
<!-- Dashboard Core -->
<script src="{{asset('assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/selectize.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.tablesorter.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/circle-progress.min.js')}}"></script>
<script src="{{asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-clockpicker.min.js')}}"></script>

<!-- Side menu js -->
<script src="{{asset('assets/plugins/toggle-sidebar/js/sidemenu.js')}}"></script>

<!-- Custom scroll bar Js-->
<script src="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<!-- c3.js Charts Plugin -->
<script src="{{asset('./assets/plugins/charts-c3/d3.v5.min.js')}}"></script>
<script src="{{asset('./assets/plugins/charts-c3/c3-chart.js')}}"></script>

<!-- Input Mask Plugin -->
<script src="{{asset('assets/plugins/input-mask/jquery.mask.min.js')}}"></script>

<!-- Index Scripts -->
<script src="{{asset('assets/js/index.js')}}"></script>
<script src="{{asset('assets/js/jquery.number.min.js')}}"></script>

<!-- Animation -->
<script src="{{asset('assets/plugins/particles/particles.js')}}"></script>
<script src="{{asset('assets/plugins/particles/particlesapp_default.js')}}"></script>

<!--Counters -->
<script src="{{asset('assets/plugins/counters/counterup.min.js')}}"></script>
<script src="{{asset('assets/plugins/counters/waypoints.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>

<!-- jQuery Validation -->
<script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/js/additional-methods.min.js')}}"></script>

<!-- Datepicker js -->
<script src="{{ asset('assets/plugins/date-picker/spectrum.js') }}"></script>
<script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>

<!-- Select2 js -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Custom js -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- User js -->

<script src="{{asset('js/user.js')}}"></script>
<script src="{{asset('js/datepicker.js')}}"></script>
<script src="{{asset('assets/js/tableHeadFixer.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // validate error
    $.validator.setDefaults({
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('span'));
            } else if (element.hasClass('upload')) {
                error.insertAfter(element.closest('.fileupload'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    // validate form
    $('#fvalidate').submit(function () {
        $(this).validate();
    })

    $(document).ready(function () {

        // $('.header-search').change(function () {
        //     $('form.card-header').trigger();
        // })
        // close alert
        window.setTimeout(function () {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function () {
                $(this).remove();
            });
        }, 2000);

        // colspan td
        $('.merge-col').attr('colspan', $('.table th').length);

        // select 2
        // $('.select2').select2({
        //     width: '100%',
        //     theme: 'bootstrap',
        //     allowClear: true,
        //     placeholder: function () {
        //         $(this).data('placeholder');
        //     }
        // });

        $('.select2-hidden-accessible').on('change', function () {
            $(this).valid();
        });
        // $('.clockpicker').clockpicker();

    })
</script>
@include('layout._script')

{{--End script--}}
@yield('_script')
</body>
</html>
