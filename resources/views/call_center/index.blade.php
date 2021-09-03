@extends('layout.app')
@php
    $checkRole = checkRoleAlready();
@endphp
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/progres-bar.css') }}" rel="stylesheet"/>
    <style>
        select#order_type {
            background: #dddddd;
        }

        .tableFixHead {
            overflow-y: auto;
            height: 800px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
        }

        .tableFixHead tbody .fixed td {
            position: sticky;
            bottom: 0;
        }

        .tableFixHead tbody .fixed2 td {
            position: sticky;
            bottom: 46px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background: #0062cc;
        }

        .tableFixHead tbody .fixed td {
            background: #3b8fec;
        }

        .tableFixHead tbody .fixed2 td {
            background: #3b8fec;
        }

        .form-control {
            font-size: 14px;
        }

        @media only screen and (max-width: 1921px) {
            .table-responsive {
                max-height: 70vh;
            }
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col">
                </div>
            </div>
            <div class="card-header">
                <div class="col-md-2">
                    {!! Form::select('caller_number', $telesales, null, array('class' => 'form-control','id'=>'telesales', 'placeholder'=>'Nhân viên')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('call_status', ['ANSWERED'=>'Nghe máy','MISSED CALL'=>'Gọi lỡ'], null, array('class' => 'form-control','id'=>'call_status', 'placeholder'=>'Tất cả cuộc gọi')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('dest_number', null, array('class' => 'form-control','id'=>'dest_number', 'placeholder'=>'SĐT khách hàng')) !!}
                </div>
                <ul class="col-md-6 no-padd mt5 tr">
                    <li class="display pl5"><a data-time="TODAY" class="choose_time active border b-gray">Hôm nay</a></li>
                    <li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>
                    <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH" class="display padding0-5 choose_time">Tháng
                            này</a>
                    </li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
                    {{--<li class="display position"><a class="other_time choose_time border b-gray"--}}
                    {{-->Khác</a>--}}
                    {{--<div class="add-drop add-d-right other_time_panel"--}}
                    {{--style="left: auto; right: 0px; z-index: 999; display: none;"><s class="gf-icon-neotop"></s>--}}
                    {{--<div class="padding tl"><p>Ngày bắt đầu</p>--}}
                    {{--<input type="text" class="form-control filter_start_date" id="datepicker"--}}
                    {{--data-toggle="datepicker" name="payment_date">--}}
                    {{--</div>--}}
                    {{--<div class="padding tl"><p>Ngày kết thúc</p>--}}
                    {{--<input type="text" class="form-control filter_end_date" id="datepicker"--}}
                    {{--data-toggle="datepicker" name="payment_date">--}}
                    {{--</div>--}}
                    {{--<div class="padding5-10 tl mb5">--}}
                    {{--<button class="btn btn-info submit_other_time">Tìm kiếm</button>--}}
                    {{--<button class="btn btn-default cancel_other_time">Đóng</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</li>--}}
                </ul>
            </div>

            <div id="registration-form">
                @include('call_center.ajax')
            </div>
        </div>
    </div>
    <input type="hidden" id="choose-time">
    <input type="hidden" id="filter-start-date">
    <input type="hidden" id="filter-end-date">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/js/player.js"></script>


@endsection
@section('_script')

    <script type="text/javascript">
        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{ url('/call-center') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        $(document).on('click', '.choose_time, .submit_other_time', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            let class_name = target.attr('class');
            let telesales = $('#telesales').val();
            let call_status = $('#call_status').val();
            let start_date = $('.filter_start_date').val();
            let end_date = $('.filter_end_date').val();
            let dest_number = $('#dest_number').val();

            if (class_name === 'display pl5') {
                var data_time = $(target).find('.choose_time').data('time');
                $('a.choose_time').removeClass('border b-gray');
                $(target).find('.choose_time').addClass('border b-gray');
            } else {
                var data_time = $('#choose_time').val();
            }

            $('#filter-start-date').val(start_date);
            $('#filter-end-date').val(end_date);
            if (typeof (data_time) != "undefined") {
                $('#choose-time').val(data_time);
            }
            $(".other_time_panel").css({'display': 'none'});
            $("#boxSearch").css({'display': 'none'});

            searchAjax({
                caller_number: telesales,
                call_status: call_status,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                dest_number: dest_number,
            });
        })
        ;

        $(document).on('change', '#telesales, #call_status', function () {
            let telesales = $('#telesales').val();
            let dest_number = $('#dest_number').val();
            let call_status = $('#call_status').val();
            let data_time = $('#choose-time').val();
            let start_date = $('#filter-start-date').val();
            let end_date = $('#filter-end-date').val();

            searchAjax({
                caller_number: telesales,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                call_status: call_status,
                dest_number: dest_number,
            });
        });

        $(document).on('keyup', ' #dest_number', delay(function () {
            let dest_number = $(' #dest_number').val();
            let call_status = $('#call_status').val();
            let data_time = $('#choose-time').val();
            let start_date = $('#filter-start-date').val();
            let end_date = $('#filter-end-date').val();
            let telesales = $('#telesales').val();

            let data = {
                caller_number: telesales,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                call_status: call_status,
                dest_number: dest_number,
            };
            searchAjax(data);

        }, 500));

        // delay keyup
        function delay(callback, ms) {
            // alert(ms);
            var timer = 0;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }
        $(document).on('click', '.other_time', function () {
            $(".other_time_panel").css({'display': ''});
        });

        $(document).on('click', '.cancel_other_time', function () {
            $(".other_time_panel").css({'display': 'none'});
        });
        $(document).on('click', '#showBoxSearch', function () {
            $("#boxSearch").css({'display': ''});
        });
        $(document).on('click', '#closeBoxSearch', function () {
            $("#boxSearch").css({'display': 'none'});
        });

        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });

        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            let telesales = $('#telesales-input').val();
            let data_time = $('#choose-time').val();
            let start_date = $('#filter-start-date').val();
            let end_date = $('#filter-end-date').val();
            let bor_none = $('#bor-none').val();
            let branch_id = $('.branch_id').val();
            let dest_number = $('#dest_number').val();


            $.ajax({
                url: '{{ url()->current() }}',
                method: "get",
                data: {
                    telesales: telesales,
                    data_time: data_time,
                    start_date: start_date,
                    end_date: end_date,
                    bor_none: bor_none,
                    page: pages,
                    branch_id: branch_id,
                    dest_number: dest_number,
                },
            }).done(function (data) {
                $('#registration-form').html(data);
            }).fail(function () {
                alert('Articles could not be loaded.');
            });
        });
    </script>
@endsection
