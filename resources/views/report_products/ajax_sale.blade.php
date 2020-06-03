<div class="bxh bxh-container" style="border:1px solid transparent;">
    {{--<div--}}
    {{--style="transform: rotate(-5deg); height: 8px; width: 100%; background-color: #cecece; position: absolute; top: 13.5%;"></div>--}}
    @php $int =0;$i =0; @endphp
    @foreach($users as $value)
        @php $int++ ;
        if ($int>=10)
        @endphp
        <div {{$int>10?'style=display:none':''}} class="item-rank" style="right: {{$int*9}}%;top: {{$int*2}}%">
            <div class="king-sale">
                <img src="{{$int==1?'https://pushsale.vn/Portals/_default/Skins/APP/images/bxh/bxh2.png':''}}">
            </div>
            <div class="avatar-container  blink">
                <img class="avatar-img" src="{{asset('images/users/2019-05-02_5ccb212a822b8.jpg')}}">
            </div>
            <div class="item-info {{'item-info'.($int)}}">
                <div class="item-stt">{{$int==1 ?'#'.($int):($int)}}</div>
                <div class="item-tennv">{{$value->full_name}}</div>
                <div class="">{{number_format($value->revenue_total)}}</div>
            </div>
        </div>
    @endforeach

</div>
<div style="width: 100%; overflow: hidden; overflow-y: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <tbody>
        <thead class="bg-primary text-white">
        <th class="text-center" rowspan="2" colspan="1">STT</th>
        <th class="text-center" rowspan="2" colspan="1">SALE</th>
        <th class="text-center" rowspan="1" colspan="7">KHÁCH HÀNG MỚI</th>
        <th class="text-center" rowspan="1" colspan="5">KHÁCH HÀNG CŨ</th>
        {{--<th class="text-center" rowspan="1" colspan="1">TT nợ</th>--}}
        <th class="text-center" rowspan="1" colspan="3">TỔNG CHUNG</th>
        </thead>
        <tr>

            <th class="text-center"></th>
            <th class="text-center">Nhân viên</th>
            <th class="text-center no-wrap">SĐT</th>
            <th class="text-center">Trao đổi</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Số đơn chốt</th>
            <th class="text-center">Tỷ lệ chốt</th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Thực thu</th>

            <th class="text-center no-wrap">Lịch hẹn</th>
            <th class="text-center no-wrap">Trao đổi</th>
            <th class="text-center no-wrap">Đơn chốt</th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Thực thu</th>
            {{--<th class="text-center">Thanh toán<span class=""><br>thêm</span></th>--}}
            <th class="text-center">Tổng<span class=""><br>doanh số</span></th>
            <th class="text-center">Tổng thực thu</th>
        </tr>
        <tr style="font-size:11px;">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(5)/(3)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(9)</th>
            <th class="text-center">(10)</th>
            <th class="text-center">(11)</th>
            <th class="text-center">(12)</th>
            <th class="text-center">(13)</th>
            <th class="text-center">(7)+(12)</th>
            <th class="text-center">(8)+(13)</th>
            {{--<th class="text-center">(+(13)</th>--}}
        </tr>
        @if(count($users))
            @foreach($users as $item)
                @php $i++ @endphp
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{$item->comment_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new}}</td>
                    <td class="text-center pdr10">{{$item->order_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new >0 && $item->customer_new>0 ?round(($item->schedules_new/$item->customer_new)*100):0}} %</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new)}}</td>
                    <td class="text-center pdr10">{{$item->schedules_old}}</td>
                    <td class="text-center pdr10">{{$item->comment_old}}</td>
                    <td class="text-center pdr10">{{$item->order_old}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_old)}}</td>
                    {{--<td class="text-center pdr10">{{@number_format($item->payment_rest)}}</td>--}}
                    <td class="text-center pdr10">{{number_format($item->revenue_total)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new+$item->payment_old)}}</td>
                </tr>
            @endforeach
        @endif
        <tr class="fixed">
            <th colspan="13" class="text-center"></th>

            <th class="text-center bold">Tổng cộng</th>
            <th class="bold">{{number_format($allTotal)}}</th>
            <th class="bold">{{number_format($grossRevenue)}}</th>
            {{--<th class="text-center">(+(13)</th>--}}
        </tr>

        </tbody>
    </table>
</div>
