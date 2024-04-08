@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <style>
        .bxh-container {
            position: relative;
            width: 100%;
            height: 25%;
        }

        .bxh .item-rank {
            width: 6.5%;
            height: 6.5%;
            display: inline-block;
            position: absolute;
        }

        .bxh .item-rank1 .king-sale {
            display: block;
        }

        .bxh .item-rank .avatar-container {
            border: 6px solid #f49000;
        }

        .bxh .item-rank .avatar-container {
            display: inline-block;
            height: 88px;
            width: 100%;
            overflow: hidden;
            border-radius: 50%;
            border: 6px solid #53628e;
        }

        .bxh .item-rank .king-sale {
            display: block;
        }

        .bxh .king-sale {
            display: none;
            text-align: center;
            position: absolute;
            width: 100%;
            margin-top: -40%;
        }

        .bxh .item-rank .item-info {
            text-align: center;
        }

        .item-info1 {
            color: #da0e35;
            font-weight: 600;
        }

        .item-info {
            text-align: center;
        }

        .page-main {
            background-color: #fff;
        }

        #registration-form {
            margin-top: 30px;
        }
    </style>
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

        .small-tip {
            font-size: 11px;
            color: #999;
        }

    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title col-lg-3">Thống kê hoa hồng</h3>
            <div class="col-md-9">
                {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'row', 'id'=> 'gridForm','role'=>'form')) !!}
                <div class="col-md-4">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::ADMIN)
                    <div class="col-lg-2 col-md-3">
                        {!! Form::select('location_id', $location, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Cụm khu vực')) !!}
                    </div>
                    <div class="col-lg-2 col-md-3">
                        {!! Form::select('branch_id', $branchs, null, array('class' => 'form-control', 'placeholder' => 'Tất cả chi nhánh')) !!}
                    </div>
                @endif
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <input type="hidden" id="user_id" value="0">
        <input type="hidden" id="user_id" value="0">
        <div id="registration-form">
            @include('report_products.ajax_commision')
        </div>
        @include('report_products.commision_modal')
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    <script>

        function urlParam(name, url) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            console.log(results, 'results')
            if (results == null) {
                return null;
            } else {
                return results[1] || 0;
            }
        }


        $(document).on('click', '#click_detail', function (e) {
            let id = $(this).data('id');
            $('#user_id').val(id).change();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            $.ajax({
                url: '/ajax/commission',
                method: "get",
                data: {user_id: id, start_date: start_date,end_date:end_date},
            }).done(function (data) {
                let html = compareData(data);
                let html_paginate = paginateJS(data);
                $('.pagination').html(html_paginate);
                $('#get_data').html(html);
                $('#myModal').modal('show');
            });
        });

        $(document).on('click', '.page-link', function (e) {
            let page = $(this).data('url');
            let user_id = $('#user_id').val();
            let time = $('#time_choose').val();

            var html = "";
            $.ajax({
                url: '/ajax/commission',
                method: "get",
                data: {page: page, user_id: user_id, data_time: time},
            }).done(function (data) {
                let html = compareData(data);
                let html_paginate = paginateJS(data);
                $('.pagination').html(html_paginate);
                $('#get_data').html(html);
                $('#myModal').modal('show');
            })
        });
        function paginateJS(data){
            let next = urlParam('page', data.next_page_url);
            let pev = urlParam('page', data.prev_page_url);
            let html_paginate = `<li class="page-item" aria-disabled="true" aria-label="« Previous">
                                <a class="page-link" href="javascript:void(0)" data-url="` + pev + `" rel="next" aria-label="Next »">‹</a>
                            </li>
                            <li class="page-item active" aria-current="page"><span class="page-link">` + data.current_page + `</span></li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" data-url="` + next + `" rel="next" aria-label="Next »">›</a>
                            </li>`;
            return html_paginate;
        }

        function compareData(data) {
            var html = "";
            $.each(data.data, function (index, value) {
                let name = value.service != null ? value.service.name : '';
                var name_type = '';
                if (value.type == 0) {
                    name_type = 'Trừ liệu trình';
                }
                if (value.type == 1) {
                    name_type = 'Đã bảo hành';
                }
                if (value.type == 2) {
                    name_type = 'Đang bảo lưu';
                }
                let fullname = value.user && value.user.full_name ?value.user.full_name:'';
                let name_support = value.support && value.support.full_name ?value.support.full_name:'';
                let name_support2 = value.support2 && value.support2.full_name ?' | '+value.support2.full_name:'';
                html += '<tr >' + '<td class="text-center">' + index +1 + '</td>' +
                    '<td class="text-center">' + value.created_at + '</td>' +
                    '<td class="text-center">' + fullname + '</td>' +
                    '<td class="text-center">' + name_support +name_support2 +'</td>' +
                    '<td class="text-center">' + name + '</td>' +
                    '<td class="text-center">' + (value.description ? value.description : '') + '</td>' +
                    '<td class="text-center">' + (name_type ? name_type : '') + '</td>' +
                    '</tr>';
            });
            return html;
        }

    </script>
@endsection

