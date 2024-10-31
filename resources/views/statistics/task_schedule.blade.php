@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-top: 3%;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24 col-md-7">Thống kê công việc & lịch hẹn</h3>
                <div class="col-md-7">
                    {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'row', 'id'=> 'gridForm','role'=>'form')) !!}
                    <div class="col-md-4">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <input id="reportrange" type="text" class="form-control square">
                    </div>
                    <div class="col-lg-3 col-md-3">
                        {!! Form::select('branch_id', $branchs, 1, array('class' => 'form-control location select-gear', 'placeholder' => '--Chi nhánh--')) !!}
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm
                        </button>
                    </div>
                    {{ Form::close() }}

                </div>
            </div>
            <div id="registration-form">
                @include('statistics.ajax_taskSchedule')
            </div>
        </div>
        <!-- table-responsive -->
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    <script type="text/javascript">
        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{ Url('statistics-task/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        $(document).on('click', '.choose_time, #submit_other_time', function (e) {
            e.preventDefault();
            if (e.target.id == 'submit_other_time') {
                $('#data-time').val('').change();
            } else {
                $('#start-date').val('').change();
                $('#end-date').val('').change();
            }
            // console.log(e.target.id);

            let target = $(e.target).parent();
            const data_time = $(target).find('.choose_time').data('time');
            $('a.choose_time').removeClass('border b-gray');
            $(target).find('.choose_time').addClass('border b-gray');
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();

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
            });
        });

        $('.tower').change(function () {
            var value = $(this).val();
            searchAjax({
                tower: value,
            });
        })

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
