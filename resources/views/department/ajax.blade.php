<div class="table-responsive">
    <table class="table card-table table-bordered table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên phòng ban</th>
            <th class="text-white text-center">Trực thuộc</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <td class="text-center">{{$k}}</td>
                    <td class="text-center">{{$s->name}}</td>
                    <td class="text-center">{{@$s->parent->name}}</td>
                    <td class="text-center">
                        <a title="Tạo chức vụ" href="{{url('position/'.$s->id)}}"><i class="fas fa-user-plus"></i></a>
                        <a title="Chỉnh sửa" class="btn" href="{{ url('department/' . $s->id . '/edit') }}"><i
                                class="fas fa-edit"></i></a>
                        @if(!$s->childRelation->count() && $s->id>\App\Constants\DepartmentConstant::Y_TA)
                            <a title="Xóa" class="btn delete" href="javascript:void(0)"
                               data-url="{{ url('department/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
                        @endif
                    </td>
                </tr>
        </tbody>
        @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="7">Không tồn tại dữ liệu</td>
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

