<div class="bxh bxh-container" style="border:1px solid transparent;">
    @php $int =0;$i =0; @endphp
    @foreach($response as $value)
        @php $int++ ;
        if ($int>=10)
        @endphp
        <div {{$int>10 || $value->payment_new + $value->payment_old<1  ?'style=display:none':''}} class="item-rank"
             style="right: {{$int*9}}%;top: {{$int*2}}%">
            <div class="king-sale">
                <img src="{{$int==1?'https://pushsale.vn/Portals/_default/Skins/APP/images/bxh/bxh2.png':''}}">
            </div>
            <div class="avatar-container  blink">
                <img class="avatar-img" src="{{asset($select_tower.@$value->avatar)}}">
            </div>
            <div class="item-info {{'item-info'.($int)}}">
                <div class="item-stt">{{$int==1 ?'#'.($int):($int)}}</div>
                <div class="item-tennv">{{$value->full_name}}</div>
                <div class="">{{number_format($value->all_payment)}}</div>
            </div>
        </div>
    @endforeach

</div>
<div style="width: 100%; overflow:auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" colspan="1">STT</th>
            <th class="text-center" colspan="1">SALE</th>
            <th class="text-center" colspan="8">KHÁCH HÀNG MỚI</th>
            <th class="text-center" colspan="5">KHÁCH HÀNG CŨ</th>
            <th class="text-center" colspan="3">TỔNG CHUNG</th>
        </tr>
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center"></th>
            <th class="text-center">Nhân viên</th>
            <th class="text-center no-wrap">SĐT</th>
            <th class="text-center">Trao đổi</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center">Tỷ lệ<span class=""><br>chốt lịch</span></th>
            <th class="text-center">Tỷ lệ<span class=""><br>chốt đơn</span></th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Thực thu</th>
            <th class="text-center no-wrap">Lịch hẹn</th>
            <th class="text-center no-wrap">Trao đổi</th>
            <th class="text-center no-wrap">Đơn chốt</th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Thực thu</th>
            <th class="text-center">Tổng<span class=""><br>doanh số</span></th>
            <th class="text-center">Tổng thực thu</th>
            <th class="text-center">Đã thu<span class=""><br>T.kỳ</span></th></th>
        </tr>
        <tr class="number_index">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(5)/(3)</th>
            <th class="text-center">(6)/(3)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(9)</th>
            <th class="text-center">(10)</th>
            <th class="text-center">(11)</th>
            <th class="text-center">(12)</th>
            <th class="text-center">(13)</th>
            <th class="text-center">(7)+(12)</th>
            <th class="text-center">(8)+(13)</th>
            <th class="text-center"></th>
        </tr>
        </thead>

        <tbody>
        @php
            $customer_new = 0;
            $comment_new = 0;
            $schedules_new = 0;
            $order_new = 0;
            $schedules_percent = 0;
            $order_percent = 0;
            $revenue_new = 0;
            $payment_new = 0;
            $schedules_old = 0;
            $comment_old = 0;
            $order_old = 0;
            $revenue_old = 0;
            $payment_old = 0;
            $all_payment = 0;
        @endphp

        @if(count($response))
            @foreach($response as $i => $item)
                @php $i++ ;
                $customer_new += $item->customer_new;
                $comment_new += $item->comment_new;
                $schedules_new += $item->schedules_new;
                $order_new += $item->order_new;
                $schedules_percent += $item->schedules_new >0 && $item->customer_new>0 ?round(($item->schedules_new/$item->customer_new)*100):0;
                $order_percent += $item->order_new>0&&$item->customer_new >0 ?round(($item->order_new/$item->customer_new)*100):0;
                $revenue_new += $item->revenue_new;
                $payment_new += $item->payment_new;
                $schedules_old += $item->schedules_old;
                $comment_old += $item->comment_old;
                $order_old += $item->order_old;
                $revenue_old += $item->revenue_old;
                $payment_old += $item->payment_old;
                $all_payment += $item->all_payment;
                @endphp
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{$item->comment_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new}}</td>
                    <td class="text-center pdr10">{{$item->order_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new >0 && $item->customer_new>0 ?round(($item->schedules_new/$item->customer_new)*100):0}}
                        %
                    </td>
                    <td class="text-center pdr10">{{$item->order_new>0&&$item->customer_new >0 ?round(($item->order_new/$item->customer_new)*100):0}}
                        %
                    </td>
                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new)}}</td>
                    <td class="text-center pdr10">{{$item->schedules_old}}</td>
                    <td class="text-center pdr10">{{$item->comment_old}}</td>
                    <td class="text-center pdr10">{{$item->order_old}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_total)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new+$item->payment_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_payment)}}</td>
                </tr>
            @endforeach
        @endif
        <tr class="fixed">
            <th class="text-center"></th>
            <th class="text-center bold">Tổng cộng</th>
            <th class="text-center bold">{{@number_format($customer_new)}}</th>
            <th class="text-center bold">{{@number_format($comment_new)}}</th>
            <th class="text-center bold">{{@number_format($schedules_new)}}</th>
            <th class="text-center bold">{{@number_format($order_new)}}</th>
            <th class="text-center bold">{{@number_format($schedules_percent/count((array)$response))}}%</th>
            <th class="text-center bold">{{@number_format($order_percent/count((array)$response))}}%</th>
            <th class="text-center bold">{{@number_format($revenue_new)}}</th>
            <th class="text-center bold">{{@number_format($payment_new)}}</th>
            <th class="text-center bold">{{@number_format($schedules_old)}}</th>
            <th class="text-center bold">{{@number_format($comment_old)}}</th>
            <th class="text-center bold">{{@number_format($order_old)}}</th>
            <th class="text-center bold">{{@number_format($revenue_old)}}</th>
            <th class="text-center bold">{{@number_format($payment_old)}}</th>
            <th class="bold">{{@number_format($revenue_new + $revenue_old)}}</th>
            <th class="bold">{{@number_format($payment_new + $payment_old)}}</th>
            <th class="bold">{{@number_format($all_payment)}}</th>
        </tr>

        </tbody>
    </table>
</div>
