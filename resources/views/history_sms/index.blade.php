@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>
            <div class="card-header">
                <div class="col-md-6 col-sm-6">
                    {!! Form::select('campaign_id', $campaign_arr, null, array('class' => 'form-control campaign select-gear', 'placeholder' => 'Tất cả chiến dịch')) !!}
                </div>
                <ul class="col-md-6 no-padd mt5 tr right">
                    <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH" class="choose_time border b-gray">Tháng này</a>
                    </li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
                    <li class="display position"><a class="other_time ">Khác</a>
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
                                <button class="btn btn-info" id="submit_other_time">Tìm kiếm</button>
                                <button class="btn btn-default cancel_other_time">Đóng</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="registration-form">
                @include('history_sms.ajax')
            </div>
            <input type="hidden" id="campaign_id">
            <input type="hidden" id="data-time">
            <input type="hidden" id="start-date">
            <input type="hidden" id="end-date">
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"
            crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select-gear').selectize({
                sortField: 'text'
            });
        });

        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });

        function searchCategory(data) {
            $.ajax({
                url: "{{ Url('history-sms/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        }

        $(document).on('change', '.campaign', function (e) {
            const id = $(this).val();
            // const opt = document.querySelector('.campaign option:checked');
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            const data_time = $('#data-time').val();
            $('#campaign_id').val(id);
            searchCategory({campaign_id: id,start_date: start_date,
                end_date: end_date,data_time:data_time})
        });

        $(document).on('click', '.choose_time, #submit_other_time', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            const class_name = target.attr('class');
            if (class_name === 'display pl5') {
                console.log('done');
                $('.filter_start_date').val('');
                $('.filter_end_date').val('');
            }
            const data_time = $(target).find('.choose_time').data('time');
            $('a.choose_time').removeClass('border b-gray');
            $(target).find('.choose_time').addClass('border b-gray');
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            const campaign_id = $('#campaign_id').val();

            if (typeof data_time === "undefined") {
                    $('#data-time').val();
            } else {
                $('#data-time').val(data_time);
            }
            $('#start-date').val(start_date);
            $('#end-date').val(end_date);

            searchCategory({
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                campaign_id: campaign_id,
            });
        });

        $(document).on('click', '.other_time', function () {
            $(".other_time_panel").css({'display': ''});
        });

        $(document).on('click', '.cancel_other_time', function () {
            $(".other_time_panel").css({'display': 'none'});
        });

    </script>
@endsection
