<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            {{--<th class="text-white">STT</th>--}}
            <th class="text-white text-center">Ngày thực hiện</th>
            <th class="text-white text-center">Nhân viên</th>
            {{--<th class="text-white text-center">Khách hàng</th>--}}
            <th class="text-white text-center">Công việc</th>
            <th class="text-white text-center">Loại công việc</th>
            <th class="text-white text-center">Trạng thái</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($tasks))
            @foreach($tasks as $k => $s)
                <tr>
                    {{--<th scope="row">{{$k}}</th>--}}
                    <td class="text-center">{{$s->date_from}}</td>
                    <td class="text-center">{{@$s->user->full_name}}</td>
                    {{--<td class="text-center">{{@$s->customer->full_name}}</td>--}}
                    <td class="text-center name-task" data-id="{{$s->id}}">
                        <span style="color: dodgerblue;cursor: pointer">{{$s->name}}</span>
                    </td>
                    <td class="text-center">{{$s->type==\App\Constants\NotificationConstant::CALL?'Gọi điên':'CSKH'}}</td>
                    <td class="text-center">
                        @if($s->task_status_id ==  \App\Constants\StatusCode::NEW_TASK)
                            <span class="tag tag-azure">Mới</span>
                        @elseif($s->task_status_id ==  \App\Constants\StatusCode::DONE_TASK)
                            <span class="tag tag-success">Hoàn thành</span>
                        @else
                            <span class="tag tag-danger">Quá hạn</span>
                        @endif
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
            {{ 'Tổng số ' . $tasks->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
</div>
