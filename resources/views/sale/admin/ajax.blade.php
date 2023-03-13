<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center"></th>
            <th class="text-center">Nhân viên</th>
            <th class="text-center no-wrap">HV đăng ký</th>
            <th class="text-center">Doanh số</th>
            <th class="text-center">Thực thu</th>
            <th class="text-center">Nợ lại</th>
            <th class="text-center">Thu nợ</th>
            <th class="text-center">Upsale</th>
            <th class="text-center">Đơn trung bình<span class=""><br>(doanh số)</span></th>
        <tr class="number_index">
            <th class="text-center" colspan="2"></th>
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(7)</th>
        </tr>
        </thead>

        <tbody>

        @if(count($users))
            <tr>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">{{@number_format($users->sum('orders'))}}</td>
                <td class="text-center bold">{{@number_format($users->sum('all_total'))}}</td>
                <td class="text-center bold">{{@number_format($users->sum('gross_revenue'))}}</td>
                <td class="text-center bold">{{@number_format($users->sum('all_total') - ($users->sum('gross_revenue') - $users->sum('the_rest')))}}</td>
                <td class="text-center bold">{{@number_format($users->sum('the_rest'))}}</td>
                <td class="text-center bold">{{@number_format($users->sum('upsales'))}}</td>
                <td class="text-center bold">{{!empty($users->sum('orders'))?@number_format($users->sum('all_total')/$users->sum('orders')):0}}</td>
            </tr>
            @foreach($users as $item)
                <tr class="">
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10">{{$item->full_name}}
                    <td class="text-center pdr10">{{number_format($item->orders)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_total)}}</td>
                    <td class="text-center pdr10">{{number_format($item->gross_revenue)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_total - ($item->gross_revenue - $item->the_rest))}}</td>
                    <td class="text-center pdr10">{{number_format($item->the_rest)}}</td>
                    <td class="text-center pdr10">{{number_format($item->upsales)}}</td>
                    <td class="text-center pdr10">{{!empty($item->orders)?number_format($item->all_total/$item->orders):0}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
