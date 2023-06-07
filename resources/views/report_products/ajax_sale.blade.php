<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
{{--        <tr>--}}
{{--            <th class="text-center" colspan="1">STT</th>--}}
{{--            <th class="text-center" colspan="1">SALE</th>--}}
{{--            <th class="text-center" colspan="1"></th>--}}
{{--            <th class="text-center" colspan="18">KHÁCH HÀNG MỚI</th>--}}
{{--            <th class="text-center" colspan="3">KHÁCH HÀNG CŨ</th>--}}
{{--        </tr>--}}
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center"></th>
            <th class="text-center">Nhân viên</th>
            <th class="text-center">Cuộc gọi</th>
            <th class="text-center no-wrap">SĐT</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Khách đến</th>
            <th class="text-center">Khách đến mua</th>
            <th class="text-center">Khách đến k.mua</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center">Tỷ lệ<span class=""><br>chốt lịch</span></th>
            <th class="text-center">Tỷ lệ đến/SĐT</th>
            <th class="text-center">Tỷ lệ đến/lịch hẹn</th>
            <th class="text-center">% Đến mua/lịch hẹn</th>
            <th class="text-center">% Đến k.mua/lịch hẹn</th>
            <th class="text-center">Tỷ lệ<span class=""><br>chốt đơn</span></th>
            <th class="text-center">Tỷ lệ<span class=""><br>chốt đơn /SĐT</span></th>
            <th class="text-center">TB đơn</th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Doanh thu</th>
            <th class="text-center no-wrap">Thu nợ</th>
            <th class="text-center no-wrap">Thực thu</th>

        </tr>
        <tr class="number_index">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(2.1)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(8.1)</th>
            <th class="text-center">(5)/(3)</th>
            <th class="text-center">(5)/(4)</th>
            <th class="text-center">(6)/(4)</th>
            <th class="text-center">(7)/(4)</th>
            <th class="text-center">(8)/(5)</th>
            <th class="text-center">(8)/(3)</th>
            <th class="text-center">(12)/(8)</th>
            <th class="text-center">(9)</th>
            <th class="text-center">(10)</th>
            <th class="text-center">(11)</th>
            <th class="text-center">(12)</th>
        </tr>
        </thead>

        <tbody>
        @php
            $i=0;
            $customer_new = 0;
            $comment_new = 0;
            $order_new = 0;
            $order_old = 0;
            $schedules_percent = 0;
            $revenue_new = 0;
            $payment_new = 0;
            $all_detail_new = 0;
            $schedules_new = 0;
            $all_schedules_den = 0;
            $revenue_old = 0;
            $detail_old = 0;
        @endphp

        @if(count($users))
            @foreach($users as $item)
                @php $i++ ;
                $customer_new += $item->customer_new;
                $comment_new += $item->comment_new;
                $order_new += $item->order_new;
                $order_old += $item->order_old;
                $schedules_percent += $item->schedules_den >0 && $item->customer_new>0 ?round(($item->schedules_new/$item->customer_new)*100,1):0;
                $revenue_new += $item->revenue_new;
                $payment_new += $item->payment_new;
                $schedules_new += $item->schedules_new;
                $all_schedules_den += $item->schedules_den;
                $all_detail_new += $item->detail_new;
                $revenue_old += $item->revenue_old;
                $detail_old += $item->detail_old;

                @endphp
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}</td>
                    <td class="text-center pdr10">{{$item->call_center}}</td>
                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_den}}</td>
                    <td class="text-center pdr10">{{$item->become_buy}}</td>
                    <td class="text-center pdr10">{{$item->not_buy}}</td>
                    <td class="text-center pdr10">{{$item->order_new}}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_new) && !empty($item->customer_new) ?round(($item->schedules_new/$item->customer_new)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->customer_new) ? round($item->schedules_den/$item->customer_new*100,1):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->schedules_new) ? round($item->schedules_den/$item->schedules_new*100,1):0}}%</td>

                    <td class="text-center pdr10">{{$item->schedules_new> 0 && $item->become_buy >0 ?round(($item->become_buy/$item->schedules_new)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->schedules_new> 0 && $item->not_buy >0 ?round(($item->not_buy/$item->schedules_new)*100,1):0}}%</td>

                    <td class="text-center pdr10">{{$item->order_new>0&&$item->schedules_den >0 ?round(($item->order_new/$item->schedules_den)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->order_new>0 && $item->customer_new >0 ?round(($item->order_new/$item->customer_new)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->order_new>0 && $item->detail_new >0 ?number_format($item->detail_new/$item->order_new):0}}</td>

                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->detail_new - $item->payment_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->detail_new)}}</td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td class="text-center"></td>
            <td class="text-center bold">Tổng cộng</td>
            <td class="text-center bold">{{@number_format($users->sum('call_center'))}}</td>
            <td class="text-center bold">{{@number_format($customer_new)}}</td>
            <td class="text-center bold">{{@number_format($schedules_new)}}</td>
            <td class="text-center bold">{{@number_format($all_schedules_den)}}</td>
            <td class="text-center bold">{{@number_format($users->sum('become_buy'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('not_buy'))}}</td>
            <td class="text-center bold">{{@number_format($order_new)}}</td>
            <td class="text-center bold">{{!empty($schedules_new)&& !empty($customer_new)?round($schedules_new/$customer_new*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($customer_new)?round($all_schedules_den/$customer_new*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($schedules_new)?round($all_schedules_den/$schedules_new*100,1):0}}%</td>

            <td class="text-center bold">{{!empty($schedules_new)&& !empty($users->sum('become_buy'))?round($users->sum('become_buy')/$schedules_new*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($schedules_new)&& !empty($users->sum('not_buy'))?round($users->sum('not_buy')/$schedules_new*100,1):0}}%</td>

            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($order_new)?round($order_new/$all_schedules_den*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($customer_new)&& !empty($order_new)?round($order_new/$customer_new*100,1):0}}%</td>

            <td class="text-center bold">{{!empty($all_detail_new)&& !empty($order_new)?number_format($all_detail_new/$order_new):0}}</td>
            <td class="text-center bold">{{@number_format($revenue_new)}}</td>
            <td class="text-center bold">{{@number_format($payment_new)}}</td>
            <td class="text-center bold">{{@number_format($all_detail_new - $payment_new)}}</td>
            <td class="text-center bold">{{@number_format($all_detail_new)}}</td>
        </tr>

        </tbody>
    </table>
</div>
