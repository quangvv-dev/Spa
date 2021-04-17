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
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($schedules))
            @foreach($schedules as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{$s->date}}</td>
                    <td class="text-center">{{$s->time_from}}</td>
                    <td class="text-center">{{@$s->time_to}}</td>
                    <td class="text-center status" data-id="{{ $s->id }}"> {{ @$s->name_status }}</td>
                    <td class="text-center">{{@$s->creator->full_name}}</td>
                    <td class="text-center">
                        <a class=" update" href="#" data-id="{{$s->id}}" title="Chỉnh sửa lịch hẹn"
                           data-toggle="modal" data-target="#updateModal"><i class="fas fa-pencil-alt"></i></a>
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
            {{ 'Tổng số ' . $schedules->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $schedules->appends(['search' => request()->search ])->links() }}
    </div>
</div>
