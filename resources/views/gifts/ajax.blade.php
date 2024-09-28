<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-bordered table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Ngày tặng</th>
            <th class="text-white text-center">Sản phẩm</th>
            <th class="text-white text-center">Số lượng</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center"></th>
        </tr>
        </thead>
        <tbody>
        @if(isset($gifts) && count($gifts))
            @foreach($gifts as $k => $s)
                <tr>
                    <td class="text-center">{{@formatYMD($s->created_at)}}</td>
                    <td class="text-center">{{isset($s->product)?$s->product->name:''}}</td>
                    <td class="text-center">{{@$s->quantity}}</td>
                    <td class="text-center">{{@$s->branch->name}}</td>
                    <td class="text-center">
                        <a class="btn delete" href="javascript:void(0)" data-url="{{'/gifts/'.$s->id}}">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </td>
                   </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="7">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    @if(isset($gifts) && count($gifts))
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $gifts->total(). ' quà đã tặng ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $gifts->appends(['search' => request()->search ])->links() }}
    </div>
    @endif
</div>

