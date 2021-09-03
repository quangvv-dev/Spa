@extends('layout.app')
@php
    $checkRole = checkRoleAlready();
@endphp
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
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
            color: #fff !important;
        }

        .tableFixHead tbody .fixed2 td {
            background: #3b8fec;
            color: #fff !important;
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
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col">
                    <a title="Upload Data" style="position: absolute;right: 0%" href="#" data-toggle="modal"
                       data-target="#myModal">
                        <i class="fas fa-cloud-upload-alt"></i></a>
                    <a title="Tải data" style="position: absolute;right: 3%" class="download" data-value="dowload"
                       href="javascript:void(0)"><i
                            class="fas fa-cloud-download-alt"></i></a>
                </div>
            </div>
            <div class="card-header">
                <div class="col-md-3">
                    @include('order-details.search')
                </div>
                <ul class="col-md-9 no-padd mt5 tr">
                    <li class="display pl5"><a data-time="TODAY" class="choose_time">Hôm nay</a></li>
                    <li class="display pl5"><a data-time="YESTERDAY" class="choose_time">Hôm qua</a></li>
                    <li class="display pl5"><a data-time="THIS_WEEK" class="choose_time">Tuần này</a></li>
                    <li class="display pl5"><a data-time="LAST_WEEK" class="choose_time">Tuần trước</a></li>
                    <li class="display pl5"><a data-time="THIS_MONTH" class="choose_time">Tháng này</a></li>
                    <li class="display pl5"><a data-time="LAST_MONTH" class="choose_time">Tháng trước</a></li>
                    <li class="display position"><a class="other_time  border b-gray">Khác</a>
                        <div class="add-drop add-d-right other_time_panel"
                             style="left: auto; right: 0px; z-index: 999; display: none;"><s class="gf-icon-neotop"></s>
                            <div class="padding tl"><p>Ngày bắt đầu</p>
                                <input type="text" class="form-control filter_start_date" id="datepicker"
                                       data-toggle="datepicker" name="payment_date">
                            </div>
                            <div class="padding tl"><p>Ngày kết thúc</p>
                                <input type="text" class="form-control filter_end_date" id="datepicker"
                                       data-toggle="datepicker" name="payment_date">
                            </div>
                            <div class="padding5-10 tl mb5">
                                <button class="btn btn-info submit_other_time">Tìm kiếm</button>
                                <button class="btn btn-default cancel_other_time">Đóng</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-header">
                <div class="col-md-12">
                    <div class="btn-group ml5" id="more_filters">
                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false"><span
                                class="filter_name">Lọc bổ sung</span> <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a class="tl filter_advanced bor-none" data-filter="unpaid">Chưa thanh toán</a></li>
                            <li><a class="tl filter_paid bor-none" data-filter="paid">Đã thanh toán</a></li>
                        </ul>
                    </div>
                    <div class="btn-group ml5">
                        <button class="btn btn-default order_status" data-status="">Đã hủy</button>
                    </div>
                    <div class="btn-group ml5">
                        {!! Form::select('order_type', $order_type, null, array('class' => 'form-control','id'=>'order_type', 'placeholder'=>'Đơn thường & Liệu trình')) !!}
                    </div>
                    <div class="btn-group ml5">
                        {!! Form::select('role_type', [1=>'Dịch vụ',2=>'Sản phẩm',3=>'Combo'], null, array('class' => 'form-control role_type', 'placeholder'=>'Tất cả đơn')) !!}
                    </div>
                    @if(empty($checkRole))
                        <div class="btn-group ml5">
                            {!! Form::select('branch_id', $branchs, null, array('class' => 'form-control branch_id', 'placeholder'=>'Tất cả chi nhánh')) !!}
                        </div>
                    @endif
                </div>
            </div>
            <div id="registration-form">
                @include('order-details.ajax')
            </div>
        </div>
    </div>
    <input type="hidden" id="group">
    <input type="hidden" id="telesales">
    <input type="hidden" id="marketing">
    <input type="hidden" id="customer">
    <input type="hidden" id="service">
    <input type="hidden" id="payment-type">
    <input type="hidden" id="choose-time">
    <input type="hidden" id="filter-start-date">
    <input type="hidden" id="filter-end-date">
    <input type="hidden" id="bor-none">
    <input type="hidden" id="order-status">
    <input type="hidden" id="order-type">
    <input type="hidden" id="role_type">
    <input type="hidden" id="phone">
    <input type="hidden" id="branch_id">
    @include('order-details.modal-upload-excel')
@endsection
@section('_script')
    <script type="text/javascript">
        function searchAjax(data) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{ Url('list-orders/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        }

        $(document).on('click', '#applyBoxSearch, .choose_time, .submit_other_time, .bor-none, .download', function (e) {
            e.preventDefault();
            let target = $(e.target).parent();
            const class_name = $(this).attr("class");
            const group = $('.group').val();
            const telesales = $('.telesales').val();
            const marketing = $('.marketing').val();
            const customer = $('.customer').val();
            const service = $('.service').val();
            const payment_type = $('.payment-type').val();
            const start_date = $('.filter_start_date').val();
            const end_date = $('.filter_end_date').val();
            const order_type = $('#order-type').val();
            const role_type = $('#role_type').val();
            const phone = $('.phone').val();
            const branch_id = $('.branch_id').val();
            var bor_none = '';
            if (class_name == 'choose_time') {
                var data_time = $(target).find('.choose_time').data('time');
                $('a.choose_time').removeClass('border b-gray');
                $('a.other_time').removeClass('border b-gray');
                $(target).find('.choose_time').addClass('border b-gray');
            } else {
                var data_time = $('#choose_time').val();
            }
            if (class_name == 'tl filter_advanced bor-none') {
                bor_none = $(target).find('.bor-none').data('filter');
                $('#bor-none').val(bor_none);
            } else {
                bor_none = $('#bor-none').val();
            }
            $('#group').val(group);
            $('#role_type').val(role_type);
            $('#phone').val(phone);
            $('#telesales').val(telesales);
            $('#marketing').val(marketing);
            $('#customer').val(customer);
            $('#service').val(service);
            $('#payment-type').val(payment_type);
            $('#filter-start-date').val(start_date);
            $('#filter-end-date').val(end_date);
            $('#branch_id').val(branch_id);
            if (typeof (data_time) != "undefined") {
                $('#choose-time').val(data_time);
            }
            if (typeof (bor_none) != "undefined") {
                $('#bor-none').val(bor_none);
            }
            $(".other_time_panel").css({'display': 'none'});
            $("#boxSearch").css({'display': 'none'});
            if (class_name == 'download') {
                let time_up = $('#choose-time').val();

                if (typeof (time_up) == "undefined") {
                    time_up = 'THIS_MONTH';
                }
                let url = location.origin + '/list-orders/?group=' + group + '&telesales=' + telesales + '&marketing=' + marketing + '&customer='
                    + customer + '&service=' + service + '&payment_type=' + payment_type + '&data_time=' + time_up + '&start_date=' + start_date
                    + '&end_date=' + end_date + '&bor_none=' + bor_none + '&order_type=' + order_type + '&role_type=' + role_type + '&phone=' + phone
                    + '&download=1'
                ;
                location.href = url;
            }

            searchAjax({
                group: group,
                telesales: telesales,
                marketing: marketing,
                customer: customer,
                service: service,
                payment_type: payment_type,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                bor_none: bor_none,
                order_type: order_type,
                role_type: role_type,
                phone: phone,
                branch_id: branch_id,
            });
        })
        ;

        $(document).on('change', '#order_type', function () {
            const order_type = $('#order_type').val();
            const group = $('#group').val();
            const telesales = $('#telesales').val();
            const marketing = $('#marketing').val();
            const customer = $('#customer').val();
            const service = $('#service').val();
            const payment_type = $('#payment-type').val();
            const data_time = $('#choose-time').val();
            const start_date = $('#filter-start-date').val();
            const end_date = $('#filter-end-date').val();
            const bor_none = $('#bor-none').val();
            const phone = $('#phone').val();
            const role_type = $('#role_type').val();
            const branch_id = $('.branch_id').val();
            $('#order-type').val(order_type);
            $('#role_type').val(role_type);

            searchAjax({
                group: group,
                telesales: telesales,
                marketing: marketing,
                customer: customer,
                service: service,
                payment_type: payment_type,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                bor_none: bor_none,
                order_type: order_type,
                role_type: role_type,
                phone: phone,
                branch_id: branch_id,
            });
        });

        $(document).on('change', '.role_type', function () {
            const order_type = $('#order_type').val();
            const group = $('#group').val();
            const telesales = $('#telesales').val();
            const marketing = $('#marketing').val();
            const customer = $('#customer').val();
            const service = $('#service').val();
            const payment_type = $('#payment-type').val();
            const data_time = $('#choose-time').val();
            const start_date = $('#filter-start-date').val();
            const end_date = $('#filter-end-date').val();
            const bor_none = $('#bor-none').val();
            const phone = $('#phone').val();
            const role_type = $('.role_type').val();
            const branch_id = $('.branch_id').val();

            $('#role_type').val(role_type);

            searchAjax({
                group: group,
                telesales: telesales,
                marketing: marketing,
                customer: customer,
                service: service,
                payment_type: payment_type,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                bor_none: bor_none,
                order_type: order_type,
                role_type: role_type,
                phone: phone,
                branch_id: branch_id,
            });
        });

        $(document).on('change', '.branch_id', function () {
            const order_type = $('#order_type').val();
            const group = $('#group').val();
            const telesales = $('#telesales').val();
            const marketing = $('#marketing').val();
            const customer = $('#customer').val();
            const service = $('#service').val();
            const payment_type = $('#payment-type').val();
            const data_time = $('#choose-time').val();
            const start_date = $('#filter-start-date').val();
            const end_date = $('#filter-end-date').val();
            const bor_none = $('#bor-none').val();
            const phone = $('#phone').val();
            const role_type = $('.role_type').val();
            const branch_id = $('.branch_id').val();

            $('#role_type').val(role_type);

            searchAjax({
                group: group,
                telesales: telesales,
                marketing: marketing,
                customer: customer,
                service: service,
                payment_type: payment_type,
                data_time: data_time,
                start_date: start_date,
                end_date: end_date,
                bor_none: bor_none,
                order_type: order_type,
                role_type: role_type,
                phone: phone,
                branch_id: branch_id,
            });
        });

        $(document).on('click', '.order-detail-modal', function (e) {
            e.preventDefault();
            $('.list1').empty();
            $('.customer-info').empty();
            $('.task_footer_box').empty();
            const id = $(this).data('order-id');

            $.ajax({
                url: "{{ Url('ajax/order-details/') }}" + '/' + id,
                method: "get",
            }).done(function (data) {
                let html = '';
                let html1 = '';

                html1 += `<div class="row">
                    <div class="col-md-6">
                        <p>Tên KH: ` + data.order.customer.full_name + `</p>
                        <p>SDT: ` + data.order.customer.phone + `</p>
                    </div>
                    <div class="col-md-6">
                        <p>Người thực hiện đơn hàng: ` + (data.order.spa_therapisst ? data.order.spa_therapisst.full_name : '') + `</p>
                        <p>Người phụ trách: ` + (data.order.customer.telesale ? data.order.customer.telesale.full_name : '') + `</p>
                    </div>
                </div>`;

                data.order_details.forEach(function (item) {
                    html += '<tr>' +
                        '<td class="tc">' + item.service.name + '</td>' +
                        '<td class="tc">' + item.quantity + '</td>' +
                        '<td class="tc">' + item.total_price + '</td>' +
                        '<td class="tc">' + item.number_discount + '</td>' +
                        '<td class="tc">' + item.total_price + '</td>' +
                        '</tr>';
                });

                $('.customer-info').append(html1);
                $('.list1').append(html);
                $('.task_footer_box').append(`
                    <button class="btn btn-primary ml5"><a class="white link-order" href="" style="color: #ffffff">&nbsp;Sửa đổi</a>
                    </button>
                `);
                if (data.order.role_type != 2) {
                    $(".link-order").attr("href", "orders-service/" + data.order.id + "/edit");
                } else {
                    $(".link-order").attr("href", "orders/" + data.order.id + "/edit");
                }
                $('#orderDetailModal').modal("show");
            });
        });

        $(document).on('click', '.other_time', function () {
            $(".other_time_panel").css({'display': ''});
        });

        $(document).on('click', '.cancel_other_time', function () {
            $(".other_time_panel").css({'display': 'none'});
        });

        $(document).on('click', '#showBoxSearch', function () {
            $("#boxSearch").css({'display': ''});
        });

        $(document).on('click', '#closeBoxSearch', function () {
            $("#boxSearch").css({'display': 'none'});
        });

        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });

        $(document).on('click', '.order_status', function () {
            $('.order_status').data('status', 0);
            const order_cancel = $('.order_status').data('status');
            $('#order-status').val(order_cancel);

            searchAjax({
                order_cancel: order_cancel
            });
        });

        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            const order_type = $('#order_type').val();
            const role_type = $('#role_type').val();
            const group = $('#group').val();
            const telesales = $('#telesales').val();
            const marketing = $('#marketing').val();
            const customer = $('#customer').val();
            const service = $('#service').val();
            const payment_type = $('#payment-type').val();
            const data_time = $('#choose-time').val();
            const start_date = $('#filter-start-date').val();
            const end_date = $('#filter-end-date').val();
            const bor_none = $('#bor-none').val();
            const phone = $('#phone').val();
            const branch_id = $('.branch_id').val();
            $.ajax({
                url: '{{ url()->current() }}',
                method: "get",
                data: {
                    group: group,
                    telesales: telesales,
                    marketing: marketing,
                    customer: customer,
                    service: service,
                    payment_type: payment_type,
                    data_time: data_time,
                    start_date: start_date,
                    end_date: end_date,
                    bor_none: bor_none,
                    order_type: order_type,
                    role_type: role_type,
                    phone: phone,
                    page: pages,
                    branch_id: branch_id,
                },
            }).done(function (data) {
                $('#registration-form').html(data);
            }).fail(function () {
                alert('Articles could not be loaded.');
            });
        });
    </script>
@endsection
