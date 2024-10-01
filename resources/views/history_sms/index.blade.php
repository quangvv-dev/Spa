@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">{{$title}}</h3></br>
            </div>
            <div class="card-header">

                {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'row', 'id'=> 'gridForm','role'=>'form')) !!}
                <div class="col-md-4">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <div class="col-md-3 col-sm-6">
                    {!! Form::select('campaign_id', $campaign_arr, null, array('class' => 'form-control campaign select-gear', 'placeholder' => 'Tất cả chiến dịch')) !!}
                </div>
                <div class="col-md-3 col-sm-6">
                    {!! Form::text('search', null, array('class' => 'form-control' ,'id'=>'search', 'placeholder' => 'Nhập SĐT ...')) !!}
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
                {{ Form::close() }}

            </div>
            <div id="registration-form">
                @include('history_sms.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"
            crossorigin="anonymous"></script>
@endsection
@section('_script')

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select-gear').selectize({
                sortField: 'text'
            });
        });
    </script>
@endsection
