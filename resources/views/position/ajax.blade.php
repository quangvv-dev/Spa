<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-bordered table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Chức vụ</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <td class="text-center">{{$k}}</td>
                    <td class="text-center">{{$s->name}}</td>
                    <td class="text-center">
                        <a class="btn update" href="#" data-id="{{$s->id}}" title="Chỉnh sửa lịch hẹn"
                           data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit"></i></a>
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
    {{--    Modal thêm --}}
    @include('position.modal')
    {{--    END Modal thêm --}}
</div>
