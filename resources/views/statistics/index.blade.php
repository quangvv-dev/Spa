@extends('layout.app')
@section('_style')
    {{--    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
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
                <h3 class="card-title col-md-7 bold">THỐNG KÊ DOANH THU</h3>

                {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'row', 'id'=> 'gridForm','role'=>'form')) !!}
                <div class="col-md-5">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <div class="col-lg-4 col-md-3">
                    {!! Form::select('branch_id', $branchs, 1, array('class' => 'form-control branch_id', 'placeholder'=>'Tất cả chi nhánh')) !!}
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
                {{ Form::close() }}

            </div>
            <div id="registration-form">
                @include('statistics.ajax')
            </div>
        </div>
        <!-- table-responsive -->
    </div>

    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
