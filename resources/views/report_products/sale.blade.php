@extends('layout.app')
@section('_style')
    {{--<link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>--}}
    <style>
        .bxh-container {
            position: relative;
            width: 100%;
            height: 35%;
        }

        .bxh .item-rank {
            width: 6.5%;
            height: 6.5%;
            display: inline-block;
            position: absolute;
        }

        .bxh .item-rank1 .king-sale {
            display: block;
        }

        .bxh .item-rank .avatar-container {
            border: 6px solid #f49000;
        }

        .bxh .item-rank .avatar-container {
            display: inline-block;
            height: 88px;
            width: 100%;
            overflow: hidden;
            border-radius: 50%;
            border: 6px solid #53628e;
        }

        .bxh .item-rank .king-sale {
            display: block;
        }

        .bxh .king-sale {
            display: none;
            text-align: center;
            position: absolute;
            width: 100%;
            margin-top: -40%;
        }

        .bxh .item-rank .item-info {
            text-align: center;
        }

        .item-info1 {
            color: #da0e35;
            font-weight: 600;
        }

        .item-info {
            text-align: center;
        }

        .page-main {
            background-color: #fff;
        }
    </style>
    <style>

        .tableFixHead {
            overflow-y: auto;
            height: 800px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
        }

        .tableFixHead thead .number_index th {
            position: sticky;
            top: 118px;
        }

        @media (min-width: 1681px) {
            .tableFixHead thead .number_index th {
                position: sticky;
                top: 97px;
            }
        }

        .tableFixHead thead .tr1 th {
            position: sticky;
            top: 38px;
        }


        .tableFixHead tbody tr {
            position: sticky;
            top: 0;
        }

        .tableFixHead tbody .fixed th {
            position: sticky;
            bottom: 0;
        }

        .tableFixHead tbody .fixed2 td {
            position: sticky;
            bottom: 46px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background: #3b8fec;
        }

        .tableFixHead tbody .fixed th {
            background: #3b8fec;
        }

        .tableFixHead tbody .fixed2 td {
            background: #3b8fec;
        }

        .form-control {
            font-size: 14px;
        }

        .table th, .text-wrap table th {
            text-transform: unset;
            color: white;
        }

        tr.number_index th {
            font-size: 12px;
        }

        tr.fixed th {
            font-size: 12px;
        }

        td.text-center {
            font-size: 12px;
        }
    </style>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>

@endsection
@section('content')

    <div class="col-md-12">
        <div id="fix-scroll" class="row padding mb10 header-dard border-bot shadow" style="width: 100%; padding: 10px;">

            <div class="col-md-8 form-group">
                <h3 class="card-title">Thống kê chi tiết Telesales</h3>
            </div>
            <div class="col-md-2 form-group">
                {!! Form::select('tower', $towers, null, array('class' => 'form-control select-gear tower')) !!}
            </div>
            <div class="col-md-2 no-padd right tr">
                <ul class="fr mg0 pt10 no-padd">
                    <li class="display pl5"><a data-time="THIS_MONTH" class="btn_choose_time padding0-5 b-gray active border">Tháng này</a></li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng trước</a></li>
                </ul>
                <input type="hidden" id="time_choose" value="THIS_MONTH">
                <input type="hidden" id="tower" value="">
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 list-data">
        @include('report_products.ajax_sale')
    </div>

@endsection
@section('_script')
    <script>
        function search(data) {
            $('.list-data').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{ Url('report/sales') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('.list-data').html(data);
            });
        }

        $(document).on('click', '.btn_choose_time, .submit_other_time', function (e) {
            let target = $(e.target).parent();
            $('a.btn_choose_time').removeClass('border b-gray');
            $(target).find('.btn_choose_time').addClass('border b-gray');
            const data_time = $(target).find('.btn_choose_time').data('time');
            let tower = $('#tower').val();
            search({data_time: data_time, tower: tower});
        });
        $(document).on('change', '.tower', function (e) {
            let id = $(this).val();
            let data_time = $('#time_choose').val();
            $('#tower').val(id);
            search({data_time: data_time, tower: id});
        })
    </script>
@endsection

