<div class="table-responsive">
    <table class="table card-table table-bordered table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Thumbnail</th>
            <th class="text-white text-center">Tên nhóm</th>
            <th class="text-white text-center">Mã nhóm</th>
{{--            <th class="text-white text-center">Giá công KTV (Nếu có)</th>--}}
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th class="text-center">{{$k}}</th>
                    <td class="text-center">
                        <img src="{{$s->image?:'/assets/images/brand/logoNew.png'}}" class="rounded-circle" height="60" width="60" />
                    </td>
                    <td class="text-center">{{$s->name}}</td>
                    <td class="text-center">{{$s->code}}</td>
{{--                    <td class="text-center">{{@number_format($s->price)}}</td>--}}
                    <td class="text-center">
                        <a class="btn" href="{{ url('category/' . $s->id . '/edit') }}"><i
                                class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('category/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
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
        {{ $docs->appends(['name' => @$input['name'],'type_category' => @$input['type_category'] ])->links() }}
    </div>
</div>

