<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Người thực hiện</th>
            <th class="text-white text-center">Ngày đặt hàng</th>
            <th class="text-white text-center">Tổng tiền</th>
        </tr>
        </thead>
        <tbody style="background: white;">
        @if (count($customer->orders))
            @foreach($customer->orders as $order)
                <tr>
                    <td class="text-center">{{ @$customer->marketing->full_name }}</td>
                    <td class="text-center">{{ date('d-m-Y H:i:s', strtotime($order->created_at)) }}</td>
                    <td class="text-center">{{ $order->all_total }}</td>
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