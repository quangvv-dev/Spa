@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-top: 3%;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thống kê doanh thu chi nhánh</h3>
                <div class="col-md-2 form-group">
                    {!! Form::select('tower', $towers, null, array('class' => 'form-control select-gear tower')) !!}
                </div>
                <div class="col-md-9">
                    <ul class="col-md-9 no-padd mt5 tr right">
                        <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                        <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                        <li class="display pl5"><a data-time="THIS_MONTH" class="display padding0-5 choose_time border b-gray">Tháng này</a></li>
                        <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
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
    <input type="hidden" id="tower">
    </div>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.css" integrity="sha512-WUYSspsMSeZ5Rh9CMn8wP9W+8/1ukN1r0CJjw5ZNCCZkM49nig92GzbOur5CpoDcnT+4gVMbPZB5P3su7Z799Q==" crossorigin="anonymous" />
@section('_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js" integrity="sha512-F7O0WjUWT+8qVnkKNDeXPt+uwW51fA8QLbqEYiyZfyG8cR0oaodl2oOFWODnV3zZvcy0IruaTosDiSDSeS9LIA==" crossorigin="anonymous"></script>t>
    <script type="text/javascript">
       // $(document).ready(function () {
       //     $('.select-gear').selectize({
       //         sortField: 'text'
       //     });
       //  //     $(".fc-datepicker").datepicker({dateFormat: 'dd-mm-yy'});
       //  });

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

        $(document).on('click', '.choose_time, #submit_other_time', function (e) {
            e.preventDefault();

            if (e.target.id == 'submit_other_time') {
                $('#data-time').val('').change();
            } else {
                $('#start-date').val('').change();
                $('#end-date').val('').change();
            }
            let target = $(e.target).parent();
            const data_time = $(target).find('.choose_time').data('time');
            $('a.choose_time').removeClass('border b-gray');
            $(target).find('.choose_time').addClass('border b-gray');
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            const user_id = $('#search-user').val();
            const tower = $('#tower').val();
            ;

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
                tower: tower,
            });
        });

        $('.tower').change(function () {
            var value = $(this).val();
            $('#tower').val(value);
            var data_time = $('#data-time').val();

            searchAjax({
                tower: value,
                data_time: data_time,
            });
        })

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
