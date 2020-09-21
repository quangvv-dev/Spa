<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày thực hiện</th>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">Công việc</th>
            <th class="text-white text-center">Loại công việc</th>
            <th class="text-white text-center">Trạng thái</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{$s->date_from}}</td>
                    <td class="text-center">{{@$s->user->full_name}}</td>
                    <td class="text-center">{{@$s->customer->full_name}}</td>
                    <td class="text-center">{{$s->name}}</td>
                    <td class="text-center">{{$s->type==\App\Constants\NotificationConstant::CALL?'Gọi điên':'CSKH'}}</td>
                    <td class="text-center">{{$s->task_status_id}}
                    <span class="tag tag-azure">123123</span>
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

