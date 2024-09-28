@extends('layout.app')
<link rel="stylesheet" href="{{asset('assets/plugins/kanban-board/jkanban.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
<link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
{{--<style>--}}
{{--.title {--}}
{{--text-align: left;--}}
{{--}--}}
{{--</style>--}}
<style>
    body {
        font-family: "Lato";
        margin: 0;
        padding: 0;
    }

    #myKanban {
        overflow-x: auto;
        padding: 20px 0;
    }

    .success {
        background: #00b961;
    }

    .info {
        background: #2a92bf;
    }

    .warning {
        background: #f4ce46;
    }

    .error {
        background: #fb7d44;
    }

    .custom-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 7px 15px;
        margin: 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    .kanban-item {
        font-size: 14px;
        color: black;
        padding: 11px;
        margin-bottom: 6px;
    }

    .kanban-title-board {
        color: #fff;
    }

    .kanban-container {
        width: 100% !important;
        display: flex;
        justify-content: center;
    }

    .kanban-board {
        min-width: 31% !important;
    }

    @media only screen and (max-width: 1920px) {
        .kanban-drag {
            padding: 6px !important;
            max-height: 68vh;
            overflow-y: auto;
        }
    }

    @media only screen and (max-width: 1440px) {
        .kanban-drag {
            padding: 6px !important;
            max-height: 60vh;
            overflow-y: auto;
        }
    }

    .img-card {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        border: 1px solid #f3f3f3;
    }

</style>
@section('content')
    @php
        $roleGlobal = auth()->user()?:[];
    @endphp
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">Chăm sóc khách hàng</h3>
            </div>

            <div class="card-header">
                {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'col-12 row', 'id'=> 'gridForm','role'=>'form')) !!}
                <div class="col-md-2">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                @if($roleGlobal->permission('tasks.employee'))
                    <div class="col-md-2">
                        {!! Form::select('sale_id', [\Illuminate\Support\Facades\Auth::user()->id =>'Của tôi'], null, array('class' => 'form-control type', 'placeholder'=>'Toàn phòng ban')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::select('branch_id', $branchs, null, array('class' => 'form-control branch_id', 'placeholder'=>'Tất cả chi nhánh')) !!}
                    </div>
                    <div class="col-lg-2 col-md-3">
                        {!! Form::select('location_id', $location, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Cụm khu vực')) !!}
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::ADMIN)
                    <div class="col-lg-2">
                        {!! Form::select('type', [\App\Constants\StatusCode::GOI_LAI=>"Gọi lại",\App\Constants\StatusCode::CSKH=>'CSKH'], null, array('class' => 'form-control', 'placeholder' => 'Loại công việc')) !!}
                    </div>
                @endif
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
                {!! Form::close() !!}
            </div>

            <div id="registration-form">
                @include('kanban_board.ajax')
            </div>
        @include('kanban_board.modal')

        <!-- table-responsive -->
        </div>
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection

@section('_script')
    <script src="{{asset('assets/plugins/kanban-board/jkanban.min.js')}}"></script>
@endsection

