@extends('layout.app')
@section('_style')
{{--    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>--}}
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="col-md-11">
                    <ul class="col-md-9 no-padd mt5 tr right">
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
            </div>
            <div class="card-header">
                {{--                <div class="wd-200 mg-b-30">--}}
                {{--                    <div class="input-group">--}}
                {{--                        {!! Form::text('from_date', null, array('id' => 'from-date', 'class' => 'form-control fc-datepicker', 'placeholder' => 'Từ ngày')) !!}--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="wd-200 mg-b-30" style="margin-left: 5px">--}}
                {{--                    <div class="input-group">--}}
                {{--                        {!! Form::text('to_date', null, array('id' => 'to-date', 'class' => 'form-control fc-datepicker', 'placeholder' => 'Đến ngày')) !!}--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="col-md-2 col-xs-6 wd-200 mg-b-30">
                    <div class="input-group">
                        {!! Form::select('user_id', $user,null, array('id' => 'user_id', 'class' => 'form-control select2', 'data-placeholder' => 'Chọn nhân viên')) !!}
                    </div>
                </div>

            </div>

            <div id="registration-form">
                @include('statistics.ajax_home')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".fc-datepicker").datepicker({dateFormat: 'dd-mm-yy'});
        })

        $(document).on('keyup change', '#from-date,#to-date', function (e) {
            e.preventDefault();
            var from_date = $('#from-date').val();
            var to_date = $('#to-date').val();

            $.ajax({
                url: "{{ Url('statistics/') }}",
                method: "get",
                data: {
                    from_date: from_date,
                    to_date: to_date
                }
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });

        $(document).on('click', '.choose_time', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            const data_time = $(target).find('.choose_time').data('time');

            $.ajax({
                url: "{{ Url('statistics/') }}",
                method: "get",
                data: {
                    data_time: data_time
                }
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
    </script>
@endsection
