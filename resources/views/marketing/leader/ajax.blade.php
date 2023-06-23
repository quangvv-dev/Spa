<div class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">STT</th>
            <th class="text-center">Marketing</th>
            <th class="text-center">Số contact</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Lịch hẹn đến</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center no-wrap">Tỷ lệ đến/SĐT</th>
            <th class="text-center no-wrap">Doanh số</th>
            <th class="text-center no-wrap">Doanh thu</th>
            <th class="text-center">Thực thu<span class=""><br>KH mới</span></th>
            <th class="text-center">Thực thu<span class=""><br>tổng</span></th>
        </tr>
        <tr class="number_index">
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(4)/(1)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
        </tr>
        </thead>

        <tbody>

        @if(count($marketing))
            <tr>
                <td class="text-center bold" colspan="2">Tổng</td>
                <td class="text-center bold">{{number_format($marketing->sum('contact'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('schedules'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('schedules_den'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('orders'))}}</td>
                <td class="text-center bold">{{!empty($marketing->sum('schedules_den')) && !empty($marketing->sum('contact')) ?round($marketing->sum('schedules_den')/$marketing->sum('contact')*100,1):0 }}%</td>
                <td class="text-center bold">{{number_format($marketing->sum('all_total'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('gross_revenue'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('payment'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('paymentAll'))}}</td>
            </tr>
            @foreach($marketing as $i => $item)
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{number_format($item->contact)}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules)}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_den)}}</td>
                    <td class="text-center pdr10">{{number_format($item->orders)}}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->contact) ?round(($item->schedules_den/$item->contact)*100,1):0}}%</td>
                    <td class="text-center pdr10">{{number_format($item->all_total)}}</td>
                    <td class="text-center pdr10">{{number_format($item->gross_revenue)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment)}}</td>
                    <td class="text-center pdr10">{{number_format($item->paymentAll)}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
