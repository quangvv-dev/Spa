@extends('layout.app')
@section('_style')
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
        .row-cards{
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            box-shadow: 0 0 0 1px rgb(61 119 180 / 12%), 0 8px 16px 0 rgb(91 139 199 / 24%);
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>

@endsection
@section('content')

    <div class="col-md-12">
        <div id="fix-scroll" class="row padding mb10 header-dard border-bot shadow row">
            {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'col-md-12', 'id'=> 'gridForm','role'=>'form')) !!}
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title bold">XẾP HẠNG TELESALE</h3></br>

                </div>
                <div class="col-md-4">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
            </div>
            {{ Form::close() }}
            <a title="Download Data" style="position: absolute;right: 2%" class="btn download-pdf"
               href="javascript:void(0)">
                <i class="fas fa-download"></i></a>
        </div>
    </div>
    <div class="col-md-12 col-lg-12" id="registration-form">
        @include('report_products.ajax_sale')
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    <script>
        $(document).on('click', '.download-pdf', function (e) {
            let time_choose = $('#time_choose').val();
            let url = location.href + '?data_time=' + time_choose + '&dowload_pdf=1';
            location.href = url;
        });
    </script>
@endsection

