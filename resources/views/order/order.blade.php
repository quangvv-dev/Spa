@extends('layout.app')
@section('_style')
    <link href="{{ asset(('css/order.css')) }}" rel="stylesheet"/>
    <style>
        a.white {
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <div class="row" style="">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="invoice">
                <div class="text-center"><strong style="font-size: 20px">ĐƠN HÀNG BÁN</strong></div>
                <div class="row">
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="trfirst">
                            <td style="width:50%">
                                <b>Tên khách hàng:</b>&nbsp; <a class="blue"
                                                                href="#/crm/view_account/877">{{ @$order->customer->full_name }}</a>
                            </td>
                            <td style="width:50%">
                                <b>Người thực hiện:</b>&nbsp;{{ @$order->customer->marketing->full_name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Địa chỉ:</b>&nbsp;{{ @$order->customer->address }}
                            </td>
                            <td style="width:50%">
                                <b>Phòng ban:</b>&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Điện thoại:</b>&nbsp;{{ @$order->customer->phone }} -
                            </td>
                            <td style="width:50%">
                                <b>Ngày đặt hàng:</b>&nbsp; {{ date('d-m-Y', strtotime($order->created_at)) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Người nhận:</b>&nbsp;{{ @$order->customer->full_name }} - Điện thoại:
                                <a class="__clickToCall blue" data-phone="0932148915" data-type="crm"
                                   data-call="order_222" data-contact-id="896">{{ @$order->customer->phone }}</a>
                            </td>
                            <td style="width:50%">
                                <b>Phương thức thanh toán:</b>&nbsp;{{@$order->name_payment_type}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered mt10">
                        <tbody>
                        <tr class="bold b-gray">
                            <td class="padding5">STT</td>
                            <td class="padding5">Mã sản phẩm</td>
                            <td class="padding5">Tên sản phẩm</td>
                            <td class="padding5">Đơn vị tính</td>
                            <td class="padding5">Số lượng</td>
                            <td class="padding5">Đơn giá</td>
                            <td class="padding5">VAT (%)</td>
                            <td class="padding5">CK (%)</td>
                            <td class="padding5">CK (đ)</td>
                            <td class="padding5">Thành tiền</td>
                        </tr>
                        @foreach($order->orderDetails as $key => $orderDetail)
                            <tr><input type="hidden" class="product_id" value="16">
                                <td class="tc">{{ $key + 1 }}</td>
                                <td class="tc"></td>
                                <td class="tl position"><a class="blue"
                                                           href="#/crm/product/16/detail">{{ @$orderDetail->service->name }}</a>
                                </td>
                                <td class="tc"></td>
                                <td class="tc">{{ $orderDetail->quantity }}</td>
                                <td class="tc">{{ number_format(@$orderDetail->service->price_sell) }}</td>
                                <td class="tc">{{ $orderDetail->vat }}</td>
                                <td class="tc">{{ $orderDetail->percent_discount }}</td>
                                <td class="tc">{{ number_format($orderDetail->number_discount) }}</td>
                                <td class="tr">{{ number_format($orderDetail->total_price) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="font-bold" colspan="9">Tổng</td>
                            <td class="tr bold">{{ number_format($order->all_total) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Chiết khấu trước thuế %</td>
                            <td class="tr">0</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Thuế VAT %</td>
                            <td class="tr"></td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Phí vận chuyển %</td>
                            <td class="tr">0</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Phí lắp đặt %</td>
                            <td class="tr">0</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Tổng cộng</td>
                            <td class="tr bold"> {{ number_format($order->all_total) }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="require-order">
                        <div class="pt10 pb5 bold bor-bot-matt mb10">
                            <strong>
                                Điều khoản đi kèm
                            </strong>
                        </div>
                        <div>
                            <div><span>1. Thời gian giao hàng:</span></div>
                            <div><span>2. Địa điểm giao hàng:</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 no-padd bor-r" id="right_panel">
            <div>
                <div class="col-md-12 no-padd box-cont">
                    <div id="attachments" class="files padding">
                        <div>
                            <div id="progress" class="progress" style="display:none">
                                <div class="progress-bar progress-bar-success" role="progressbar"></div>
                            </div>
                            <div id="files" class="files"></div>
                        </div>
                    </div>
                </div>
                <div class="box-cont col-md-12 no-padd content-pay"><h3
                            class="bor-bot uppercase font12 mg0 bold padding5">Thanh toán</h3>
                    <div class="padding col-md-12">
                        <table>
                            <thead>
                            <tr>
                                <th width="56%"></th>
                                <th width="44%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="mb5">Doanh số:</td>
                                <td class="tr mb5" id="all_total">{{ number_format($order->all_total) }}</td>
                            </tr>
                            <tr>
                                <td class="mb5">Doanh thu:</td>
                                <td class="tr mb5" id="gross_revenue">{{ number_format($order->gross_revenue) }}</td>
                            </tr>
                            <tr>
                                <td class="mb5">Thực tế phải thanh toán:</td>
                                <td class="tr mb5" id="all_total1">{{ number_format($order->all_total) }}</td>
                            </tr>
                            <tr>
                                <td class="mb5">Đã thanh toán:</td>
                                <td class="tr mb5" id="gross_revenue1">{{ number_format($order->gross_revenue) }}</td>
                            </tr><tr>
                                <td class="mb5">Còn lại:</td>
                                <td class="tr mb5" id="the_rest">{{ number_format($order->the_rest) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div class="detail-pay-dvh position col-md-12 no-padd">
                @include('order.payment-history')
            </div>
        </div>
    </div>

    <div class="fixed-bottom">
        <div class="list_task_footer col-md-12 padding menu-footer">
            <div class="fl task_footer_box">
                <button class="btn btn-info ml5 fr paymentOrder" data-toggle="modal" data-target="#paymentModal"><a
                            class="white">Thanh toán</a></button>
            </div>
            <div class="btn-group dropup fl task_footer_box">
                <button class="btn btn-success ml5 printOrder" data-number="2"><a class="white" href="/order-pdf/{{$order->id}}"><i
                                class="fa fa-print"></i>&nbsp;In</a>
                </button>
            </div>
            <div class="btn-group dropup fl task_footer_box">
                <button class="btn btn-warning ml5" data-number="2"><a class="white" href="/commission/{{$order->id}}"><i
                                class="fas fa-dollar-sign"></i>&nbsp;Hoa hồng</a>
                </button>
            </div>
            <div class="fl task_footer_box cancel_order">
                <button class="btn btn-default fr ml5">
                    <a href="{{route('order.list')}}">Trở lại</a>
                </button>
            </div>
        </div>
    </div>
    @include('order.modal')
@endsection
@section('_script')
    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });

        $(document).on('click', '#finish', function () {
            let paymentDate = $('.payment-date').val();
            let paymentType = $('.payment-type').val();
            let grossRevenue = $('.gross-revenue').val();
            let description = $('.description').val();

            $.ajax({
                url: "{{ Url('order/'.$order->id. '/show') }}",
                method: "put",
                data: {
                    payment_date: paymentDate,
                    payment_type: paymentType,
                    gross_revenue: grossRevenue,
                    description: description
                }
            }).done(function () {
                // window.location.reload();
            });
        });

        $(document).on('focusout', '.gross-revenue', function () {
            let grossRevenue = $('.gross-revenue').val();

            $.ajax({
                url: "{{ Url('ajax/info-order-payment/'.$order->id) }}",
                method: "get",
                data: {
                    gross_revenue: grossRevenue
                }
            }).done(function (data) {
                $(".cash").text(formatNumber(data.cash));
                $('.remain_cash').text(formatNumber(data.remain_cash));
                $('.return_cash').text(formatNumber(data.return_cash));
            });
        });
    </script>
@endsection
