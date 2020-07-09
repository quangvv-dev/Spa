@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>

@endsection
@section('content')

    <div class="col-md-12">
        <div id="fix-scroll" class="row padding mb10 header-dard border-bot shadow" style="width: 100%; padding: 10px;">
            <div class="col-md-4 no-padd">
                <ul class="fr mg0 pt10 no-padd">
                    <li class="display pl5"><a data-time="THIS_WEEK" class="btn_choose_time border b-gray bg-gray active">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH" class="btn_choose_time ">Tháng này</a></li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng trước</a></li>
                </ul>
                <input type="hidden" id="time_choose" value="THIS_WEEK">
            </div>
            <div class="col-md-2">
                {{Form::select('type',$telesales, null, array('class' => 'form-control','id'=>'telesales','placeholder'=>'Tất cả nhân viên'))}}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 list-data">
        @include('report_products.ajax_group')
    </div>
@endsection
@section('_script')
    <script>
        function searchAjax(data) {
            $('.list-data').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: window.location.href ,
                method: "get",
                data: data,
            }).done(function (data) {
                $('.list-data').html(data);
            });
        }

        $(document).on('click', '.btn_choose_time, .submit_other_time', function (e) {
            let target = $(e.target).parent();
            $('a.btn_choose_time').removeClass('border b-gray');
            $(target).find('.btn_choose_time').addClass('border b-gray');
            const data_time = $(target).find('.btn_choose_time').data('time');
            $('#time_choose').val(data_time).change();
            const telesales = $('#telesales').val();
            searchAjax({data_time: data_time, telesale_id: telesales})
        });

        $('#telesales').change(function () {
            let value = $(this).val();
            let data_time = $('#time_choose').val();
            searchAjax({data_time: data_time, telesale_id: value})

        })
    </script>
@endsection

