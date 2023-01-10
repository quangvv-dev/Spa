<div class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Tỉnh/TP</th>
                <th class="text-center" colspan="3">Doanh số</th>
                <th class="text-center" colspan="3">Doanh thu</th>
                <th class="text-center" colspan="3">Doanh thu công nợ</th>
            </tr>
            <tr class="tr1" style="text-transform:unset">
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center">Số đơn</th>
                <th class="text-center">Giá trị TB đơn</th>
                <th class="text-center">Doanh số</th>

                <th class="text-center">Số đơn</th>
                <th class="text-center">Giá trị TB đơn</th>
                <th class="text-center">Doanh thu</th>

                <th class="text-center">Số đơn</th>
                <th class="text-center">Giá trị TB đơn</th>
                <th class="text-center">Doanh thu</th>
            </tr>

        </thead>

        <tbody>

        @forelse($data as $key=>$item)
            <tr>
                <td class="text-center">{{$key+1}}</td>
                <td class="text-center">{{$item->name}}</td>
                <td class="text-center">{{number_format($item->so_don)}}</td>
                <td class="text-center">{{$item->so_don > 0 ? number_format($item->doanh_so / $item->so_don) : 0}}</td>
                <td class="text-center">{{number_format($item->doanh_so)}}</td>

                <td class="text-center">{{number_format($item->so_don_doanh_thu)}}</td>
                <td class="text-center">{{$item->so_don_doanh_thu > 0 ? number_format($item->doanh_thu / $item->so_don_doanh_thu) : 0}}</td>
                <td class="text-center">{{number_format($item->doanh_thu)}}</td>

                <td class="text-center">{{number_format($item->so_don_no)}}</td>
                <td class="text-center">{{$item->so_don_no > 0 ? number_format($item->doanh_thu_no / $item->so_don_no) : 0}}</td>
                <td class="text-center">{{number_format($item->doanh_thu_no)}}</td>
            </tr>
            @empty
        @endforelse
        </tbody>
    </table>
</div>
