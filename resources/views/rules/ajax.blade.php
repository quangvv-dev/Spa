<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tiêu đề</th>
            {{--<th class="text-white text-center">Ngày bắt đầu</th>--}}
            {{--<th class="text-white text-center">Ngày kết thúc</th>--}}
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $rule)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="lalign">{{$rule->title}}</td>
                    {{--<td><span class="text-center">{{$rule->start_at}}</span></td>--}}
                    {{--<td><span class="text-center">{{$rule->end_at}}</span></td>--}}
                    <td class="text-center">
                        @if($rule->status)
                            <span class="status-icon bg-primary"></span>Kích hoạt
                        @else
                            <span class="status-icon bg-warning"></span>Tạm ngưng
                    @endif
                    <td class="text-center">
                        <a href="{{url('rules/'.$rule->id)}}" class="btn btn-primary">Sửa</a>
                        <a href="javascript:void(0)" class="btn btn-danger delete" data-url="{{url('rules/' . $rule->id)}}">Xóa</a>
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

