<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">ghi chú</th>
            {{--<th class="text-white text-center">Thao tác</th>--}}
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{@$s->created_at}}</td>
                    <td class="text-center">{{@$s->post->campaign->name}}</td>
                    <td class="text-center">{{@$s->full_name}}</td>
                    <td class="text-center">{{@$s->phone}}</td>
                    <td class="text-center">
                        {{@$s->note}}
                    </td>
                    {{--<td class="text-center">--}}
                        {{--<a class="btn" href="{{ url('posts/' . $s->id . '/edit') }}"><i--}}
                                {{--class="fas fa-edit"></i></a>--}}
                        {{--<a class="btn delete" href="javascript:void(0)"--}}
                           {{--data-url="{{ url('posts/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>--}}
                    {{--</td>--}}
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

