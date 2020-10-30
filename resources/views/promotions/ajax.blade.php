<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Voucher</th>
            <th class="text-white text-center">Loại</th>
            <th class="text-white text-center">Mã voucher</th>
            <th class="text-white text-center">Số lượng</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k+1}}</th>
                    <td class="text-center">{{$s->title}}</td>
                    <td class="text-center">{{$s->type}}</td>
                    <td class="text-center">{{$s->code}}</td>
                    <td class="text-center">{{$s->quantity}}</td>
                    </td>
                    <td class="text-center">
                        <a class="btn" href="{{ route('promotions.edit',$s->id) }}"><i
                                class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ route('promotions.destroy',$s->id) }}"><i class="fas fa-trash-alt"></i></a>
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
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $docs->appends(['search' => request()->search ])->links() }}
    </div>
</div>

