@extends('layout.app')
<link rel="stylesheet" href="{{asset('assets/plugins/kanban-board/jkanban.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}"/>
<link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
{{--<style>--}}
{{--.title {--}}
{{--text-align: left;--}}
{{--}--}}
{{--</style>--}}
<style>
    body {
        font-family: "Lato";
        margin: 0;
        padding: 0;
    }

    #myKanban {
        overflow-x: auto;
        padding: 20px 0;
    }

    .success {
        background: #00b961;
    }

    .info {
        background: #2a92bf;
    }

    .warning {
        background: #f4ce46;
    }

    .error {
        background: #fb7d44;
    }

    .custom-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 7px 15px;
        margin: 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    .kanban-item {
        font-size: 14px;
        color: black;
        padding: 11px;
        margin-bottom: 6px;
    }

    .kanban-title-board {
        color: #fff;
    }

    .kanban-container {
        width: 100% !important;
        display: flex;
        justify-content: center;
    }

    .kanban-board {
        min-width: 31% !important;
    }

    @media only screen and (max-width: 1920px) {
        .kanban-drag {
            padding: 6px !important;
            max-height: 68vh;
            overflow-y: auto;
        }
    }

    @media only screen and (max-width: 1440px) {
        .kanban-drag {
            padding: 6px !important;
            max-height: 60vh;
            overflow-y: auto;
        }
    }
    .img-card{
        width: 30px;
        height: 30px;
        border-radius: 5px;
        border: 1px solid #f3f3f3;
    }

</style>
@section('content')
    @php
        $roleGlobal = auth()->user()?:[];
    @endphp
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chăm sóc khách hàng</h3></br>

            </div>
            {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}

            <ul class="col-md-9 no-padd mt5 tr right">
                <li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>
                <li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>
                <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time border b-gray">Tuần này</a></li>
                <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                <li class="display pl5">
                    <a data-time="THIS_MONTH" class="display padding0-5 choose_time ">Tháng này</a>
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

            <div class="col-md-2">
                @if($roleGlobal->permission('tasks.employee'))
                    {!! Form::select('type', [1=>'Của tôi'], null, array('class' => 'form-control type', 'placeholder'=>'Toàn phòng ban')) !!}
                @endif
            </div>
            {!! Form::close() !!}
            <input type="hidden" id="start-date">
            <input type="hidden" id="end-date">
            <input type="hidden" id="data-time">

            <div id="registration-form">
                @include('kanban_board.ajax')
            </div>
        @include('kanban_board.modal')

        <!-- table-responsive -->
        </div>
    </div>
@endsection

@section('_script')
    <script src="{{asset('assets/plugins/kanban-board/jkanban.min.js')}}"></script>

    <script>

        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{ Url('tasks/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        $(document).on('change', '.type', function (e) {
            let data = $(this).val();
            let start_date = $('#start-date').val();
            let end_date = $('#end-date').val();
            let data_time = $('#data-time').val();
            console.log(data, start_date, end_date, data_time);
            searchAjax({
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                type: data,
            });
        })

        $(document).on('click', '.choose_time, .submit_other_time', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            let data_time = $(target).find('.choose_time').data('time');
            let class_name = target.attr('class');
            if (class_name === 'display pl5') {
                $('.filter_start_date').val('');
                $('.filter_end_date').val('');
            }
            $('a.choose_time').removeClass('border b-gray');
            $(target).find('.choose_time').addClass('border b-gray');
            let start_date = $('.filter_start_date').val();
            let end_date = $('.filter_end_date').val();
            // let user_id = $('#search-user').val();

            if (typeof data_time === "undefined") {
                $('#data-time').val();
            } else {
                $('#data-time').val(data_time);
            }
            $('#start-date').val(start_date);
            $('#end-date').val(end_date);
            let type = $('.type').val();
            searchAjax({
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                type: type,
            });
        });
    </script>
@endsection

