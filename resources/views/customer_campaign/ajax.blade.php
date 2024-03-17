<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Còn nợ</th>
            <th class="text-white text-center">Sale</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Chi nhánh</th>
        </tr>
        </thead>
        <tbody>
        @if (count($customers))
            @foreach($customers as $k => $c)
                <tr>
                    <th scope="row">{{ $k +1 }}</th>
                    <td class="text-center">{{@$c->customer->full_name}}
                        <a class="view_modal" data-customer-id="{{ $c->customer_id }}" href="#">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                    <td class="text-center"><a href="callto:{{@$c->customer->phone }}">{{ str_limit(@$c->customer->phone,7,'xxx') }}</a>
                    </td>
                    <td class="text-center">{{@$c->orders->count()}}</td>
                    <td class="text-center">{{@number_format($c->orders->sum('all_total'))}}</td>
                    <td class="text-center">{{@number_format($c->orders->sum('gross_revenue'))}}</td>
                    <td class="text-center">{{@number_format($c->orders->sum('all_total') - $c->orders->sum('gross_revenue'))}}</td>
                    <td class="text-center">{{@$c->sale->full_name}}</td>
                    <td class="text-center">
                        {!! Form::select('the_rest', \App\Models\CustomerCampaign::statusLabel, @$c->status, array('class' => 'form-control status',
                            'data-id'=> $c->id,'placeholder'=>'Tất cả trạng thái')) !!}
                    </td>
                    <td class="text-center">{{@$c->customer->branch->name}}</td>
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
