<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tiêu đề</th>
            <th class="text-white text-center">Ngày bắt đầu</th>
            <th class="text-white text-center">Ngày kết thúc</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $rule)

{{--                    <td class="text-center">--}}
{{--                        <a class="btn" href="{{ url('category/' . $s->id . '/edit') }}"><i--}}
{{--                                    class="fas fa-edit"></i></a>--}}
{{--                        <a class="btn delete" href="javascript:void(0)"--}}
{{--                           data-url="{{ url('category/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>--}}
{{--                    </td>--}}
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="lalign">{{$rule->title}}</td>
                    <td><span class="text-center">{{$rule->start_at}}</span></td>
                    <td><span class="text-center">{{$rule->end_at}}</span></td>
                    <td>
                        @if($rule->status)
                            <span class="status-icon bg-primary"></span>Kích hoạt
                        @else
                            <span class="status-icon bg-warning"></span>Tạm ngưng
                    @endif
                    <td>
                        <a href="{{url('rules/'.$rule->id)}}" class="btn btn-primary">Sửa</a>
                        <a href="#" class="btn btn-danger">Xóa</a>
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

