<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" colspan="11">CHỈ SỐ BÁO CÁO</th>
            <th class="text-center" colspan="4">TỶ LỆ CHUYỂN ĐỔI NÓNG</th>
            <th class="text-center" colspan="4">TỶ LỆ CHUYỂN ĐỔI CHUNG</th>
            <th class="text-center" colspan="5">KẾT QUẢ DOANH THU</th>
        </tr>
        <tr>
            <th class="text-center"></th>
            <th class="text-center">Nhân viên</th>
            <th class="text-center">Cuộc gọi</th>
            <th class="text-center">Thời lượng c.gọi (phút)</th>
            <th class="text-center">Cuộc gọi >2p</th>
            <th class="text-center no-wrap">SĐT mới</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Khách đến</th>
            <th class="text-center">Khách đến mua</th>
            <th class="text-center">Khách đến k.mua</th>
            <th class="text-center">Đơn chốt</th>

            <th class="text-center">%<span class=""><br>Chốt lịch</span></th>
            <th class="text-center">% Đến/lịch hẹn</th>
            <th class="text-center">% Mua/lịch hẹn</th>
            <th class="text-center">% Chốt <span class=""><br>/khách đến</span></th>

            <th class="text-center">%<span class=""><br>Chốt lịch</span></th>
            <th class="text-center">% Đến/lịch hẹn</th>
            <th class="text-center">% Mua/lịch hẹn</th>
            <th class="text-center">% Chốt <span class=""><br>/khách đến</span></th>

            <th class="text-center">TB đơn</th>
            <th class="text-center">Doanh số</th>
            <th class="text-center">Doanh thu</th>
            <th class="text-center no-wrap">Thu nợ</th>
            <th class="text-center no-wrap">Thực thu</th>
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
            $order_hot = 0;
            $schedules_hot = 0;
            $schedules_hot_den = 0;
        @endphp

        @if(count($users))
            @foreach($users as $item)
                @php $i++ ;
                $customer_new += $item->customer_new;
                $comment_new += $item->comment_new;
                $order_new += $item->order_new;
                $order_hot += $item->order_hot;
                $order_old += $item->order_old;
                $schedules_percent += $item->schedules_den >0 && $item->customer_new>0 ?round(($item->schedules_new/$item->customer_new)*100,1):0;
                $revenue_new += $item->revenue_new;
                $payment_new += $item->payment_new;
                $schedules_new += $item->schedules_new;
                $schedules_hot += $item->schedules_hot;//hot
                $all_schedules_den += $item->schedules_den;
                $schedules_hot_den += $item->schedules_hot_den;
                $all_detail_new += $item->detail_new;
                $revenue_old += $item->revenue_old;
                $detail_old += $item->detail_old;

                @endphp
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}</td>
                    <td class="text-center pdr10">{{number_format($item->call_center)}}</td>
                    <td class="text-center pdr10">{{number_format($item->answer_time)}}</td>
                    <td class="text-center pdr10">{{number_format($item->call2minute)}}</td>

                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_den}}</td>
                    <td class="text-center pdr10">{{$item->become_buy}}</td>
                    <td class="text-center pdr10">{{$item->not_buy}}</td>
                    <td class="text-center pdr10">{{$item->order_new}}</td>

                    <td class="text-center pdr10">{{!empty($item->schedules_hot) && !empty($item->customer_new) ?round(($item->schedules_hot/$item->customer_new)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_hot_den) && !empty($item->schedules_hot) ? round($item->schedules_hot_den/$item->schedules_hot*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->schedules_hot> 0 && $item->schedules_hot_mua >0 ?round(($item->schedules_hot_mua/$item->schedules_hot)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->order_hot>0 && $item->schedules_hot_den >0 ?round(($item->order_hot/$item->schedules_hot_den)*100,1):0}}%</td>

                    <td class="text-center pdr10">{{!empty($item->schedules_new) && !empty($item->customer_new) ?round(($item->schedules_new/$item->customer_new)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->schedules_new) ? round($item->schedules_den/$item->schedules_new*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->schedules_new> 0 && $item->become_buy >0 ?round(($item->become_buy/$item->schedules_new)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->order_new>0&&$item->schedules_den >0 ?round(($item->order_new/$item->schedules_den)*100,1):0}}%</td>

                    <td class="text-center pdr10">{{$item->order_new>0 && $item->detail_new >0 ?number_format($item->detail_new/$item->order_new):0}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->is_debt)}}</td>
                    <td class="text-center pdr10">{{number_format($item->detail_new)}}</td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td class="text-center"></td>
            <td class="text-center bold">Tổng cộng</td>
            <td class="text-center bold">{{@number_format($users->sum('call_center'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('answer_time'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('call2minute'))}}</td>

            <td class="text-center bold">{{@number_format($customer_new)}}</td>
            <td class="text-center bold">{{@number_format($schedules_new)}}</td>
            <td class="text-center bold">{{@number_format($all_schedules_den)}}</td>
            <td class="text-center bold">{{@number_format($users->sum('become_buy'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('not_buy'))}}</td>
            <td class="text-center bold">{{@number_format($order_new)}}</td>

            <td class="text-center bold">{{!empty($schedules_hot)&& !empty($customer_new)?round($schedules_hot/$customer_new*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($schedules_hot_den)&& !empty($schedules_hot)?round($schedules_hot_den/$schedules_hot*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($schedules_hot)&& !empty($users->sum('schedules_hot_mua'))?round($users->sum('schedules_hot_mua')/$schedules_hot*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($schedules_hot_den)&& !empty($order_hot)?round($order_hot/$schedules_hot_den*100,1):0}}%</td>

            <td class="text-center bold">{{!empty($schedules_new)&& !empty($customer_new)?round($schedules_new/$customer_new*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($schedules_new)?round($all_schedules_den/$schedules_new*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($schedules_new)&& !empty($users->sum('become_buy'))?round($users->sum('become_buy')/$schedules_new*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($order_new)?round($order_new/$all_schedules_den*100,1):0}}%</td>

            <td class="text-center bold">{{!empty($all_detail_new)&& !empty($order_new)?number_format($all_detail_new/$order_new):0}}</td>
            <td class="text-center bold">{{@number_format($revenue_new)}}</td>
            <td class="text-center bold">{{@number_format($payment_new)}}</td>
            <td class="text-center bold">{{@number_format($users->sum('is_debt'))}}</td>
            <td class="text-center bold">{{@number_format($all_detail_new)}}</td>
        </tr>

        </tbody>
    </table>
</div>
