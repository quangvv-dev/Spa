<div class="table-responsive">
    <table class="table card-table table-bordered table-vcenter text-nowrap table-primary">
        <thead class="text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white">Ảnh</th>
            <th class="text-white text-center">Tên</th>
            <th class="text-white text-center">Mã</th>
{{--            <th class="text-white text-center">Mô tả ngắn</th>--}}
            <th class="text-white text-center">Nhà cung cấp</th>
            <th class="text-white text-center">Thuộc danh mục</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <td class="text-center">{{$k+1}}</td>
                    <td class="text-center">
                        <img src="{{App\Helpers\Functions::getImageModels($s,'services','images')}}" class="rounded-circle" height="60" width="60" />
                    </td>
                    <td class="text-center">{{@$s->name}}</td>
                    <td class="text-center">{{@$s->code}}</td>
{{--                    <td class="text-center">{{$s->description}}</td>--}}
                    <td class="text-center">{{@$s->trademark}}</td>
                    <td class="text-center">{{@$s->category->name}}</td>
                    <td class="text-center">{{@$s->active_text}}</td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('combos/' . $s->id . '/edit') }}"><i
                                    class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('combos/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
        </tbody>
        @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
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
