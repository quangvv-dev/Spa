@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
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
            background: #cbdbf2;
        }

        .tableFixHead tbody .fixed2 td {
            background: #cbdbf2;
        }
        .form-control {
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col">
{{--                    <a title="Upload Data" style="position: absolute;right: 14%" class="btn" href="#"--}}
{{--                       data-toggle="modal" data-target="#myModal">--}}
{{--                        <i class="fas fa-upload"></i></a>--}}
{{--                    <a class="right btn btn-primary btn-flat" href="{{ route('orders.create') }}"><i--}}
{{--                                class="fa fa-plus-circle"></i>Thêm mới</a>--}}
                </div>
            </div>
            <div class="card-header col-md-12">
                <div class="col-md-3">
                    <div class="btn-group ml5">
                        {!! Form::select('telesales', $telesales, null, array('class' => 'form-control','id'=>'telesales', 'placeholder'=>'Người phụ trách')) !!}
                    </div>
                </div>
               {{-- <div class="col-md-3">
                    <div class="btn-group ml5">
                        {!! Form::select('order_type', $order_type, null, array('class' => 'form-control','id'=>'order_type', 'placeholder'=>'Tất cả đơn')) !!}
                    </div>
                </div>--}}

                <ul class="col-md-9 no-padd mt5 tr">
                    <li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>
                    <li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>
                    <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH" class="display padding0-5 choose_time">Tháng
                            này</a>
                    </li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
                    <li class="display position"><a class="other_time choose_time border b-gray"
                        >Khác</a>
                        <div class="add-drop add-d-right other_time_panel"
                             style="left: auto; right: 0px; z-index: 999; display: none;"><s class="gf-icon-neotop"></s>
                            <div class="padding tl"><p>Ngày bắt đầu</p>
                                <input type="text" class="form-control filter_start_date" id="datepicker"
                                       data-toggle="datepicker" name="payment_date">
                            </div>
                            <div class="padding tl"><p>Ngày kết thúc</p>
                                <input type="text" class="form-control filter_end_date" id="datepicker"
                                       data-toggle="datepicker" name="payment_date">
                            </div>
                            <div class="padding5-10 tl mb5">
                                <button class="btn btn-info submit_other_time">Tìm kiếm</button>
                                <button class="btn btn-default cancel_other_time">Đóng</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            {{--            <div class="card-header col-md-12">--}}
            {{--                <div class="col-md-12">--}}
            {{--                    <div class="btn-group ml5">--}}
            {{--                        {!! Form::select('order_type', $order_type, null, array('class' => 'form-control','id'=>'order_type', 'placeholder'=>'Tất cả đơn')) !!}--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div id="registration-form">
                @include('order-details.ajax-payment')
            </div>
        </div>
    </div>
    <input type="hidden" id="group">
    <input type="hidden" id="telesales-input">
    <input type="hidden" id="marketing">
    <input type="hidden" id="customer">
    <input type="hidden" id="service">
    <input type="hidden" id="payment-type">
    <input type="hidden" id="choose-time">
    <input type="hidden" id="filter-start-date">
    <input type="hidden" id="filter-end-date">
    <input type="hidden" id="bor-none">
    <input type="hidden" id="order-status">
    <input type="hidden" id="order-type">
    <input type="hidden" id="phone">
    {{--    @include('order-details.modal-upload-excel')--}}
@endsection
@section('_script')
    <script type="text/javascript">
        function searchAjax(data) {
            $.ajax({
                url: "{{ Url('orders-payment/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        $(document).on('click', '#applyBoxSearch, .choose_time, .submit_other_time', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            const class_name = target.attr('class');
            const telesales = $('#telesales-input').val();
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();

            if (class_name === 'display pl5')
                var data_time = $(target).find('.choose_time').data('time');
            else {
                var data_time = $('#choose_time').val();
            }
            if (class_name === 'btn-group ml5') {
                var bor_none = $(target).find('.bor-none').data('filter');
            } else {
                var bor_none = $('#bor-none').val();

            }

            $('#filter-start-date').val(start_date);
            $('#filter-end-date').val(end_date);
            if (typeof (data_time) != "undefined") {
                $('#choose-time').val(data_time);
            }
            if (typeof (bor_none) != "undefined") {
                $('#bor-none').val(bor_none);
            }
            $(".other_time_panel").css({'display': 'none'});
            $("#boxSearch").css({'display': 'none'});

            searchAjax({
                telesales: telesales,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                bor_none: bor_none,
            });
        })
        ;

        $(document).on('change', '#telesales', function () {
            const telesales = $('#telesales').val();
            const data_time = $('#choose-time').val();
            const start_date = $('#filter-start-date').val();
            const end_date = $('#filter-end-date').val();
            const bor_none = $('#bor-none').val();
            $('#telesales-input').val(telesales);

            searchAjax({
                telesales: telesales,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                bor_none: bor_none
            });
        });

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

        $(document).on('click', '.order_status', function () {
            $('.order_status').data('status', 0);
            const order_cancel = $('.order_status').data('status');
            $('#order-status').val(order_cancel);

            searchAjax({
                order_cancel: order_cancel
            });
        });

        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            const order_type = $('#order_type').val();
            const group = $('#group').val();
            const telesales = $('#telesales').val();
            const marketing = $('#marketing').val();
            const customer = $('#customer').val();
            const service = $('#service').val();
            const payment_type = $('#payment-type').val();
            const data_time = $('#choose-time').val();
            const start_date = $('#filter-start-date').val();
            const end_date = $('#filter-end-date').val();
            const bor_none = $('#bor-none').val();
            const phone = $('#phone').val();
            $.ajax({
                url: '{{ url()->current() }}',
                method: "get",
                data: {
                    group: group,
                    telesales: telesales,
                    marketing: marketing,
                    customer: customer,
                    service: service,
                    payment_type: payment_type,
                    data_time: data_time,
                    start_date: start_date,
                    end_date: end_date,
                    bor_none: bor_none,
                    order_type: order_type,
                    phone: phone,
                    page: pages,
                },
            }).done(function (data) {
                $('#registration-form').html(data);
            }).fail(function () {
                alert('Articles could not be loaded.');
            });
        });
    </script>
@endsection
