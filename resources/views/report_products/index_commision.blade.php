@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>

@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thống kê hoa hồng</h3>
            <div class="col-md-10">
                <ul class="col-md-9 no-padd mt5 tr right">
                    {{--<li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>--}}
                    {{--<li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>--}}
                    <li class="display pl5"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH"
                                               class="display padding0-5 btn_choose_time border b-gray">Tháng
                            này</a>
                    </li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng trước</a></li>
                </ul>
            </div>
        </div>
        <div id="registration-form">
            @include('report_products.ajax_commision')
        </div>
    </div>
@endsection
@section('_script')
    <script>
        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: window.location.href,
                method: "get",
                data: data,
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        $(document).on('click', '.btn_choose_time, .submit_other_time', function (e) {
            let target = $(e.target).parent();
            $('a.btn_choose_time').removeClass('border b-gray');
            $(target).find('.btn_choose_time').addClass('border b-gray');
            const data_time = $(target).find('.btn_choose_time').data('time');
            $('#time_choose').val(data_time).change();
            searchAjax({data_time: data_time})
        });
    </script>
@endsection

