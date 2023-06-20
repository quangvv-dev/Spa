@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
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

        th.text-center {
            font-size: 13px;
        }

        tr.fixed th {
            font-size: 12px;
        }

        .budget, .comment, .message {
            width: 105px;
        }
    </style>

@endsection
@section('content')

    <div class="col-md-12">
        <div id="fix-scroll" class="row padding mb10 header-card border-bot shadow">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title bold">Doanh thu CSKH</h3>
                </div>

                <div class="card-header row">

                    {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'col-lg-12', 'id'=> 'gridForm','role'=>'form')) !!}

                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                            <input id="reportrange" type="text" class="form-control square">
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::ADMIN)
                            <div class="col-md-2">
                                {!! Form::select('location_id', $location, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Cụm khu vực')) !!}
                            </div>
                        @endif
                        <div class="col-lg-2 col-md-6">
                            <button type="submit" class="btn btn-primary"> Tìm kiếm
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
                <div class="col-md-12 col-lg-12">
                    @include('cskh.ajax')
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
    <script src="{{ asset('js/format-number.js') }}"></script>
@endsection

