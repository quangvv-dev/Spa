<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">NHÂN VIÊN</th>
            @forelse($status as $s)
                <th class="text-center">{{$s->name}}</th>
            @empty
            @endforelse
        </tr>
        </thead>

        <tbody>
        @forelse($newData as $key => $new)
            <tr>
                <td class="text-center">{{$key +1}}</td>
                <td class="text-center">{{$new['full_name']}}</td>
                @forelse($status as $s)
                    <td class="text-center">{{$new['status_'.$s->id]}}</td>
                @empty
                @endforelse
            </tr>
        @empty
        @endforelse
{{--        @if(count($users))--}}
{{--            @foreach($users as $item)--}}
{{--                <tr class="">--}}
{{--                    <td class="text-center pdr10">{{$i}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->full_name}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->call_center}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->customer_new}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->customer_new - $item->duplicate}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->duplicate}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->schedules_new}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->schedules_den}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->become_buy}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->not_buy}}</td>--}}
{{--                    <td class="text-center pdr10">{{$item->order_new}}</td>--}}
{{--                    <td class="text-center pdr10">{{!empty($item->schedules_new) && !empty($item->customer_new) ?round(($item->schedules_new/$item->customer_new)*100,1):0}}%</td>--}}
{{--                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->customer_new) ? round($item->schedules_den/$item->customer_new*100,1):0}}%</td>--}}
{{--                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->schedules_new) ? round($item->schedules_den/$item->schedules_new*100,1):0}}%</td>--}}

{{--                    <td class="text-center pdr10">{{$item->schedules_new> 0 && $item->become_buy >0 ?round(($item->become_buy/$item->schedules_new)*100,1):0}}%</td>--}}
{{--                    <td class="text-center pdr10">{{$item->schedules_new> 0 && $item->not_buy >0 ?round(($item->not_buy/$item->schedules_new)*100,1):0}}%</td>--}}

{{--                    <td class="text-center pdr10">{{$item->order_new>0&&$item->schedules_den >0 ?round(($item->order_new/$item->schedules_den)*100,1):0}}%</td>--}}
{{--                    <td class="text-center pdr10">{{$item->order_new>0 && $item->customer_new >0 ?round(($item->order_new/$item->customer_new)*100,1):0}}%</td>--}}
{{--                    <td class="text-center pdr10">{{$item->order_new>0 && $item->detail_new >0 ?number_format($item->detail_new/$item->order_new):0}}</td>--}}

{{--                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>--}}
{{--                    <td class="text-center pdr10">{{number_format($item->payment_new)}}</td>--}}
{{--                    <td class="text-center pdr10">{{number_format($item->is_debt)}}</td>--}}
{{--                    <td class="text-center pdr10">{{number_format($item->detail_new)}}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--        <tr>--}}
{{--            <td class="text-center"></td>--}}
{{--            <td class="text-center bold">Tổng cộng</td>--}}
{{--            <td class="text-center bold">{{@number_format($users->sum('call_center'))}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($customer_new)}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($customer_new - $users->sum('duplicate'))}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($users->sum('duplicate'))}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($schedules_new)}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($all_schedules_den)}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($users->sum('become_buy'))}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($users->sum('not_buy'))}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($order_new)}}</td>--}}
{{--            <td class="text-center bold">{{!empty($schedules_new)&& !empty($customer_new)?round($schedules_new/$customer_new*100,1):0}}%</td>--}}
{{--            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($customer_new)?round($all_schedules_den/$customer_new*100,1):0}}%</td>--}}
{{--            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($schedules_new)?round($all_schedules_den/$schedules_new*100,1):0}}%</td>--}}

{{--            <td class="text-center bold">{{!empty($schedules_new)&& !empty($users->sum('become_buy'))?round($users->sum('become_buy')/$schedules_new*100,1):0}}%</td>--}}
{{--            <td class="text-center bold">{{!empty($schedules_new)&& !empty($users->sum('not_buy'))?round($users->sum('not_buy')/$schedules_new*100,1):0}}%</td>--}}

{{--            <td class="text-center bold">{{!empty($all_schedules_den)&& !empty($order_new)?round($order_new/$all_schedules_den*100,1):0}}%</td>--}}
{{--            <td class="text-center bold">{{!empty($customer_new)&& !empty($order_new)?round($order_new/$customer_new*100,1):0}}%</td>--}}

{{--            <td class="text-center bold">{{!empty($all_detail_new)&& !empty($order_new)?number_format($all_detail_new/$order_new):0}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($revenue_new)}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($payment_new)}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($users->sum('is_debt'))}}</td>--}}
{{--            <td class="text-center bold">{{@number_format($all_detail_new)}}</td>--}}
{{--        </tr>--}}

        </tbody>
    </table>
</div>
