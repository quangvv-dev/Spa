<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Ngày áp dụng</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if (count($campaigns))
            @foreach($campaigns as $k => $c)
                <tr>
                    <th scope="row">{{ $k +1 }}</th>
                    <td class="text-center"><a href="{{route('campaigns.edit',$c->id)}}">{{ $c->name }}</a></td>
                    <td class="text-center"><span class="small-tip-custom">{{ $c->start_date.' -> '.$c->end_date }}</span></td>
                    <td class="text-center">{{@$c->customer_campaign->count()}} <br>
                    <td class="text-center">{{$c->status_text}} <br>
                        <span class="small-tip">({{ $c->from_order.' -> '.$c->to_order }})</span>
                    </td>
                    <td class="text-center"><span class="title-small">({{$c->sale_text}})</span></td>
                    <td class="text-center">{{$c->branch_text}}</td>
                    <td class="text-center">
                        <a title="sửa tài khoản" class="btn" href="{{ route('campaigns.edit', $c->id) }}"><i class="fas fa-edit"></i></a>
                        <a title="Xóa tài khoản" class="btn delete" href="javascript:void(0)"
                           data-url="{{ route('campaigns.destroy', $c->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $campaigns->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $campaigns->links() }}
    </div>
</div>
<!-- table-responsive -->
