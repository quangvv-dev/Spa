<div class="table-responsive">
    <table class="table card-table table-vcenter table-bordered text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên nhóm</th>
            <th class="text-white text-center">Mã nhóm</th>
            <th class="text-white text-center">Loại nhóm</th>
            <th class="text-white text-center">Màu sắc</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(count(@$docs))
            @foreach($docs as $k => $s)
                <tr data-id="{{$s->id}}" data-position='{{$s->position}}'>
                    <th class="text-center">{{$k}}</th>
                    <td class="text-center">{{$s->name}}</td>
                    <td class="text-center">{{$s->code}}</td>
                    <td class="text-center">
                        @foreach($types_pluck as $k1 => $v)
                            @if($s->type == $k1)
                                @php echo $v @endphp
                            @endif
                        @endforeach
                    </td>
                    <td class="text-center"><input class="bgcolor" type="color" name="color" value="{{$s->color}}" ></td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('status/' . $s->id . '/edit') }}"><i
                                    class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)" data-url="{{ url('status/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
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
