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
                <h3 class="card-title">{{$title}}</h3>
                <div class="col">
                </div>
            </div>
            <div class="card-header">
                {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'row col', 'id'=> 'gridForm','role'=>'form')) !!}
                <div class="col-md-2">
                    {!! Form::select('telesales', $telesales, null, array('class' => 'form-control select2','id'=>'telesales', 'placeholder'=>'Người phụ trách')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('payment_type', [1=>'Tiền mặt',2=>'Thẻ',3=>'Điểm',4=>'Chuyển khoản'], null, array('class' => 'form-control select2','id'=>'telesales', 'placeholder'=>'Loại thanh toán')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('role_type', [1=>'Học phí',2=>'Đơn khác'], null, array('class' => 'form-control select2', 'placeholder'=>'Tất cả đơn')) !!}
                </div>
                @if(empty($checkRole))
                    <div class="col-md-2">
                        {!! Form::select('branch_id', $branchs, null, array('class' => 'form-control branch_id select2', 'placeholder'=>'Tất cả chi nhánh')) !!}
                    </div>
                @endif
                <div class="col-md-3">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <input type="hidden" name="page" value="1" id="page">

                <div class="col-lg-1 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
                {{ Form::close() }}


            </div>
            <div id="registration-form">
                @include('order-details.ajax-payment')
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
    </script>
@endsection
