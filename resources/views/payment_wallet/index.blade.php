@extends('layout.app')
@section('_style')
    <link href="{{ asset(('css/order.css')) }}" rel="stylesheet"/>
    <style>
        a.white {
            color: #fff;
        }
        .fz-12{
            font-size: 12px;
        }
        td.mb5{
            padding: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="row" style="">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="invoice">
                <div class="text-center"><strong style="font-size: 20px">ĐƠN HÀNG NẠP THẺ</strong></div>
                <div class="row">
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="trfirst">
                            <td style="width:50%">
                                <b>Tên khách hàng:</b>&nbsp; <a class="blue"
                                                                href="{{url('customers/'.$order->customer->id)}}">{{ @$order->customer->full_name }}</a>
                            </td>
                            <td style="width:50%">
                                <b>Người lên đơn:</b>&nbsp;{{ @$order->user->full_name }}
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
                                <b>Ngày tạo đơn:</b>&nbsp; {{ date('d-m-Y', strtotime($order->created_at)) }}&emsp;

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
                            <td class="padding5">Gói nạp</td>
                            <td class="padding5">Số lượng</td>
                            <td class="padding5">Đơn giá</td>
                            <td class="padding5">VAT (%)</td>
                            <td class="padding5">CK (%)</td>
                            <td class="padding5">CK (đ)</td>
                            <td class="padding5">Thành tiền</td>
                        </tr>
                            <tr><input type="hidden" class="product_id" value="16">
                                <td class="tc">1</td>
                                <td class="tl position"><a class="blue" href="#">{{ @$order->package->name }}</a>
                                </td>
                                <td class="tc">1</td>
                                <td class="tc">{{ number_format(@$order->order_price) }}</td>
                                <td class="tc">0</td>
                                <td class="tc">0</td>
                                <td class="tc">0</td>
                                <td class="tr">{{ number_format(@$order->order_price) }}</td>
                            </tr>
                        <tr>
                            <td class="font-bold" colspan="7">Khuyến mại (voucher)</td>
                            <td class="tr bold">0</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="7">Tổng cộng</td>
                            <td class="tr bold"> {{ number_format($order->order_price) }}</td>
                        </tr>
                        </tbody>
                    </table>
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
                        <table style="width: 100%">
                            <thead>
                            <tr>
                                <th width="56%"></th>
                                <th width="44%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="mb5">Doanh số:</td>
                                <td class="tr mb5" id="all_total">{{ number_format($order->order_price) }}</td>
                            </tr>
                            <tr>
                                <td class="mb5">Đã thanh toán:</td>
                                <td class="tr mb5" id="gross_revenue">{{ number_format($order->gross_revenue) }}</td>
                            </tr>

                            <tr>
                                <td class="mb5">Còn lại:</td>
                                <td class="tr mb5" id="the_rest">{{ number_format($order->order_price - $order->gross_revenue) }}</td>
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
            <div class="fl task_footer_box cancel_order">
                <button class="btn btn-default fr ml5">
                    <a href="{{route('order.list')}}">Trở lại</a>
                </button>
            </div>
        </div>
    </div>
    @include('payment_wallet.modal')
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

        $(document).on('click', '#finish_wallet', function () {
            let the_rest = replaceNumber($('.title-total').html());
            if (parseInt(the_rest) <= 0){
                return false;
            }
            let paymentDate = $('.payment-date').val();
            let paymentType = $('.payment-type').val();
            let grossRevenue = $('.gross-revenue').val();
            let description = $('.description').val();
            let order_wallet_id = '{{@$order->id}}';

            $.ajax({
                url: "{{ Url('payment-wallet') }}",
                method: "post",
                data: {
                    payment_date: paymentDate,
                    payment_type: paymentType,
                    gross_revenue: replaceNumber(grossRevenue),
                    description: description,
                    order_wallet_id: order_wallet_id,
                }
            }).done(function () {
                window.location.reload();
            });
        });

        $(document).on('focusout', '.gross-revenue', function () {
            let grossRevenue = $('.gross-revenue').val();
            let the_rest = {{$order->order_price - $order->gross_revenue}} - replaceNumber(grossRevenue);
            $(".cash").text(formatNumber(grossRevenue));

            $('.remain_cash').text(formatNumber(the_rest));
            // $('.return_cash').text(formatNumber(data.return_cash));
        });
    </script>
@endsection
