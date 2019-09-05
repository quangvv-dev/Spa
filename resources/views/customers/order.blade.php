<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Hành động</th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Tên SP</th>
            <th class="text-white text-center">Loại đơn</th>
            <th class="text-white text-center">Người thực hiện</th>
            <th class="text-white text-center">Số buổi</th>
            <th class="text-white text-center">Số tiền DH</th>
            <th class="text-white text-center">Đã thanh toán</th>
            <th class="text-white text-center">Còn lại</th>
        </tr>
        </thead>
        <tbody style="background: white;">
        @if (count($customer->orders))
            @foreach($customer->orders as $order)
                <tr>
                    <td class="text-center">
                        <a title="Thanh toán" class="btn" href="{{ url('order/' . $order->id . '/show') }}"><i
                                    class="fas fa-file-invoice-dollar"></i></a>
                        @if($order->type === \App\Models\Order::TYPE_ORDER_ADVANCE)
                            <a title="Trừ liệu trình" class="quantity-edit" data-order-id="{{ $order->id }}"><i style="color: #7b41d8;" class="fas fa-check-square"></i></a>
                        @endif
                    </td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                    <td class="text-center">
                        @foreach($order->orderDetails as $orderDetail)
                            {{ @$orderDetail->service->name }},
                        @endforeach
                    </td>
                    <td class="text-center">{{ $order->name_type }}</td>
                    <td class="text-center">{{ @$customer->marketing->full_name }}</td>
                    <td class="text-center"></td>
                    <td class="text-center">{{ number_format($order->all_total) }}</td>
                    <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
                    <td class="text-center">{{ number_format($order->the_rest) }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
