<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày đặt lịch</th>
            <th class="text-white text-center">Giờ đặt từ</th>
            <th class="text-white text-center">Giờ đặt tới</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Người tạo</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{$s->date}}</td>
                    <td class="text-center">{{$s->time_from}}</td>
                    <td class="text-center">{{@$s->time_to}}
                    <td class="text-center">{{@$s->creator->full_name}}</td>
                    <td class="text-center">{{@$s->staff->full_name}}</td>
                    <td class="text-center">
                        @switch($s->status)
                            @case(1)
                            <span class="label label-default">Hẹn gọi lại</span>
                            @break
                            @case(2)
                            <span class="label label-primary">Đặt lịch</span>
                            @break
                            @case(3)
                            <span class="label label-success">Đã đến</span>
                            @break
                            @case(4)
                            <span class="label label-danger">Không đến</span>
                            @break
                            @case(5)
                            <span class="label label-warning">Hủy</span>
                            @break
                        @endswitch
                    </td>
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
    @include('schedules.modal')
    {{--    END Modal thêm --}}
</div>
