<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tiêu đề</th>
            <th class="text-white text-center">Đường dẫn</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{$s->title}}</td>
                    <td class="text-center">
                        <input type="text" class="form-control slug" value="{{url('post/'.$s->slug)}}">
                    </td>
                    <td class="text-center">
                        <a title="sao chép" class="btn coppy" href="javascript:void(0)"><i class="fas fa-copy"></i></a>
                        <a class="btn" href="{{ route('landipages.edit',$s->id) }}"><i class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)" data-url="{{ url('posts/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
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

