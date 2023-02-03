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
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(3)/(2)</th>
            <th class="text-center">(4)/(3)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(6)/(4)</th>
            <th class="text-center">(7)/(6)</th>
            <th class="text-center">(7)/(2)</th>
        </tr>
        </thead>

        <tbody>

        @if(count($users))
            <tr>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">
                    @php
                        $hoursAll = floor(($users->sum('history') / 3600));
                        $minutesAll = floor((($users->sum('history') % 3600)/60));
                    @endphp
                    {{number_format($users->sum('call_center'))}}<br>
                    <span class="small-tip">({{($hoursAll > 0 ? $hoursAll . ' giờ ' : '').($minutesAll > 0 ? $minutesAll . ' phút ' : '')}})</span>
                </td>
                <td class="text-center bold">{{$users->sum('customer_new')}}</td>
                <td class="text-center bold">{{$users->sum('tiep_can')}}</td>
                <td class="text-center bold">{{$users->sum('all_schedules')}}</td>
                <td class="text-center bold">{{$users->sum('schedules_huy')}}</td>
                <td class="text-center bold">{{$users->sum('schedules_den')}}</td>
                <td class="text-center bold">{{$users->sum('orders')}}</td>
                <td class="text-center bold">{{!empty($users->sum('tiep_can')) && !empty($users->sum('customer_new'))?round($users->sum('tiep_can')/$users->sum('customer_new')*100,2):0}}%</td>
                <td class="text-center bold">{{!empty($users->sum('tiep_can')) && !empty($users->sum('all_schedules'))?round($users->sum('all_schedules')/$users->sum('tiep_can')*100,2):0}}%</td>
                <td class="text-center bold">{{$users->sum('schedules_huy')}}</td>
                <td class="text-center bold">{{!empty($users->sum('schedules_den'))?round($users->sum('schedules_den')/$users->sum('all_schedules'),2)*100:0}}%</td>
                <td class="text-center bold">{{!empty($users->sum('orders')) && !empty($users->sum('schedules_den'))?round($users->sum('orders')/$users->sum('schedules_den')*100,2):0}}%</td>
                <td class="text-center bold">{{!empty($users->sum('orders')) && !empty($users->sum('customer_new'))?round($users->sum('orders')/$users->sum('customer_new')*100,2):0}}%</td>

            </tr>
            @foreach($users as $item)
                <tr class="">
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">
                        @php
                            $hours = floor(($item->history / 3600));
                            $minutes = floor((($item->history % 3600)/60));
                        @endphp
                        {{number_format($item->call_center)}}<br>
                        <span class="small-tip">({{($hours > 0 ? $hours . ' giờ ' : '').($minutes > 0 ? $minutes . ' phút ' : '')}})</span>
                    </td>
                    <td class="text-center pdr10">{{number_format($item->customer_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->tiep_can)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_schedules)}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_huy)}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_den)}}</td>
                    <td class="text-center pdr10">{{number_format($item->orders)}}</td>
                    <td class="text-center pdr10">{{!empty($item->tiep_can) && !empty($item->customer_new)?round($item->tiep_can/$item->customer_new*100,2):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->tiep_can) && !empty($item->all_schedules)?round($item->all_schedules/$item->tiep_can*100,2):0}}%</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_huy)}}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den)?round($item->schedules_den/$item->all_schedules*100,2):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->orders) && !empty($item->schedules_den)?round($item->orders/$item->schedules_den*100,2):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->orders) && !empty($item->customer_new)?round($item->orders/$item->customer_new*100,2):0}}%</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
