<div class="table-responsive" id="registration-form">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Lý do</th>
            <th class="text-white text-center">Số tiền</th>
            <th class="text-white text-center">Người duyệt</th>
            <th class="text-white text-center">Loại</th>
            <th class="text-white text-center">Ghi chú</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>

        </thead>
        <tbody>
        <tr>
            <td class="text-center bold" colspan="2">Tổng:</td>
            <td class="text-center bold">{{number_format($allPrice)}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @if(count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <th scope="row">{{$k+1}}</th>
                    <td class="text-center">{{@$s->lyDoThuChi->name}}</td>
                    <td class="text-center">{{number_format($s->so_tien)}}</td>
                    <td class="text-center">{{@$s->duyet->full_name}}</td>
                    <td class="text-center">{{$s->type == 0?'Tiền mặt' : 'Chuyển khoản'}}</td>
                    <td class="text-center">{{$s->note}}</td>
                    <td class="text-center">
                        {{--{{$s->status == 0 ? 'Chưa duyệt' :'Đã duyệt'}}--}}
                        <label class="switch">
                            <input class="change_status" data-id="{{$s->id}}" type="checkbox" {{$s->status == 1? 'checked' : ''}}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('thu-chi/' . $s->id . '/edit') }}"><i
                                    class="fas fa-edit"></i></a>
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('thu-chi/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
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

