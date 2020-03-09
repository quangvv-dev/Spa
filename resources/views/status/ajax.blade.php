<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên nhóm</th>
            <th class="text-white text-center">Mã nhóm</th>
            <th class="text-white text-center">Loại nhóm</th>
            <th class="text-white text-center">Vị trí</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(count(@$docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{$s->name}}</td>
                    <td class="text-center">{{$s->code}}</td>
                    <td class="text-center">
                        @foreach($types_pluck as $k1 => $v)
                            @if($s->type == $k1)
                                @php echo $v @endphp
                            @endif
                        @endforeach
                    </td>
                    <td class="text-center">{{$s->position}}</td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('status/' . $s->id . '/edit') }}"><i
                                    class="fas fa-edit"></i></a>
                        <a {{$s->type==App\Constants\StatusCode::RELATIONSHIP?'style=display:none':''}} class="btn delete" href="javascript:void(0)" data-url="{{ url('status/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
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
