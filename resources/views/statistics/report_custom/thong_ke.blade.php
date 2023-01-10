@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <style>
        .title {
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-top: 3%;">
        <div class="card">
            <div class="card-header">
                <div class="col-md-4">
                    <h3 class="card-title bold">THỐNG KÊ</h3>
                </div>
                <div class="col-md-8">
                    {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'row', 'id'=> 'gridForm','role'=>'form')) !!}
                    <div class="col-md-4">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <input id="reportrange" type="text" class="form-control square">
                    </div>
                    <div class="col-lg-3 col-md-3">
                        {!! Form::select('type_search', ['1'=>'Doanh thu theo tỉnh','2'=>'Doanh thu theo tuổi','3'=>'Doanh thu theo nghề nghiệp'], null, array('class' => 'form-control location select-gear', 'placeholder' => 'Chọn kiểu lọc')) !!}
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <button type="submit" class="btn btn-primary searchData"> Tìm kiếm
                        </button>
                    </div>
                    {{ Form::close() }}
                </div>

            </div>
            <div id="registration-form">
                @include('statistics.report_custom.report_city')
            </div>
        </div>
        <!-- table-responsive -->
    </div>

    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
