@extends('layout.app')
@section('_style')
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
        #registration-form{
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
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thống kê hoa hồng</h3>
            <div class="col-md-10">
                <ul class="col-md-9 no-padd mt5 tr right">
                    {{--<li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>--}}
                    {{--<li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>--}}
                    <li class="display pl5"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH"
                                               class="display padding0-5 btn_choose_time border b-gray">Tháng
                            này</a>
                    </li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng trước</a></li>
                </ul>
            </div>
        </div>
        <input type="hidden" id="time_choose" value="THIS_MONTH">
        <input type="hidden" id="user_id" value="0">
        <input type="hidden" id="user_id" value="0">
        <div id="registration-form">
            @include('report_products.ajax_commision')
        </div>
        {{--@include('report_products.commision_modal')--}}
    </div>
@endsection
@section('_script')
    <script>
        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: window.location.href,
                method: "get",
                data: data,
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        function urlParam(name, url) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            console.log(results, 'results')
            if (results == null) {
                return null;
            } else {
                return results[1] || 0;
            }
        }

        $(document).on('click', '.btn_choose_time, .submit_other_time', function (e) {
            let target = $(e.target).parent();
            $('a.btn_choose_time').removeClass('border b-gray');
            $(target).find('.btn_choose_time').addClass('border b-gray');
            const data_time = $(target).find('.btn_choose_time').data('time');
            $('#time_choose').val(data_time).change();
            searchAjax({data_time: data_time})
        });

        $(document).on('click', '#click_detail', function (e) {
            let id = $(this).data('id');
            $('#user_id').val(id).change();
            let time = $('#time_choose').val();
            var html = "";
            $.ajax({
                url: '/ajax/commission',
                method: "get",
                data: {user_id: id, data_time: time},
            }).done(function (data) {
                $.each(data.data, function (index, value) {
                    html += ` <tr>
                    <th scope="row">` + index + `</th>
                    <td class="text-center">` + value.orders.created_at + `</td>
                    <td class="text-center">` + value.earn.toLocaleString('ja-JP') + `</td>
                    <td class="text-center">` + value.orders.all_total.toLocaleString('ja-JP') + `</td>
                    <td class="text-center">` + value.orders.gross_revenue.toLocaleString('ja-JP') + `</td>
                </tr>`;
                });

                let next = urlParam('page', data.next_page_url);
                let pev = urlParam('page', data.prev_page_url);
                let html_paginate = `<li class="page-item" aria-disabled="true" aria-label="« Previous">
                                <a class="page-link" href="javascript:void(0)" data-url="` + pev + `" rel="next" aria-label="Next »">‹</a>
                            </li>
                            <li class="page-item active" aria-current="page"><span class="page-link">` + data.current_page + `</span></li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" data-url="` + next + `" rel="next" aria-label="Next »">›</a>
                            </li>`;
                $('.pagination').html(html_paginate);
                $('#get_data').html(html);
                $('#myModal').modal('show');
            });
        })

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
                $.each(data.data, function (index, value) {
                    html += ` <tr>
                    <th scope="row">` + index + `</th>
                    <td class="text-center">` + value.orders.created_at + `</td>
                    <td class="text-center">` + value.earn.toLocaleString('ja-JP') + `</td>
                    <td class="text-center">` + value.orders.all_total.toLocaleString('ja-JP') + `</td>
                    <td class="text-center">` + value.orders.gross_revenue.toLocaleString('ja-JP') + `</td>
                </tr>`;
                });

                let next = urlParam('page', data.next_page_url);
                let pev = urlParam('page', data.prev_page_url);
                let html_paginate = `<li class="page-item" aria-disabled="true" aria-label="« Previous">
                                <a class="page-link" href="javascript:void(0)" data-url="` + pev + `" rel="next" aria-label="Next »">‹</a>
                            </li>
                            <li class="page-item active" aria-current="page"><span class="page-link">` + data.current_page + `</span></li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" data-url="` + next + `" rel="next" aria-label="Next »">›</a>
                            </li>`;
                $('.pagination').html(html_paginate);
                $('#get_data').html(html);
                $('#myModal').modal('show');
            })
        })

    </script>
@endsection

