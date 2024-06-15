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
    <link href="{{asset('css/print.css')}}" rel="stylesheet" type="text/css">
</head>
<div class="invoice" style="">
    <div class="block-header">
        <div class="brand text-right bold">{{@$order->branch->lat??'PHÒNG KHÁM THẨM MỸ THEPYO'}}</div>
        <div class="address font12 text-right">{{@$order->branch->address}}</div>

        <div class="title text-center"><h3>PHIẾU TÁI KHÁM</h3></div>
        <!-- <div class="date-time font12"> </div> -->
        <div class="customer">
            <div class="lesson bold">I/ THÔNG TIN KHÁCH HÀNG</div>
            <div class="info">
                <div class="info-detail">
                    <div class="">
                        <span class="bold">Khách hàng: </span>
                        <span>{{$order->customer->full_name}}</span>
                    </div>
                    <div class="">
                        <span>Năm sinh: </span> {{@$order->customer->birthday}}
                    </div>
                    <div class="">
                        <span>Mã KH: </span> {{@$order->customer->account_code}}
                    </div>

                </div>
                <div class="info-detail">
                    <div class="">
                        <span>Địa chỉ: </span> {{@$order->customer->address}}
                    </div>
                    <div class="">
                        <span>Công nợ: </span> {{@number_format($order->the_rest)}} VNĐ
                    </div>
                </div>
            </div>
        </div>
        <div class="doctor">
            <div class="lesson bold">II/ THÔNG TIN DỊCH VỤ</div>
            <div class="row">
                <div class="col-lg-7">
                    <span class="bold">EKIP thực hiện: </span>
                    <span>
                        @if(isset($order->supportOrder))
                            {{!empty($order->supportOrder->doctor)?@$order->supportOrder->doctor->full_name.', ':''}}
                            {{!empty($order->supportOrder->yTaChinh)?@$order->supportOrder->yTaChinh->full_name.', ':''}}
                            {{!empty($order->supportOrder->yTaPhu)?@$order->supportOrder->yTaPhu->full_name:''}}
                        @endif
                    </span>
                </div>
                <div class="col-lg-5">
                    <span>Bác sĩ tư vấn: </span>
                    @if(isset($order->supportOrder))
                        {{!empty($order->supportOrder->doctor)?@$order->supportOrder->doctor->full_name:''}}
                    @endif
                </div>
            </div>
        </div>
        <table class="table table table-bordered table-info hidden-xs">
            <thead class="bg-primary text-white">
            <tr>
                <th rowspan="2">Ngày tái khám</th>
                <th rowspan="2">Ngày thực hiện</th>
                <th rowspan="2">Dịch vụ</th>
                <th rowspan="2">Kết quả tái khám</th>
                <th colspan="2">Mức đáp ứng KH</th>
                <th rowspan="2">Chỉ định</th>
                <th rowspan="2">Người tái khám <br><i class="font12 ">(Ký & ghi rõ họ tên)</i></th>
                <th rowspan="2">Khách hàng <br>
                    <i class="font12 ">(Ký & ghi rõ họ tên)</i></th>
            </tr>
            <tr class="custom">
                <td>Hài lòng</td>
                <td>Không hài lòng</td>

            </tr>
            </thead>
            <tbody>
            @if($order->orderDetails)
                @forelse($order->orderDetails as $item)
                    @if(isset($item->service) && $item->service->type == \App\Constants\StatusCode::SERVICE)
                        <tr class="elm">
                            <td>
                                <div>
                                    {{now()->format('d/m/Y')}}
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{date('d/m/Y',strtotime($order->created_at))}}
                                </div>
                            </td>
                            <td>
                                <div>{{$item->service->name}}</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                @empty
                @endforelse
            @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    window.print();
</script>
</html>
