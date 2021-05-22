@extends('layout.app')
<link rel="stylesheet" href="{{asset('assets/plugins/kanban-board/jkanban.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}"/>
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

</style>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chăm sóc khách hàng</h3></br>
                <div class="col">

                </div>
            </div>
            {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
            <div class="card-header">
                <input type="hidden" name="start_date" id="start_date">
                <input type="hidden" name="end_date" id="end_date">
                <div class="col-lg-4 col-md-6">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <button type="submit" class="btn btn-primary" id="btnSearch"><i class="fa fa-search"></i> Tìm kiếm
                </button>
            </div>
            {!! Form::close() !!}
            <div id="registration-form">
                @include('kanban_board.ajax')
                @include('kanban_board.modal')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection

@section('_script')
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection

