@extends('layout.app')
@section('_style')
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

        .row-cards {
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            box-shadow: 0 0 0 1px rgb(61 119 180 / 12%), 0 8px 16px 0 rgb(91 139 199 / 24%);
        }

        @media (min-width: 1280px) {
            .container {
                max-width: 97%;
            }
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>

@endsection
@section('content')

    <div class="col-md-12">
        <div id="fix-scroll" class="row padding mb10 header-dard border-bot shadow row">
            {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'col-md-12', 'id'=> 'gridForm','role'=>'form')) !!}
            <div class="row">
                <div class="col-md-4"><h3 class="card-title bold">XẾP HẠNG LỄ TÂN</h3></div>
                <div class="col-md-3">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <div class="col-lg-2 col-md-3">
                    {!! Form::select('location_id', $location, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Cụm khu vực')) !!}
                </div>
                <div class="col-lg-2 col-md-3">
                    {!! Form::select('branch_id', $branchs, 1, array('class' => 'form-control', 'placeholder' => 'Tất cả chi nhánh')) !!}
                </div>

                <div class="col-lg-1 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="col-md-12 col-lg-12" id="registration-form">
        @include('waiters.ajax')
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')

@endsection

