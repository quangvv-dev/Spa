<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
{{--            <th class="text-white text-center">Tên nhóm</th>--}}
{{--            <th class="text-white text-center">Mã nhóm</th>--}}
{{--            <th class="text-white text-center">Nhóm cha</th>--}}
            <th class="text-white text-center">Lịch sử</th>
            <th class="text-white text-center">Ngày xoá</th>
        </tr>
        </thead>
        <tbody>
        @php
            $docs = \DB::table('group_comments')->where('user_id',77)->where('messages','like','%Xoá đơn hàng%')->paginate(50);
        @endphp
        @if(count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{$s->messages}}</td>
                    <td class="text-center">{{$s->created_at}}</td>
{{--                    <td class="text-center">{{$s->name}}</td>--}}
{{--                    <td class="text-center">{{$s->code}}</td>--}}
{{--                    <td class="text-center">{{@$s->categories->name}}--}}
{{--                    </td>--}}
{{--                    <td class="text-center">--}}
{{--                        <a class="btn" href="{{ url('category/' . $s->id . '/edit') }}"><i--}}
{{--                                    class="fas fa-edit"></i></a>--}}
{{--                        <a class="btn delete" href="javascript:void(0)"--}}
{{--                           data-url="{{ url('category/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>--}}
{{--                    </td>--}}
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

