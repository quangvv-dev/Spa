<div class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">STT</th>
            <th class="text-center">Marketing</th>
            <th class="text-center">Số contact</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center no-wrap">Tỷ lệ hẹn lịch</th>
            <th class="text-center no-wrap">Tỷ lệ chốt/SĐT</th>
            <th class="text-center no-wrap">Doanh số</th>
            <th class="text-center no-wrap">Doanh thu</th>
{{--            <th class="text-center no-wrap">Thực thu</th>--}}
            <th class="text-center">Số $ TB/ đơn</th>
        </tr>
        <tr class="number_index">
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(2)/(1)</th>
            <th class="text-center">(3)/1</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
        </tr>
        </thead>

        <tbody>

        @if(count($marketing))
            <tr>
                <td class="text-center bold" colspan="2">Tổng</td>
                <td class="text-center bold">{{number_format($marketing->sum('contact'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('schedules'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('orders'))}}</td>
                <td class="text-center bold">{{!empty($marketing->sum('contact')) ?round($marketing->sum('schedules')/$marketing->sum('contact')*100,1):0 }}%</td>
                <td class="text-center bold">{{!empty($marketing->sum('contact')) ?round($marketing->sum('orders')/$marketing->sum('contact')*100,1):0 }}%</td>
                <td class="text-center bold">{{number_format($marketing->sum('all_total'))}}</td>
                <td class="text-center bold">{{number_format($marketing->sum('gross_revenue'))}}</td>
{{--                <td class="text-center bold">{{number_format($marketing->sum('payment'))}}</td>--}}
                <td class="text-center bold">{{number_format(!empty($marketing->sum('orders')) ?round($marketing->sum('gross_revenue')/$marketing->sum('orders')*100,1):0)}}</td>
            </tr>
            @foreach($marketing as $i => $item)
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{number_format($item->contact)}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules)}}</td>
                    <td class="text-center pdr10">{{number_format($item->orders)}}</td>
                    <td class="text-center pdr10">{{!empty($item->contact) ?round(($item->schedules/$item->contact)*100,2):0}}%</td>
                    <td class="text-center pdr10">{{!empty($item->contact) ? round(($item->orders / $item->contact) * 100, 2) : 0}}%</td>
                    <td class="text-center pdr10">{{number_format($item->all_total)}}</td>
                    <td class="text-center pdr10">{{number_format($item->gross_revenue)}}</td>
{{--                    <td class="text-center pdr10">{{number_format($item->payment)}}</td>--}}
                    <td class="text-center pdr10">{{number_format(!empty($item->orders) ? round(($item->gross_revenue / $item->orders) * 100, 2) : 0)}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
