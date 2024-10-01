@extends('layout.app')
@php
    $checkRole = checkRoleAlready();
@endphp
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <style>
        select#order_type {
            background: #dddddd;
        }

        .tableFixHead {
            overflow-y: auto;
            height: 800px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
        }

        .tableFixHead tbody .fixed td {
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
            background: #0062cc;
        }

        .tableFixHead tbody .fixed td {
            background: #3b8fec;
        }

        .tableFixHead tbody .fixed2 td {
            background: #3b8fec;
        }

        .form-control {
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text">{{$title}}</h3>
                <div class="col">
                </div>
            </div>

            <div class="card-header">
                {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'col', 'id'=> 'gridForm','role'=>'form')) !!}
                <div class="row">
                    <div class="col-md-2">
                        {!! Form::select('telesales', $telesales, null, array('class' => 'form-control select2','id'=>'telesales', 'placeholder'=>'Người phụ trách')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::select('payment_type', \App\Models\PaymentHistory::label, null, array('class' => 'form-control select2','id'=>'telesales', 'placeholder'=>'Loại thanh toán')) !!}
                    </div>
                    @if(empty($checkRole))
                        <div class="col-md-2">
                            {!! Form::select('branch_id', $branchs, null, array('class' => 'form-control branch_id select2', 'placeholder'=>'Tất cả chi nhánh')) !!}
                        </div>
                    @endif
                    <div class="col-lg-2">
                        {!! Form::select('source_id', $source, null, array('class' => 'form-control select2','id'=>'source', 'placeholder'=>'Nguồn')) !!}
                    </div>
                    <div class="col-md-2">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <input id="reportrange" type="text" class="form-control square">
                    </div>
                    <input type="hidden" name="page" value="1" id="page">
                    <div class="col-lg-1 col-md-6">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm
                        </button>
                    </div>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a style="display: none" href="#" class="angleDoubleUp">
                                    <i class="fa fa-angle-double-up"></i></a></li>
                            <li><a href="#" class="angleDoubleDown"><i class="fa fa-angle-double-down"></i></a></li>
                        </ul>
                    </div>
                </div>
                @include('order-details.dropdownFilter')
                {{ Form::close() }}
            </div>


            <div id="registration-form">
                @include('order-details.payment.ajax')
            </div>
        </div>
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    <script type="text/javascript">

        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            $('#page').val(pages);
            $('#gridForm').submit();
        });

        $(document).on('click', '.download', function (e) {
            $('#page').val('');
            let params = $("#gridForm").serialize();
            let url = "{{route('export.paymentHistory')}}" + "?" + params;
            window.location.replace(url);
        });
    </script>
@endsection
