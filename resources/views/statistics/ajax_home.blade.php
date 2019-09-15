<style>
    .padding-bottom {
        padding-bottom: 10px;
    }
</style>

<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Khách hàng mới</th>
            <th class="text-white text-center">Tương tác</th>
{{--            <th class="text-white text-center">Hoạt động</th>--}}
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh thu</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center"><h2>{{ count($customer) }}</h2></td>
            <td class="text-center"><h2>{{count($books) + count($receive) + count($comment)}}</h2></td>
{{--            <td class="text-center"><h2>0</h2></td>--}}
            <td class="text-center"><h2>{{$countOrders }}</h2></td>
            <td class="text-center"><h2>{{number_format((int)$commision+($price_customer?:0 * 20000))}}</h2></td>
        </tr>
        <tr>
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Facebook :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Tool Facebook :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Hotline :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Khách Giới Thiệu :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
            </td>
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Trao đổi :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{ count($comment) }}
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Lịch hẹn :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{count($books)}}
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Đã đến :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{count($receive)}}
                    </div>
                </div>
                {{--                <div class="col row padding-bottom">--}}
                {{--                    <div class="col-md-8 col-xs-6 title">--}}
                {{--                        Cuộc gọi :--}}
                {{--                    </div>--}}
                {{--                    <div class="col-md-4 col-xs-6 title">--}}
                {{--                        0--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </td>
            {{--            <td class="text-center">3</td>--}}
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Đơn hàng :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{$countOrders}}
                    </div>
                </div>
            </td>
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Khách hàng mới mua dịch vụ :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{number_format((int)$price_customer * 20000)}}
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Hoa hồng :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{number_format((int)$commision)}}
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="row">
    {{--<div class="col-md-6">--}}
    {{--<div id="piechart_relation_account" class="row tc">--}}
    {{--</div>--}}
    {{--<div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>--}}
    {{--</div>--}}
    <div class="col-md-6">
        <div id="piechart-1"></div>
    </div>
    <div class="col-md-6">
        <div id="piechart-2"></div>
    </div>
</div>
<div class="row">
    {{--<div class="col-md-6">--}}
    {{--<div id="piechart_relation_account" class="row tc">--}}
    {{--</div>--}}
    {{--<div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>--}}
    {{--</div>--}}
    <div class="col-md-6">
        <div id="piechart-3"></div>
    </div>
    <div class="col-md-6">
        <div id="piechart-4"></div>
    </div>
</div>

<div class="card-header">
    <h3 class="card-title">Đơn hàng bán</h3>
</div>
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Ngày</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Đã thanh toán</th>
            <th class="text-white text-center">Còn lại</th>
            <th class="text-white text-center">Lợi nhuận được chia</th>
            <th class="text-white text-center">Người thực hiện</th>
        </tr>
        </thead>
        <tbody>
        @if (count($orders))
        @foreach($orders as $order)
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-center">
                @foreach($order->orderDetails as $orderDetail)
                    {{ @$orderDetail->service->name }},
                @endforeach
                - {{$order->customer->full_name}}
            </td>
            <td class="text-center">{{ $order->created_at }}</td>
            <td class="text-center">{{ number_format($order->all_total) }}</td>
            <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
            <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
            <td class="text-center">{{ number_format($order->the_rest) }}</td>
            <td class="text-center">{{ $order->rose_price }}</td>
            <td class="text-center">{{ @$order->customer->marketing->full_name }}</td>
        </tr>
        @endforeach
        <tr>
            <td class="text-center bold">Tổng</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center">{{ number_format($orders->sum('all_total')) }}</td>
            <td class="text-center">{{ number_format($orders->sum('gross_revenue')) }}</td>
            <td class="text-center">{{ number_format($orders->sum('gross_revenue')) }}</td>
            <td class="text-center">{{ number_format($orders->sum('the_rest')) }}</td>
            <td class="text-center">{{ number_format($orders->sum('rose_price')) }}</td>
            <td class="text-center bold">  </td>
        </tr>
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{--{{ 'Tổng số ' . $orders->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}--}}
        </div>
    </div>
    <div class="pull-right">
        {{--{{ $orders->links() }}--}}
    </div>
</div>
<!-- table-responsive -->
