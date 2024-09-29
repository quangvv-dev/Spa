@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <style>
        .daterange-custom {
            background: #131313;
            border: 1px solid #686777;
            color: #fff;
            padding: 13.5px 16px;
            outline: none;
            border-radius: 8px;
        }
        #myChart1,#myChart2,#myChart3 {
            height: 250px;
            width: 250px;
        }
        .thong-ke__item {
            background: radial-gradient(150.73% 226.72% at -38.48% 56.41%, #253763 0%, #1A2749 23%, #121B34 50%, #0D1328 75%, #0C1124 100%);
            width: 33.3%;
            height: 230px;
            border-radius: 16px;
        }
        .thong-ke__item .number{
            background: linear-gradient(172.37deg, #FBF0D0 4.96%, #FFFAF4 45.9%, #CC9F5F 74.55%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 28px;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-top: 1%;">
        <div class="card">
            <div class="card-header">
                <div class="col-md-4">
                    <h3 class="card-title linear-text fs-24 bold">THỐNG KÊ DOANH THU</h3>
                </div>
                <div class="col-md-8">
                    {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'row', 'id'=> 'gridForm','role'=>'form')) !!}
                    <div class="col-md-4">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <input id="reportrange" type="text" class="form-control square">
                    </div>
                    @if((\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::BAN_GIAM_DOC && \Illuminate\Support\Facades\Auth::user()->branch_id == NULL)||(in_array(\Illuminate\Support\Facades\Auth::user()->department_id,[\App\Constants\DepartmentConstant::KE_TOAN,\App\Constants\DepartmentConstant::MARKETING])))
                        <div class="col-lg-3 col-md-3">
                            {!! Form::select('branch_id', $branchs, 1, array('class' => 'form-control branch_id', 'placeholder'=>'Tất cả chi nhánh')) !!}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {!! Form::select('location_id', $location, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Cụm khu vực')) !!}
                        </div>
                    @endif
                    <div class="col-lg-2 col-md-6">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm
                        </button>
                    </div>
                    {{ Form::close() }}
                </div>

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
