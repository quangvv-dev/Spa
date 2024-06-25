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
<script type="text/javascript" src="{{'js/jquery.toast.min.js'}}"></script>

<script type="module">
    // Import the functions you need from the SDKs you need
    import {initializeApp} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import {getAnalytics} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-analytics.js";
    import {getDatabase, ref, onValue, remove} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

    const firebaseConfig = {
        apiKey: "AIzaSyB1WkOIV-16eKy-t-Hc8_qDvS6AdgHlBqs",
        authDomain: "gtg-beauty.firebaseapp.com",
        databaseURL: "https://gtg-beauty-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "gtg-beauty",
        storageBucket: "gtg-beauty.appspot.com",
        messagingSenderId: "347737486208",
        appId: "1:347737486208:web:ab5edac32d6a5826c18765",
        measurementId: "G-Q6SKBC05GF"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);

    // Lắng nghe sự kiện thay đổi dữ liệu
    const database = getDatabase();
    const chanel = "{{'notification/'.auth()->user()->id.'/'}}";
    const dataRef = ref(database, chanel);
    onValue(dataRef, (snapshot) => {
        const data = snapshot.val();
        Object.entries(data).reverse().forEach(function ([key, value]) {
            let text = value.title + ' <a target="_blank" href="' + value.url + '" >( Click )</a>';
            $.toast({
                text: text, // Text that is to be shown in the toast
                heading: 'HỆ THỐNG', // Optional heading to be shown on the toast
                icon: 'info', // Type of toast icon
                showHideTransition: 'fade', // fade, slide or plain
                allowToastClose: true, // Boolean value true or false
                hideAfter: false, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

                textAlign: 'left',  // Text alignment i.e. left, right or center
                loader: true,  // Whether to show loader or not. True by default
                afterHidden: function () {
                    remove(ref(database, chanel + key))
                        .then(() => {
                            console.log("Bản ghi đã được xóa thành công.");
                        })
                        .catch((error) => {
                            console.error("Xảy ra lỗi khi xóa bản ghi:", error);
                        });
                }
            });
        });

    });
</script>

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
