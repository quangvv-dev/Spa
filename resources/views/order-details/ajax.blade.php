<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên khách hàng</th>
            <th class="text-white text-center">Tổng tiền</th>
            <th class="text-white text-center">CK(%)</th>
            <th class="text-white text-center">CK(Đ)</th>
            <th class="text-white text-center">Số tiền còn lại</th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if (count($orders))
            @foreach($orders as $order)
                <tr>
                    <th scope="row">{{ $order->id }}</th>
                    <td class="text-center">{{ $order->user->full_name }}</td>
                    <td class="text-center">{{ number_format($order->all_total) }}</td>
                    <td class="text-center">{{ $order->orderDetails->sum('percent_discount') }}</td>
                    <td class="text-center">{{ number_format($order->orderDetails->sum('number_discount')) }}</td>
                    <td class="text-center">{{ number_format($order->the_rest) }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('order/' . $order->id . '/show') }}"><i
                                    class="fas fa-file-invoice-dollar"></i></a>
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
            {{ 'Tổng số ' . $orders->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $orders->appends(['search' => request()->search ])->links() }}
    </div>
</div>
<!-- table-responsive -->
