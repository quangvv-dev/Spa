<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center"></th>
            <th class="text-center">Nhân viên</th>
            <th class="text-center no-wrap">Tác nghiệp</th>
            <th class="text-center">Số mới</th>
            <th class="text-center">Tiếp cận</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Lịch hủy</th>
            <th class="text-center">HV đến</th>
            <th class="text-center">HV chốt</th>
            <th class="text-center">Tỷ lệ<span class=""><br>tiếp cận(%)</span></th>
            <th class="text-center">% Lịch hẹn/tiếp cận</th>
            <th class="text-center">% Hủy lịch</th>
            <th class="text-center">% HV đến/Lịch hẹn</th>
            <th class="text-center">% HV chốt/HV đến</th>
            <th class="text-center">% Chốt/SĐT</th>
        <tr class="number_index">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">()</th>
            <th class="text-center">()</th>
            <th class="text-center">()</th>
            <th class="text-center">()</th>
            <th class="text-center">()</th>
            <th class="text-center">()</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(9)</th>
        </tr>
        </thead>

        <tbody>

        @if(count($users))
            @foreach($users as $item)
                <tr class="">
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{$item->call_center}}</td>
                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{number_format($item->tiep_can)}}</td>
                    <td class="text-center pdr10">{{$item->all_schedules}}</td>
                    <td class="text-center pdr10">{{$item->schedules_huy}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_den)}}</td>
                    <td class="text-center pdr10">{{number_format($item->orders)}}</td>
                    <td class="text-center pdr10">{{!empty($item->tiep_can) && !empty($item->customer_new)?($item->tiep_can/$item->customer_new)*100:0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->tiep_can) && !empty($item->all_schedules)?($item->all_schedules/$item->tiep_can)*100:0}}%</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_huy)}}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den)?($item->schedules_den/$item->all_schedules)*100:0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->orders) && !empty($item->schedules_den)?($item->orders/$item->schedules_den)*100:0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->orders) && !empty($item->customer_new)?($item->orders/$item->customer_new)*100:0}}%</td>
                </tr>
            @endforeach
        @endif
        {{--<tr>--}}
            {{--<td class="text-center"></td>--}}
            {{--<td class="text-center bold">Tổng cộng</td>--}}
            {{--<td class="text-center bold">{{@number_format($customer_new)}}</td>--}}
            {{--<td class="text-center bold">{{@number_format($comment_new)}}</td>--}}
            {{--<td class="text-center bold">{{@number_format($schedules_new)}}</td>--}}
            {{--<td class="text-center bold">{{@number_format($all_schedules_den)}}</td>--}}
            {{--<td class="text-center bold">{{@number_format($order_new)}}</td>--}}
            {{--<td class="text-center bold">{{!empty($schedules_new)&& !empty($customer_new)?round($schedules_new/$customer_new*100,1):0}}%</td>--}}
            {{--<td class="text-center bold">{{!empty($all_schedules_den)&& !empty($schedules_new)?round($all_schedules_den/$schedules_new*100,1):0}}%</td>--}}
            {{--<td class="text-center bold">{{!empty($all_schedules_den)&& !empty($order_new)?round($order_new/$all_schedules_den*100,1):0}}%</td>--}}
            {{--<td class="text-center bold">{{!empty($customer_new)&& !empty($order_new)?round($order_new/$customer_new*100,1):0}}%</td>--}}
            {{--<td class="text-center bold">{{!empty($all_detail_new)&& !empty($order_new)?number_format($all_detail_new/$order_new):0}}</td>--}}
            {{--<td class="text-center bold">{{@number_format($revenue_new)}}</td>--}}
            {{--<td class="text-center bold">{{@number_format($payment_new)}}</td>--}}
            {{--<td class="text-center bold">{{@number_format($all_detail_new - $payment_new)}}</td>--}}
        {{--</tr>--}}

        </tbody>
    </table>
</div>
