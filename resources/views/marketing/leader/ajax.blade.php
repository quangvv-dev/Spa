<div class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">STT</th>
            <th class="text-center">Marketing</th>
            <th class="text-center">Tiền/Data</th>
            <th class="text-center">Tỉ lệ xin số</th>
            <th class="text-center">Tiền/SDT</th>
            <th class="text-center">Chi phí/Dthu</th>
            <th class="text-center">Chi phí/Doanh số</th>
            <th class="text-center" colspan="2">DS KH</th>
            <th class="text-center" colspan="2">Doanh thu</th>
        </tr>
        <tr class="number_index">
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th class="text-center">KH mới</th>
            <th class="text-center">KH cũ</th>
            <th class="text-center">KH mới</th>
            <th class="text-center">KH cũ</th>
        </tr>
        </thead>

        <tbody>
            @forelse($marketing as $key=>$item)
                <tr class="">
                    <td class="text-center pdr10">{{$key+1}}</td>
                    <td class="text-center pdr10">{{@$item->user->full_name}}</td>
                    <td class="text-center pdr10">{{number_format($item->sum_data > 0 ? $item->sum_budged / $item->sum_data : 0)}}</td>

                    <td class="text-center pdr10">{{$item->sum_data > 0 ? round(($item->customer / $item->sum_data)*100,2) : 0}} %</td>

                    <td class="text-center pdr10">{{$item->customer > 0 ? number_format(round($item->sum_budged / $item->customer,2)) : 0}}</td>
                    <td class="text-center pdr10">{{$item->doanh_thu > 0 ? number_format(round($item->sum_budged / $item->doanh_thu,2)) : 0}}</td>
                    <td class="text-center pdr10">{{$item->doanh_so > 0 ? number_format(round($item->sum_budged / $item->doanh_so,2)) : 0}}</td>


                    <td class="text-center pdr10">{{number_format($item->doanh_so_kh_moi)}}</td>
                    <td class="text-center pdr10">{{number_format($item->doanh_so_kh_cu)}}</td>
                    <td class="text-center pdr10">{{number_format($item->doanh_thu_kh_moi)}}</td>
                    <td class="text-center pdr10">{{number_format($item->doanh_thu_kh_cu)}}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
