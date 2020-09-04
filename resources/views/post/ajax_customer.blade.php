<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th><input type="checkbox" class="selectall myCheck"></th>
            <th class="text-white"><i class="fa fa-save"></i></th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">ghi chú</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">T.T</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <td>
                        <input type="checkbox" name="delete[]" class="myCheck" value="{{$s->id}}"/>
                    </td>
                    @if($s->status == 0)
                        <td class="text-center update-status" data-id="{{$s->id}}" style="cursor: pointer">
                            <i class="fa fa-check-square text-primary" aria-hidden="true"></i></td>
                    @elseif($s->status == 1)
                        <td class="text-center">
                            <i class="fa fa-check-square text-danger" aria-hidden="true"></i>
                        </td>
                    @else
                        <td class="text-center">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                        </td>
                    @endif
                    <td class="text-center">{{@$s->created_at}}</td>
                    <td class="text-center">{{@str_limit($s->post->campaign->name,40)}}</td>
                    <td class="text-center">{{@$s->full_name}}</td>
                    <td class="text-center">{{@$s->phone}}</td>
                    <td class="text-center">{{@$s->note}}</td>
                    <td class="text-center telesale-customer"
                        data-customer-id="{{@$s->id}}">{{@$s->telesales->full_name}}</td>
                    <td class="text-center">{{@$s->status==\App\Constants\StatusConstant::NOT_CALL?'Chưa gọi':($s->status==\App\Constants\StatusConstant::CALL?'Đã gọi':'Đã đến')}}</td>
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

