<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên nhóm</th>
            <th class="text-white text-center">Mã nhóm</th>
            <th class="text-white text-center">Nhóm cha</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{$s->name}}</td>
                    <td class="text-center">{{$s->code}}</td>
                    <td class="text-center">{{@$s->categories->name}}
                    </td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('category-product/' . $s->id . '/edit') }}"><i
                                    class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('category-product/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
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
        {{ $docs->appends(['name' => @$input['name'],'type_category' => @$input['type_category'] ])->links() }}
    </div>
</div>

