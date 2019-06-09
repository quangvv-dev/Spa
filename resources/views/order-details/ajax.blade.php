<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày lên đơn</th>
            <th class="text-white text-center">Mã KH</th>
            <th class="text-white text-center">Tên KH</th>
            <th class="text-white text-center">SDT</th>
            <th class="text-white text-center">Sản phẩm</th>
            <th class="text-white text-center">Số lượng</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">CK(%)</th>
            <th class="text-white text-center">CK(Đ)</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Đã thanh toán</th>
            <th class="text-white text-center">Còn lại</th>
            <th class="text-white text-center">Người lên đơn</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if (count($orders))
            @foreach($orders as $order)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                    <td class="text-center">{{ $order->user->account_code }}</td>
                    <td class="text-center">{{ $order->user->full_name }}</td>
                    <td class="text-center">{{ $order->user->phone }}</td>
                    <td class="text-center"></td>
                    <td class="text-center">{{ $order->orderDetails->sum('quantity') }}</td>
                    <td class="text-center">{{ number_format($order->all_total) }}</td>
                    <td class="text-center">{{ $order->orderDetails->sum('percent_discount') }}</td>
                    <td class="text-center">{{ number_format($order->orderDetails->sum('number_discount')) }}</td>
                    <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
                    <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
                    <td class="text-center">{{ number_format($order->the_rest) }}</td>
                    <td class="text-center">{{ @$order->user->marketing->full_name }}</td>
                    <td class="text-center">
                        <a title="In hóa đơn" class="btn" href="{{ url('order/' . $order->id . '/show') }}"><i
                                    class="fas fa-file-invoice-dollar"></i></a>
                        <a title="Chia hoa hồng" class="btn" href="{{ url('commission/' . $order->id) }}"><i class="fas fa-dollar-sign"></i></a>
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
