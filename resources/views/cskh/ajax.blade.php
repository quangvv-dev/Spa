<div  class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">CSKH</th>
            <th class="text-center no-wrap">SĐT</th>
            <th class="text-center">Cuộc gọi</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Đơn hàng</th>
            <th class="text-center">Doanh số</th>
            <th class="text-center">Doanh thu</th>
            <th class="text-center">TB đơn</th>
            <th class="text-center">Thu nợ</th>
            <th class="text-center">Tổng doanh thu</th>
        </tr>
        <tr class="number_index">
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center"></th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
        </tr>
        </thead>
        <tbody>

        @if(count($users))
            @foreach($users as $i => $item)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$item->full_name}}</td>
                    <td>{{number_format($item->phone)}}</td>
                    <td>{{number_format($item->call)}}</td>
                    <td>0</td>
                    <td>{{number_format($item->orders)}}</td>
                    <td>{{number_format($item->all_total)}}</td>
                    <td>{{number_format($item->gross_revenue)}}</td>
                    <td>{{!empty($item->all_total) && !empty($item->orders)?number_format(round($item->all_total/$item->orders)):0}}</td>
                    <td>{{number_format($item->payment - $item->gross_revenue)}}</td>
                    <td>{{number_format($item->payment)}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
