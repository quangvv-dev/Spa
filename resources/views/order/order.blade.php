<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Spa Linh anh, chuyên nghiệp, uy tín...</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .page-break {
            page-break-after: always;
        }

        .bg-grey {
            background: #F3F3F3;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }

        .w-full {
            width: 100%;
        }

        .small-width {
            width: 15%;
        }

        .invoice {
            background: white;
            border: 1px solid #CCC;
            font-size: 14px;
            padding: 48px;
            margin: 20px 0;
        }

        .logo {
            width: 80px;
            height: 80px;
            float: left;
            margin-right: 15px;
        }

        .text-center {
            padding: 25px;
        }
    </style>
</head>

<body class="bg-grey">
    <div class="container container-smaller">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1" style="margin-top:20px; text-align: right">
                <div class="btn-group mb-4">
                    <a href="/order-pdf/{{$order->id}}" class="btn btn-success">Lưu File PDF</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="invoice">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="{{asset('assets/images/brand/logo_login.png')}}" class="logo" alt="">
                            <address>
                                <strong style="font-size: 15px">LINH ANH SPA</strong><br>
                                ĐCGD: . <br>
                                ĐT:
                                - Fax: <br>
                            </address>
                        </div>
                    </div>
                    <div class="text-center"><strong style="font-size: 20px">ĐƠN HÀNG BÁN</strong></div>
                    <div class="row">
                        <table class="table table-bordered">
                            <tbody>
                            <tr class="trfirst">
                                <td style="width:50%">
                                    <b>Tên khách hàng:</b>&nbsp; <a class="blue" href="#/crm/view_account/877">{{ $order->user->full_name }}</a>
                                </td>
                                <td style="width:50%">
                                    <b>Người thực hiện:</b>&nbsp;{{ $order->user->marketing->full_name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%">
                                    <b>Địa chỉ:</b>&nbsp;{{ $order->user->address }}
                                </td>
                                <td style="width:50%">
                                    <b>Phòng ban:</b>&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%">
                                    <b>Điện thoại:</b>&nbsp;{{ $order->user->phone }} - <span>Email</span>: {{ $order->user->email }}
                                </td>
                                <td style="width:50%">
                                    <b>Ngày đặt hàng:</b>&nbsp; {{ date('d-m-Y', strtotime($order->created_at)) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%">
                                    <b>Người nhận:</b>&nbsp;{{ $order->user->full_name }} - Điện thoại:
                                    <a class="__clickToCall blue" data-phone="0932148915" data-type="crm"
                                       data-call="order_222" data-contact-id="896">{{ $order->user->phone }}</a>
                                </td>
                                <td style="width:50%">
                                    <b>Phương thức thanh toán:</b>&nbsp;
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
                                <td class="tl position"><a class="blue" href="#/crm/product/16/detail">{{ $orderDetail->service->name }}</a>
                                </td>
                                <td class="tc"></td>
                                <td class="tc">{{ $orderDetail->quantity }}</td>
                                <td class="tc">{{ number_format($orderDetail->service->price_sell) }}</td>
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
        </div>
    </div>
</body>

</html>
