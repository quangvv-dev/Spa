<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-bordered table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Tiêu đề</th>
            <th class="text-white text-center">Optin form</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <td class="text-center">{{$k}}</td>
                    <td class="text-center">{{@$s->campaign->name}}</td>
                    <td class="text-center">{{$s->title}}</td>
                    <td class="text-center"><a href="{{url('form/'.$s->id)}}"><i class="fa fa-edit"></i> Kết nối</a></td>
                    <td class="text-center">{{@$s->branch->name}}</td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('posts/' . $s->id . '/edit') }}"><i
                                class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('posts/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="8">Không tồn tại dữ liệu</td>
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

