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

<!-- Alert -->
<script src="{{ asset('assets/plugins/alertify/alertify.min.js') }}"></script>

<!-- Select2 js -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Custom js -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- User js -->



<script src="{{asset('js/user.js')}}"></script>
<script src="{{asset('js/datepicker.js')}}"></script>
<script src="{{asset('assets/js/tableHeadFixer.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableToExcel.js')}}"></script>


{{--<script type="module">--}}
    {{--// Import the functions you need from the SDKs you need--}}
    {{--import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.0/firebase-app.js";--}}
    {{--import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.0/firebase-analytics.js";--}}
    {{--// TODO: Add SDKs for Firebase products that you want to use--}}
    {{--// https://firebase.google.com/docs/web/setup#available-libraries--}}

    {{--// Your web app's Firebase configuration--}}
    {{--// For Firebase JS SDK v7.20.0 and later, measurementId is optional--}}
    {{--const firebaseConfig = {--}}
        {{--apiKey: "AIzaSyDObsXEJVbvmu5RRjCqMPaWHyFIfsh8NDU",--}}
        {{--authDomain: "spa-super-app.firebaseapp.com",--}}
        {{--projectId: "spa-super-app",--}}
        {{--storageBucket: "spa-super-app.appspot.com",--}}
        {{--messagingSenderId: "74887372305",--}}
        {{--appId: "1:74887372305:web:eb5e7aff120194ba831bb0",--}}
        {{--measurementId: "${config.measurementId}"--}}
    {{--};--}}
    {{--const server_key = "AIzaSyDObsXEJVbvmu5RRjCqMPaWHyFIfsh8NDU";--}}

    {{--// Initialize Firebase--}}
    {{--const app = initializeApp(firebaseConfig);--}}
    {{--const analytics = getAnalytics(app);--}}

{{--</script>--}}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.excel-html').on('click', function () {

        let today = new Date().toISOString().slice(0, 10);
        TableToExcel.convert(document.getElementById("table-excel"), {
            name: "Excel-AdamBeauty-" + today + ".xlsx",
            sheet: {
                name: "Sheet 1"
            }
        });
    })

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
        $('.select2').select2({
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
            placeholder: function () {
                $(this).data('placeholder');
            }
        });

        $('.select2-hidden-accessible').on('change', function () {
            $(this).valid();
        });
        $('.clockpicker').clockpicker();

    })
    $(document).on('click', '.other_time', function () {
        $(".other_time_panel").css({'display': ''});
    });

    $(document).on('click', '.cancel_other_time', function () {
        $(".other_time_panel").css({'display': 'none'});
    });
</script>
@include('layout._script')
