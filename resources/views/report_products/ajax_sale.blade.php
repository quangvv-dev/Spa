<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center"></th>
            <th class="text-center">Nhân viên</th>
            <th class="text-center">Số mới</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">HV đến</th>
            <th class="text-center">HV chốt</th>
            <th class="text-center">% Lịch hẹn/SĐT</th>
            <th class="text-center">% HV đến/Lịch hẹn</th>
            <th class="text-center">% HV chốt/HV đến</th>
            <th class="text-center">% Chốt/SĐT</th>
        <tr class="number_index">
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(2)/(1)</th>
            <th class="text-center">(3)/(2)</th>
            <th class="text-center">(4)/(3)</th>
            <th class="text-center">(4)/(2)</th>
        </tr>
        </thead>

        <tbody>

        @if(count($users))
            <tr>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">{{$users->sum('customer_new')}}</td>
                <td class="text-center bold">{{$users->sum('all_schedules')}}</td>
                <td class="text-center bold">{{$users->sum('schedules_den')}}</td>
                <td class="text-center bold">{{$users->sum('orders')}}</td>
                <td class="text-center bold">{{!empty($users->sum('customer_new')) && !empty($users->sum('all_schedules'))?round($users->sum('all_schedules')/$users->sum('customer_new')*100,2):0}}%</td>
                <td class="text-center bold">{{!empty($users->sum('schedules_den'))?round($users->sum('schedules_den')/$users->sum('all_schedules'),2)*100:0}}%</td>
                <td class="text-center bold">{{!empty($users->sum('orders')) && !empty($users->sum('schedules_den'))?round($users->sum('orders')/$users->sum('schedules_den')*100,2):0}}%</td>
                <td class="text-center bold">{{!empty($users->sum('orders')) && !empty($users->sum('customer_new'))?round($users->sum('orders')/$users->sum('customer_new')*100,2):0}}%</td>

            </tr>
            @foreach($users as $item)
                <tr class="">
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{number_format($item->customer_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_schedules)}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_den)}}</td>
                    <td class="text-center pdr10">{{number_format($item->orders)}}</td>
                    <td class="text-center pdr10">{{!empty($item->all_schedules) && !empty($item->customer_new)?round($item->all_schedules/$item->customer_new*100,2):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den)?round($item->schedules_den/$item->all_schedules*100,2):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->orders) && !empty($item->schedules_den)?round($item->orders/$item->schedules_den*100,2):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->orders) && !empty($item->customer_new)?round($item->orders/$item->customer_new*100,2):0}}%</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
