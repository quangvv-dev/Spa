<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" colspan="8">THÔNG TIN NGUỒN</th>
            <th class="text-center" colspan="9">THÔNG TIN HIỆU QUẢ MARKETING</th>
        </tr>
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">STT</th>
            <th class="text-center">Marketing</th>
            <th class="text-center no-wrap">Nguồn dữ liệu</th>
            <th class="text-center">Nhóm dịch vụ</th>
            <th class="text-center">Kênh quảng cáo</th>
            <th class="text-center">Ngân sách</th>
            <th class="text-center">Số contact</th>
            <th class="text-center">Giá contact</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Lịch hẹn đến</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center">Số $/KH đến</th>
            <th class="text-center no-wrap">Tỷ lệ đến/SĐT</th>
            <th class="text-center no-wrap">Doanh số</th>
            <th class="text-center no-wrap">Doanh thu</th>
            <th class="text-center no-wrap">Thu nợ</th>
            <th class="text-center">Thực thu</th>
            {{--<th class="text-center">Doanh thu<span class=""><br>TB/đơn</span></th>--}}
        </tr>
        <tr class="number_index">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(6.1)</th>
            <th class="text-center">(5)/(3)</th>
            <th class="text-center">(6)/(5)</th>
            <th class="text-center">(6.1)/(6)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(9)</th>
            <th class="text-center">(10)</th>
            <th class="text-center">(11)</th>
            <th class="text-center">(12)</th>
            <th class="text-center">(13)</th>
        </tr>
        </thead>

        <tbody>

        @if(count($marketing))
            @foreach($marketing as $i => $item)
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{$item->comment_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_den}}</td>
                    <td class="text-center pdr10">{{$item->order_new}}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_new) && !empty($item->customer_new) ?round(($item->schedules_new/$item->customer_new)*100,1):0}}
                        %
                    </td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->schedules_new) ? round($item->schedules_den/$item->schedules_new*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->order_new>0&&$item->schedules_den >0 ?round(($item->order_new/$item->schedules_den)*100,1):0}}
                        %
                    </td>
                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->detail_new - $item->payment_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->detail_new)}}</td>
                    <td class="text-center pdr10">{{$item->comment_old}}</td>
                    <td class="text-center pdr10">{{$item->order_old}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_payment - $item->detail_new -$item->payment_old)}}</td>
                    <td class="text-center pdr10">{{!empty($item->payment_old) && !empty($item->order_old) ? number_format($item->payment_old/$item->order_old):0}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_total)}}</td>

                    <td class="text-center pdr10">{{number_format($item->payment_new + $item->payment_old)}}</td>
                    <td class="text-center pdr10">{{number_format(($item->all_payment - $item->payment_new - $item->payment_old)>0?$item->all_payment - $item->payment_new - $item->payment_old:0)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_payment)}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
