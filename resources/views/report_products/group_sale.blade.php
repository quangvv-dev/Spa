@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <style>

        .tableFixHead {
            overflow-y: auto;
            height: 800px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
        }

        .tableFixHead thead .number_index th {
            position: sticky;
            top: 110px;
        }

        .tableFixHead thead .number_index2 th {
            position: sticky;
            top: 122px;
        }

        @media (min-width: 1681px) {
            .tableFixHead thead .number_index th {
                position: sticky;
                top: 91px;
            }
        }

        .tableFixHead thead .tr1 th {
            position: sticky;
            top: 36px;
        }


        .tableFixHead tbody tr {
            position: sticky;
            top: 0;
        }

        .tableFixHead tbody .fixed th {
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
            background: #3b8fec;
        }

        .tableFixHead tbody .fixed th {
            background: #3b8fec;
        }

        .tableFixHead tbody .fixed2 td {
            background: #3b8fec;
        }

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
    </style>

@endsection
@section('content')

    <div class="col-md-12">
        <div id="fix-scroll" class="row padding mb10 header-card border-bot shadow" style="width: 100%; padding: 10px;">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4 no-padd">
                        <ul class="fr mg0 pt10 no-padd">
                            <li class="display pl5"><a data-time="THIS_WEEK"
                                                       class="btn_choose_time border b-gray active">Tuần này</a></li>
                            <li class="display pl5"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần trước</a></li>
                            <li class="display pl5"><a data-time="THIS_MONTH" class="btn_choose_time ">Tháng này</a></li>
                            <li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng trước</a></li>
                        </ul>
                        <input type="hidden" id="time_choose" value="THIS_WEEK">
                    </div>
                    <div class="col-md-2" style="position: absolute;right: 5%">
                        {{Form::select('type',$telesales, null, array('class' => 'form-control','id'=>'telesales','placeholder'=>'Tất cả nhân viên'))}}
                    </div>
                    <div class="col-md-2" style="position: absolute;right: 21%">
                        {{Form::select('branch_id',$branchs, null, array('class' => 'form-control','id'=>'branch_id','placeholder'=>'Tất cả chi nhánh'))}}
                    </div>
                    <a title="Download Data" style="position: absolute;right: 2%" class="btn download-pdf"
                       href="javascript:void(0)">
                        <i class="fas fa-download"></i></a>
                </div>
                <div class="col-md-12 col-lg-12 list-data">
                    @include('report_products.ajax_group')
                </div>
            </div>
        </div>
    </div>

@endsection
@section('_script')
    <script>
        function searchAjax(data) {
            $('.list-data').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: window.location.href,
                method: "get",
                data: data,
            }).done(function (data) {
                $('.list-data').html(data);
            });
        }

        $(document).on('click', '.download-pdf', function (e) {
            let time_choose = $('#time_choose').val();
            let telesales = $('#telesales').val();
            let url = location.href + '?data_time=' + time_choose + '&telesale_id=' + telesales + '&dowload_pdf=1';
            location.href = url;
        });
        $(document).on('click', '.btn_choose_time, .submit_other_time', function (e) {
            let target = $(e.target).parent();
            $('a.btn_choose_time').removeClass('border b-gray');
            $(target).find('.btn_choose_time').addClass('border b-gray');
            const data_time = $(target).find('.btn_choose_time').data('time');
            $('#time_choose').val(data_time).change();
            const telesales = $('#telesales').val();
            let branch_id = $('#branch_id').val();
            searchAjax({data_time: data_time, telesale_id: telesales, branch_id: branch_id})
        });

        $('#telesales').change(function () {
            let value = $(this).val();
            let data_time = $('#time_choose').val();
            let branch_id = $('#branch_id').val();
            searchAjax({data_time: data_time, telesale_id: value , branch_id: branch_id})
        })

        $('#branch_id').change(function () {
            let value = $(this).val();
            let telesales = $('#telesales').val();;
            let data_time = $('#time_choose').val();
            searchAjax({data_time: data_time, telesale_id: telesales, branch_id: value})
        })
    </script>
@endsection

