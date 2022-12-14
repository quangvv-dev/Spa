@extends('layout.app')
@php
    $checkRole = checkRoleAlready();
@endphp
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/progres-bar.css') }}" rel="stylesheet"/>
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

        @media only screen and (max-width: 1921px) {
            .table-responsive {
                max-height: 70vh;
            }
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            <div class="card-header">
                {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'col row', 'id'=> 'gridForm','role'=>'form')) !!}

                <div class="col-md-3">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <div class="col-md-2">
                    {!! Form::select('caller_number', $telesales, null, array('class' => 'form-control','id'=>'telesales', 'placeholder'=>'Nhân viên')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('call_status', ['ANSWERED'=>'Nghe máy','MISSED CALL'=>'Gọi lỡ'], null, array('class' => 'form-control','id'=>'call_status', 'placeholder'=>'Tất cả cuộc gọi')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('dest_number', null, array('class' => 'form-control','id'=>'dest_number', 'placeholder'=>'SĐT khách hàng')) !!}
                </div>
                <input type="hidden" id="valuePage" name="page" value="1">
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary btnSearch"> Tìm kiếm
                    </button>
                </div>
                {{ Form::close() }}

            </div>

            <div id="registration-form">
                @include('call_center.ajax')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/js/player.js"></script>

    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')

    <script type="text/javascript">
        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{ url('/call-center') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }


        // delay keyup
        function delay(callback, ms) {
            // alert(ms);
            var timer = 0;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }


        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            // $('#valuePage').val(pages);
            // $('.btnSearch').click();

            let telesales = $('#telesales').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let call_status = $('#call_status').val();
            // let branch_id = $('.branch_id').val();
            let dest_number = $('#dest_number').val();
            searchAjax({
                telesales: telesales,
                start_date: start_date,
                end_date: end_date,
                call_status: call_status,
                page: pages,
                dest_number: dest_number,
            });
        });
    </script>
@endsection
