@extends('layout.app')
@section('_style')
    {{--    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>--}}
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-top: 3%;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thống kê tổng quan</h3>
                <div class="col-md-10">
                    <ul class="col-md-9 no-padd mt5 tr right">
                        {{--<li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>--}}
                        {{--<li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>--}}
                        <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                        <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                        <li class="display pl5"><a data-time="THIS_MONTH" class="display padding0-5 choose_time border b-gray">Tháng
                                này</a>
                        </li>
                        <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
                        <li class="display position"><a class="other_time choose_time ">Khác</a>
                            <div class="add-drop add-d-right other_time_panel"
                                 style="left: auto; right: 0px; z-index: 999; display: none;"><s
                                    class="gf-icon-neotop"></s>
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
            </div>
            <div id="registration-form">
                @include('statistics.ajax')
            </div>
        </div>
        <!-- table-responsive -->
    </div>
    <input type="hidden" id="data-time">
    <input type="hidden" id="start-date">
    <input type="hidden" id="end-date">
    <input type="hidden" id="search-user">
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        // $(document).ready(function () {
        //     $(".fc-datepicker").datepicker({dateFormat: 'dd-mm-yy'});
        // });

        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{ Url('statistics/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        $(document).on('click', '.choose_time, .submit_other_time', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            const data_time = $(target).find('.choose_time').data('time');
            $('a.choose_time').removeClass('border b-gray');
            $(target).find('.choose_time').addClass('border b-gray');
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            const user_id = $('#search-user').val();

            if (typeof data_time === "undefined") {
                $('#data-time').val();
            } else {
                $('#data-time').val(data_time);
            }
            $('#start-date').val(start_date);
            $('#end-date').val(end_date);

            searchAjax({
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                user_id: user_id,
            });
        });

        // $(document).on('change.select2', '.search-user', function () {
        //     const user_id = $('.search-user').val();
        //     const data_time = $('#data-time').val();
        //     const start_date = $('#start-date').val();
        //     const end_date = $('#end-date').val();
        //     $('#search-user').val(user_id);
        //
        //     searchAjax({
        //         data_time: data_time,
        //         start_date: start_date,
        //         end_date: end_date,
        //         user_id: user_id,
        //     })
        // });

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
