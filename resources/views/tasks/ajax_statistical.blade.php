<style>
    .btn-new {
        color: #fff;
        font-weight: 600;
    }
    .noti-reletion {
        background: #f36a26;
        font-size: 10px;
        padding: 0 5px;
        position: absolute;
        color: #fff;
        border-radius: 10px;
        top: -8px;
        border: 2px solid #fff;
    }
    .not-number-account, .not-number-customer{
        font-weight: 700;
        display: block;
        line-height: 13px;
    }
</style>
<div class="scrollmenu col-md-7">
    @if(count($status))
        @forelse($status as $k => $s)
            <button class="btn btn-new {{$s->id == \App\Constants\StatusCode::NEW_TASK ?'bg-azure':($s->id == \App\Constants\StatusCode::DONE_TASK?'bg-success':'bg-danger')}}"
                    data-id="{{$s->id}}">{{$s->name}}
                <span class="not-number-account noti-reletion">{{$s->count}}</span>
            </button>
        @empty
        @endforelse
    @endif
</div>
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
            {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $docs->appends(['search' => request()->search ])->links() }}
    </div>
</div>

