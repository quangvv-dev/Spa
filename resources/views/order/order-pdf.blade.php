<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .font12 {
            font-size: 10px;
        }

        body {
            font-family: system-ui;
        }
        strong{
            font-size: 12px;
            font-weight: 600;
        }
        b{
            font-size: 12px;
        }

        h3{
            margin: 0;
        }

        td {
            padding: 4px !important;
            border: none !important;
        }

        .table-bordered {
            border-top: dotted 1px;
            border-bottom: dotted 1px;
            border-right: none;
            border-left: none;
        }

        .mt0 {
            margin-bottom: 0px;
        }
    </style>

</head>
<body id="appBanner">


<div class="invoice">
    <div class="row">
        @if(isset($payment))
            <div class="col-xs-12">
                <table class="table mt0">
                    <tbody>
                    <tr>
                        <td colspan="2" class="text-center"><h3>{{!empty(setting('title_website'))?setting('title_website'):'Hệ Thống Royal Spa'}}</h3><br></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><b >ĐƠN HÀNG BÁN</b></td>
                    </tr>
                    <tr class="font12">
                        <td class="padding5">Ngày : {{isset($payment)? date('d-m-Y', strtotime($payment->payment_date)):'' }}</td>
                        <td class="padding5">HĐ: {{ $order->code }}</td>
                    </tr>
                    <tr class="font12">
                        <td class="padding5">Khách hàng : {{ @$order->customer->full_name }}</td>
                        <td class="padding5">SĐT: {{ @$order->customer->phone }}</td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-bordered mt10">
                    <tbody>
                    <tr class="bold b-gray">
                        <td class="padding5"><strong>Dịch vụ</strong></td>
                        <td class="padding5"><strong>Đơn giá</strong></td>
                        <td class="padding5"><strong>SL</strong></td>
                        <td class="padding5"><strong>T.Tiền</strong></td>
                    </tr>
                    @php
                    @endphp
                    @foreach($order->orderDetails as $key => $orderDetail)
                        <tr class="font12">
                            <td class="tl position">{{ $orderDetail->service->name }}</td>
                            @if($orderDetail->number_discount > 0)
                                <td class="tc">
                                    {{@number_format((int)$orderDetail->price - (int)((int)$orderDetail->number_discount/(int)$orderDetail->quantity))}}
                                    <br>
                                    <div style="text-decoration: line-through;">
                                        {{ number_format($orderDetail->price)}}
                                    </div>
                                </td>
                            @else
                                <td class="tc">
                                    {{ number_format($orderDetail->price)}}
                                </td>
                            @endif

                            <td class="tc">{{ $orderDetail->days > 0 ? $orderDetail->days : $orderDetail->quantity }}</td>
                            <td class="tr">{{ number_format($orderDetail->total_price) }}
                                {{--<br>--}}
                                {{--<div style="text-decoration: line-through;">--}}
                                    {{--{{$orderDetail->days > 0? number_format($orderDetail->price * 1):number_format((int)$orderDetail->price * (int)$orderDetail->quantity)}}--}}
                                {{--</div>--}}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="bold" colspan="3"><strong>Giảm giá</strong></td>
                        <td class="tr bold"><strong>{{@$order->discount_order >0? @number_format($order->discount_order): number_format($order->discount_once_service)}}</strong></td>
                    </tr>
                    <tr>
                        <td class="font-bold" colspan="3"><strong>Tổng Tiền</strong></td>
                        <td class="tr bold"><strong>{{ @number_format($order->all_total) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="font-bold" colspan="4"><strong>Khách T.Toán</strong></td>
                    </tr>
                    <tr>
                        <td class="font12" colspan="3">{{$payment->payment_type==1?'Tiền mặt':($payment->payment_type==2?'Thẻ':($payment->payment_type==4?'Chuyển khoản':'Điểm'))}}</td>
                        <td class="tr bold"><strong>{{ @number_format($payment->price) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="font-bold" colspan="3"><strong>Còn lại</strong></td>
                        <td class="tr bold"><strong>{{ number_format($order->the_rest) }}</strong></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td style="padding: 0px !important;" class="font-bold" colspan="2"><strong>Khách hàng</strong></td>
                        <td style="padding: 0px !important;" class="tr bold" colspan="2"><strong>Nhân viên</strong></td>
                    </tr>
                    <tr class="font12">
                        <td style="padding: 0px !important;" class="font-bold" colspan="2"><i>(Chữ ký)</i></td>
                        <td style="padding: 0px !important;" class="tr bold" colspan="2"><i>(Chữ ký)</i></td>
                    </tr>
                    <tr style="margin-top: 10px">
                        <td><p></p><p></p></td>
                    </tr>
                    {{--<tr>--}}
                    {{--<td style="border-bottom:dotted 1px !important;" colspan="4"></td>--}}
                    {{--</tr>--}}
                    <tr>
                        <td colspan="4">
                            <div class="text-center"><b>CÁM ƠN QUÝ KHÁCH VÀ HẸN GẶP LẠI</b></div>
                            <div class="text-center font12">{{'Hotline: '.@$order->branch->phone.' Địa chỉ: '.@$order->branch->address}}</div>
                            {{--<div class="text-center font12">Website: thammyroyal.com</div>--}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <td class="text-center">Chưa thanh toán đơn hàng</td>
        @endif

    </div>
</div>
<script>
    window.print();
</script>
</body>
</html>
