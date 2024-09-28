<div class="scrollmenu col-md-7 mt-2 mb-2 ml-5">
    @if(count($status))
        @forelse($status as $k => $s)
            <button class="btn btn-new {{$s['id'] == \App\Constants\StatusCode::NEW_TASK ?'bg-azure':($s['id'] == \App\Constants\StatusCode::DONE_TASK?'bg-success':'bg-danger')}}"
                    data-id="{{$s['id']}}">{{$s['name']}}
                <span class="not-number-account noti-reletion">{{$s['count']}}</span>
            </button>
        @empty
        @endforelse
    @endif
</div>
<div class="table-responsive">
    <div class="content__table">
        <table class="table table-striped table-bordered table-bordered">
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
                        <td scope="row">{{$k}}</td>
                        <td class="text-center">{{$s->date_from}}</td>
                        <td class="text-center">{{@$s->user->full_name}}</td>
                        <td class="text-center">{{@$s->customer->full_name}}<br>
                            <span class="small-tip">({{@str_limit($s->customer->phone,7,'xxx')}})</span>
                        </td>
                        <td class="text-center small-tip">{{Str::limit(preg_replace('/\b\d{10}\b/','',$s->name), 30)}}</td>
                        <td class="text-center">{{$s->type==\App\Constants\NotificationConstant::CALL?'Gọi điện':'CSKH'}}</td>
                        <td class="text-center">
                            @if($s->task_status_id ==  \App\Constants\StatusCode::NEW_TASK)
                                <a class="tag tag-azure" data-toggle="modal" data-target="#myModal" data-id="{{$s->id}}" data-content="{{json_encode($s)}}">Mới</a>
                            @elseif($s->task_status_id ==  \App\Constants\StatusCode::DONE_TASK)
                                <a class="tag tag-success" data-toggle="modal" data-target="#myModal" data-id="{{$s->id}}" data-content="{{json_encode($s)}}">Hoàn thành</a>
                            @else
                                <a class="tag tag-danger" data-toggle="modal" data-target="#myModal" data-id="{{$s->id}}" data-content="{{json_encode($s)}}">Quá hạn</a>
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
    </div>

    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $docs->appends(['search' => request()->search ])->links() }}
    </div>
</div>

