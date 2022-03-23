<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" colspan="5">THÔNG TIN NGUỒN</th>
            <th class="text-center" colspan="9">THÔNG TIN HIỆU QUẢ MARKETING</th>
        </tr>
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">STT</th>
            <th class="text-center">Marketing</th>
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
            {{--<th class="text-center">(11)</th>--}}
            {{--<th class="text-center">(12)</th>--}}
            {{--<th class="text-center">(13)</th>--}}
        </tr>
        </thead>

        <tbody>

        @if(count($marketing))
            @foreach($marketing as $i => $item)
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">0</td> {{--ngân sách--}}
                    <td class="text-center pdr10">{{number_format($item->contact)}}</td>
                    <td class="text-center pdr10">0</td>{{--giá contact--}}
                    <td class="text-center pdr10">{{number_format($item->schedules)}}</td>
                    <td class="text-center pdr10">{{number_format($item->schedules_den)}}</td>
                    <td class="text-center pdr10">{{number_format($item->orders)}}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->gross_revenue) ?number_format($item->gross_revenue/$item->schedules_den):0 }}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->contact) ?round(($item->schedules_den/$item->contact)*100,1):0}}%</td>

                    <td class="text-center pdr10">{{number_format($item->all_total)}}</td>
                    <td class="text-center pdr10">{{number_format($item->gross_revenue)}}</td>

                    <td class="text-center pdr10">{{number_format($item->payment - $item->gross_revenue)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment)}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
