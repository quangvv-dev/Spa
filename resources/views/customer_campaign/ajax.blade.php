<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Sale</th>
            <th class="text-white text-center">CSKH</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center">H.thành</th>
        </tr>
        </thead>
        <tbody>
        @if (count($customers))
            @foreach($customers as $k => $c)
                <tr>
                    <th scope="row">{{ $k +1 }}</th>
                    <td class="text-center">{{@$c->campaign->name}}</td>
                    <td class="text-center">{{@$c->customer->full_name}}</td>
                    <td class="text-center">{{@$c->customer->phone}}</td>
                    <td class="text-center">{{@$c->customer->status->name}}</td>
                    <td class="text-center">{{@$c->sale->full_name}}</td>
                    <td class="text-center">{{@$c->cskh->full_name}}</td>
                    <td class="text-center">{{@$c->customer->branch->name}}</td>
                    <td class="text-center"><input type="checkbox"></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="11">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $customers->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $customers->links() }}
    </div>
</div>
<!-- table-responsive -->
