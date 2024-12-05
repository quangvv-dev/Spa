<div id="registration-form">
    <div class="table-responsive tableFixHead table-bordered table-hover">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Kho</th>
                <th class="text-center">Sản phẩm</th>
                <th class="text-center">Tồn</th>
                <th class="text-center">Xuất bán</th>
                <th class="text-center">Tiêu hao/hỏng</th>
                <th class="text-center">Hàng tặng</th>

            </tr>
            <tr class="bold">
                <td class="text-center bold" colspan="2">Tổng</td>
                <td class="text-center bold" ></td>
                <td class="text-center bold">{{@number_format($docs->sum('quantity'))}} </td>
                <td class="text-center bold">{{@number_format($docs->sum('xuat_ban'))}}</td>
                <td class="text-center bold">{{@number_format($docs->sum('tieu_hao'))}}</td>
                <td class="text-center bold">{{$docs->sum('quantityGifts') >0 ?@number_format($docs->sum('quantityGifts')).' ('. @number_format($docs->sum('orderGifts')).' đơn)':0}}</td>

            </tr>
            </thead>
            <tbody>
            @if(count($docs))
                @foreach($docs as $key => $item)
                    <tr>
                        <td class="text-center">{{@$key+1}}</td>
                        <td class="text-center">{{@$item->branch->name}}</td>
                        <td class="text-center">{{@$item->product->name}}</td>
                        <td class="text-center">{{@number_format($item->quantity)}} </td>
                        <td class="text-center">{{@number_format($item->xuat_ban)}}</td>
                        <td class="text-center">{{@number_format($item->tieu_hao)}}</td>
                        <td class="text-center">{{$item->quantityGifts > 0 ?@number_format($item->quantityGifts) .' ('.@number_format($item->orderGifts).' đơn)':0}} </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="10">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

