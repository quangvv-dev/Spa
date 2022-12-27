<div class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">STT</th>
            <th class="text-center">Họ và tên</th>
            <th class="text-center no-wrap">Số tiền chi tiêu (1)</th>
            <th class="text-center">Data(2)</th>
            <th class="text-center">Tiền/Data(3)</th>
            <th class="text-center">SĐT(4)</th>
            <th class="text-center">Tỷ lệ xin số</th>
            <th class="text-center">$/SDT</th>
            <th class="text-center">DS KH</th>
            <th class="text-center">Doanh thu</th>
            <th class="text-center">% Chi phí/Dthu</th>
            <th class="text-center">% Chi phí/Doanh số</th>
            <th class="text-center no-wrap">Hóa đơn</th>
        </tr>
        </thead>
        <tbody>
        @forelse($priceMKT as $key=> $item)
            <tr>
                <td class="text-center pdr10">{{$key+1}}</td>
                <td class="text-center pdr10">{{@$item->user->full_name}}</td>
                <td class="text-center pdr10">{{number_format($item->sum_budged)}}</td>
                <td class="text-center pdr10">{{number_format($item->sum_data)}}</td>
                <td class="text-center pdr10">{{$item->sum_data > 0 ? number_format(round($item->sum_budged/$item->sum_data,2)) : 0}}</td>
                <td class="text-center pdr10">{{number_format($item->customer)}}</td>
                <td class="text-center pdr10">{{$item->sum_data > 0 ? round($item->customer/$item->sum_data,3)*100 : 0}} %</td>
                <td class="text-center pdr10">{{$item->customer > 0 ? number_format(round($item->sum_budged/$item->customer,2)) : 0}}</td>
                <td class="text-center pdr10">{{number_format($item->doanh_so)}}</td>
                <td class="text-center pdr10">{{number_format($item->doanh_thu)}}</td>
                <td class="text-center pdr10">{{$item->doanh_thu > 0 ? round($item->sum_budged/$item->doanh_thu,3)*100 : 0}} %</td>
                <td class="text-center pdr10">{{$item->doanh_so > 0 ? round($item->sum_budged/$item->doanh_so,3)*100 : 0}} %</td>
                <td class="text-center pdr10">{{number_format($item->sum_invoice)}}</td>

            </tr>
        @empty
        @endforelse
        </tbody>
    </table>
</div>
