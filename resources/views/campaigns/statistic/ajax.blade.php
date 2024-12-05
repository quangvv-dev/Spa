<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Phụ trách</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Lịch hẹn</th>
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Còn nợ</th>
            <th class="text-white text-center">TB đơn</th>
        </tr>
        </thead>
        <tbody>
        @if (count($data))
            @foreach($data as $k => $c)
                <tr>
                    <th scope="row">{{ $k +1 }}</th>
                    <td class="text-center">{{ $c['full_name'] }}</td>
                    <td class="text-center">{{$c['customers']}}</td>
                    <td class="text-center">{{$c['schedules']}}</td>
                    <td class="text-center">{{$c['orders']}}</td>
                    <td class="text-center">{{number_format($c['all_total'])}}</td>
                    <td class="text-center">{{number_format($c['gross_revenue'])}}</td>
                    <td class="text-center">{{number_format($c['the_rest'])}}</td>
                    <td class="text-center">{{!empty($c['orders'])?number_format($c['all_total'] / $c['orders']):0}}</td>
                </tr>
            @endforeach
            <tr class="bold">
                <th scope="row"></th>
                <td class="text-center bold">Tổng</td>
                <td class="text-center bold">{{number_format($data->sum('customers'))}}</td>
                <td class="text-center bold">{{number_format($data->sum('schedules'))}}</td>
                <td class="text-center bold">{{number_format($data->sum('orders'))}}</td>
                <td class="text-center bold">{{number_format($data->sum('all_total'))}}</td>
                <td class="text-center bold">{{number_format($data->sum('gross_revenue'))}}</td>
                <td class="text-center bold">{{number_format($data->sum('the_rest'))}}</td>
                <td class="text-center bold">{{!empty($data->sum('orders'))?number_format($data->sum('all_total')/$data->sum('orders')):0}}</td>
            </tr>
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<!-- table-responsive -->
