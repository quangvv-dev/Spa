@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
            <div class="card-header">
                <div class="col-md-2">
                    {!! Form::select('sale_id', $users, null, array('class' => 'form-control sale','placeholder'=>'Tất cả sale')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('type', [\App\Constants\NotificationConstant::CSKH=>'CSKH',\App\Constants\NotificationConstant::CALL=>'Gọi điện'], null, array('class' => 'form-control type','placeholder'=>'Tất cả công việc')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('task_status_id', [\App\Constants\StatusCode::NEW_TASK=>'Mới',\App\Constants\StatusCode::DONE_TASK=>'Hoàn thành',\App\Constants\StatusCode::FAILED_TASK=>'Quá hạn'], null, array('class' => 'form-control task-status','placeholder'=>'Tất cả trạng thái')) !!}
                </div>
                <input type="hidden" name="data_time" id="data_time">
                <div class="col-md-6">
                    <ul class="no-padd mt5 tr right">
                        {{--<li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>--}}
                        {{--<li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>--}}
                        <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                        <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                        <li class="display pl5"><a data-time="THIS_MONTH"
                                                   class="display padding0-5 choose_time border b-gray">Tháng
                                này</a>
                        </li>
                        <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
                        <li class="display position"><a class="other_time choose_time ">Khác</a>
                            <div class="add-drop add-d-right other_time_panel"
                                 style="left: auto; right: 0px; z-index: 999; display: none;"><s
                                    class="gf-icon-neotop"></s>
                                <div class="padding tl"><p>Ngày bắt đầu</p>
                                    <input type="text" class="form-control filter_start_date" id="datepicker"
                                           data-toggle="datepicker" name="start_date">
                                </div>
                                <div class="padding tl"><p>Ngày kết thúc</p>
                                    <input type="text" class="form-control filter_end_date" id="datepicker"
                                           data-toggle="datepicker" name="end_date">
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
            {{ Form::close() }}

            <div id="registration-form">
                @include('tasks.ajax_statistical')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">

        $(document).on('change', '.task-status, .type, .sale', function () {
            $('#gridForm').submit();
        });

        $(document).on('click', '.choose_time, .submit_other_time', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            const data_time = $(target).find('.choose_time').data('time');
            const class_name = target.attr('class');
            if (class_name === 'display pl5') {
                $('#data_time').val(data_time);
                $('.filter_start_date').val('');
                $('.filter_end_date').val('');
            }
            $('a.choose_time').removeClass('border b-gray');
            $(target).find('.choose_time').addClass('border b-gray');
            $('#gridForm').submit();

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
