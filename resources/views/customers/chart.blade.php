@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <style>
        .add-drop {
            position: absolute;
            border: 1px solid #d0d0d0;
            top: 28px;
            box-shadow: 0 0 5px #ccc;
            z-index: 3;
            min-width: 300px;
            background: #fff;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="side-app">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <div id="fix-scroll" class="row padding mb10 header-dard border-bot shadow">
                            <div class="col-md-4 no-padd">
                            </div>
                            <div class="col-md-8 no-padd">
                                <ul class="fr mg0 pt10 no-padd">
                                    <li class="display pl5"><a data-time="TODAY" class="btn_choose_time border b-gray active">Hôm nay</a>
                                    </li>
                                    <li class="display pl5"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần
                                            này</a></li>
                                    <li class="display pl5"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần
                                            trước</a></li>
                                    <li class="display pl5"><a data-time="THIS_MONTH"
                                                               class="btn_choose_time padding0-5">Tháng
                                            này</a></li>
                                    <li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng
                                            trước</a></li>
                                    <li class="display pl5"><a data-time="THIS_YEAR" class="btn_choose_time">Năm nay</a>
                                    </li>
                                    <li class="display position"><a class="other_time choose_time">Khác</a>
                                        <div class="add-drop add-d-right other_time_panel"
                                             style="left: auto; right: 0px; z-index: 999; display: none;"><s class="gf-icon-neotop"></s>
                                            <div class="padding tl"><p>Ngày bắt đầu</p>
                                                <input type="text" class="form-control filter_start_date" id="datepicker" data-toggle="datepicker" name="payment_date">
                                            </div>
                                            <div class="padding tl"><p>Ngày kết thúc</p>
                                                <input type="text" class="form-control filter_end_date" id="datepicker" data-toggle="datepicker" name="payment_date">
                                            </div>
                                            <div class="padding5-10 tl mb5">
                                                <button class="btn btn-info submit_other_time">Tìm kiếm</button>
                                                <button class="btn btn-default cancel_other_time">Đóng</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <input type="hidden" id="time_choose" value="TODAY">
                            </div>
                        </div>
                        <div id="registration-form">
                            @include('customers.ajax_chart')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('click', '.btn_choose_time, .submit_other_time', function (e) {
            let target = $(e.target).parent();
            $('a.btn_choose_time').removeClass('border b-gray');
            $(target).find('.btn_choose_time').addClass('border b-gray');
            const data_time = $(target).find('.btn_choose_time').data('time');
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            const type = $('#type').val();
            $('#time_choose').val(data_time).change()
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{ Url('report/customers') }}",
                method: "get",
                data: {
                    data_time: data_time,
                    start_date: start_date,
                    end_date: end_date,
                    type: type
                }
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        })

        $(document).on('change', '#type', function () {
            const data_time = $('#time_choose').val();
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            const type = $('#type').val();
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{ Url('report/customers') }}",
                method: "get",
                data: {
                    data_time: data_time,
                    start_date: start_date,
                    end_date: end_date,
                    type: type
                }
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        });

        $(document).on('click', '.other_time', function () {
            $(".other_time_panel").css({'display': ''});
        });

        $(document).on('click', '.cancel_other_time', function () {
            $(".other_time_panel").css({'display': 'none'});
        });
        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });
    </script>
@endsection
