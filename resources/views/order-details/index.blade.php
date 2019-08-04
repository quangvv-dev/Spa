@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{ route('orders.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header col-md-12">
                <div class="col-md-3">
                    @include('order-details.search')
                </div>
                <ul class="col-md-9 no-padd mt5 tr">
                    <li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>
                    <li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>
                    <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH" class="display padding0-5 choose_time">Tháng
                            này</a>
                    </li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
                    <li class="display position"><a class="other_time choose_time  border b-gray" data-time="OTHER_TIME">Khác</a>
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
            </div>
            <div id="registration-form">
                @include('order-details.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('click', '#applyBoxSearch, .choose_time, .submit_other_time', function (e) {
            let target = $(e.target).parent();
            const group= $('.group').val();
            const telesales = $('.telesales').val();
            const marketing = $('.marketing').val();
            const customer = $('.customer').val();
            const service = $('.service').val();
            const payment_type = $('.payment-type').val();
            const data_time = $(target).find('.choose_time').data('time');
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            $(".other_time_panel").css({ 'display' : 'none'});
            $("#boxSearch").css({ 'display' : 'none'});

            $.ajax({
                url: "{{ Url('list-orders/') }}",
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
                    end_date: end_date
                }
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        });
        
        $(document).on('click', '.other_time' ,function () {
            $(".other_time_panel").css({ 'display' : ''});
        })

        $(document).on('click', '.cancel_other_time' ,function () {
            $(".other_time_panel").css({ 'display' : 'none'});
        });
        $(document).on('click', '#showBoxSearch' ,function () {
            $("#boxSearch").css({ 'display' : ''});
        });
        $(document).on('click', '#closeBoxSearch' ,function () {
            $("#boxSearch").css({ 'display' : 'none'});
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
