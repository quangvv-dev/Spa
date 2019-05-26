<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Spa Linh anh, chuyên nghiệp, uy tín...</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        * {
            font-size: 11px;
        }

        body {
            font-family: DejaVu Sans, Arial, Helvetica;
        }

        .logo {
            width: 70px;
            height: 70px;
            float: left;
            margin-right: 15px;
        }

        .padding5 {
            font-weight: bold;
        }

    </style>

</head>
<body>

<div>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="invoice">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="assets/images/brand/logo_login.png" class="logo" alt="">
                        <address style="font-size: 14px">
                            <strong style="font-size: 14px">LINH ANH SPA</strong><br>
                            ĐCGD: . <br>
                            ĐT:
                            - Fax: <br>
                        </address>
                    </div>
                </div>
                <div class="text-center" style="padding: 20px;"><strong style="font-size: 20px">ĐƠN HÀNG BÁN</strong></div>
                <div class="row">
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="trfirst">
                            <td style="width:50%">
                                <b>Tên khách hàng:</b>&nbsp; {{ $orderDetail->user->full_name }}
                            </td>
                            <td style="width:50%">
                                <b>Người thực hiện:</b>&nbsp;{{ $orderDetail->user->marketing->full_name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Địa chỉ:</b>&nbsp;{{ $orderDetail->user->address }}
                            </td>
                            <td style="width:50%">
                                <b>Phòng ban:</b>&nbsp;{{ $orderDetail->user->phone }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Điện thoại:</b>&nbsp;{{ $orderDetail->user->phone }} - <span>Email</span>: {{ $orderDetail->user->email }}
                            </td>
                            <td style="width:50%">
                                <b>Ngày đặt hàng:</b>&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Người nhận:</b>&nbsp;{{ $orderDetail->user->full_name }} - Điện thoại: { $orderDetail->user->phone }}
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
                            <td class="padding5 text-center">STT</td>
                            <td class="padding5 text-center">Mã SP</td>
                            <td class="padding5 text-center">Tên sản phẩm</td>
                            <td class="padding5 text-center">ĐVT</td>
                            <td class="padding5 text-center">SL</td>
                            <td class="padding5 text-center">Giá</td>
                            <td class="padding5 text-center">VAT (%)</td>
                            <td class="padding5 text-center">CK (%)</td>
                            <td class="padding5 text-center">CK (đ)</td>
                            <td class="padding5 text-center">Thành tiền</td>
                        </tr>
                        <tr><input type="hidden" class="product_id" value="16">
                            <td class="tc">1</td>
                            <td class="tc"></td>
                            <td class="tl position">{{ $orderDetail->service->name }}</td>
                            <td class="tc"></td>
                            <td class="tc">{{ $orderDetail->quantity }}</td>
                            <td class="tc">{{ number_format($orderDetail->price) }}</td>
                            <td class="tc">{{ $orderDetail->vat }}</td>
                            <td class="tc">{{ $orderDetail->percent_discount }}</td>
                            <td class="tc">{{ $orderDetail->number_discount }}</td>
                            <td class="tr">{{ number_format($orderDetail->total_price) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Tổng</td>
                            <td class="tr bold">{{ number_format($orderDetail->total_price) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Chiết khấu trước thuế %</td>
                            <td class="tr"></td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Thuế VAT %</td>
                            <td class="tr">{{ $orderDetail->vat }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Phí vận chuyển %</td>
                            <td class="tr"></td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Phí lắp đặt %</td>
                            <td class="tr"></td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Tổng cộng</td>
                            <td class="tr bold"> <strong>{{ number_format($orderDetail->total_price) }}</strong></td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Đã thanh toán</td>
                            <td class="tr bold"> <strong></strong></td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="9">Còn lại</td>
                            <td class="tr bold"> <strong></strong></td>
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
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-xs-1">
                            <strong>
                                Người lập
                            </strong><br>
                            <span>(Ký, họ tên)</span>
                        </div>
                        <div class="col-xs-2" style="width: 12.499999995%">
                            <strong>
                                Khách hàng
                            </strong><br>
                            <span>(Ký, họ tên)</span>
                        </div>
                        <div class="col-xs-1">
                            <strong>
                                NVKD
                            </strong><br>
                            <span>(Ký, họ tên)</span>
                        </div>
                        <div class="col-xs-2" style="width: 12.499999995%">
                            <strong>
                                NV Giao Hàng
                            </strong><br>
                            <span>(Ký, họ tên)</span>
                        </div>
                        <div class="col-xs-1">
                            <strong>
                                Kế Toán
                            </strong><br>
                            <span>(Ký, họ tên)</span>
                        </div>
                        <div class="col-xs-2" style="width: 12.499999995%">
                            <strong>
                                GĐ Kinh Doanh
                            </strong><br>
                            <span>(Ký, họ tên)</span>
                        </div>
                        <div class="col-xs-1">
                            <strong>
                                Giám Đốc
                            </strong><br>
                            <span>(Ký, họ tên)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
