<div class="table-responsive tableFixHead" id="parent">
    <table class="table card-table table-vcenter table-bordered text-nowrap table-primary" id="fixTable">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày đặt hàng</th>
            <th class="text-white text-center">Ngày thanh toán</th>
            <th class="text-white text-center">Mã ĐH</th>
            <th class="text-white text-center">Tên KH</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Dịch vụ</th>
            <th class="text-white text-center">Số tiền</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">MKT</th>
            <th class="text-white text-center">Carepage</th>
            <th class="text-white text-center">Phương thức thanh toán</th>
            <th class="text-white text-center">Người lên đơn</th>
        </tr>
        </thead>
        <tbody>
        @if (count($orders))
            @foreach($orders as $k => $order)
                <tr>
                    <td class="text-center">{{ $k +1 }}</td>
                    <td class="text-center">{{ isset($order->order) ? @date("d-m-Y", strtotime($order->order->created_at)) : '' }}</td>
                    <td class="text-center">{{ isset($order->payment_date) ? date("d-m-Y", strtotime($order->payment_date)) : '' }}</td>
                    <td class="text-center"><a
                            href="{{isset($order->order)?route('order.show',$order->order_id):'#'}}">{{isset($order->order) ? $order->order->code:' ' }}</a>
                    </td>
                    <td class="text-center">{{isset($order->order) && isset($order->order->customer) ? @$order->order->customer->full_name :''}}</td>
                    <td class="text-center">{{ isset($order->order) && isset($order->order->customer) ?
                    (auth()->user()->permission('phone.open') ? @$order->order->customer->phone : @str_limit($order->order->customer->phone, 7, 'xxx')) :''}}</td>
                    <td class="text-center">{!! isset($order->order) && !empty($order->order->service_text) ? @$order->order->service_text :'' !!}</td>
                    <td class="text-center">{{ @number_format($order->price) }}</td>
                    <td class="text-center">
                        <span class="small-tip">
                        {{ isset($order->order) && isset($order->order->customer)&& isset($order->order->customer->telesale)? @$order->order->customer->telesale->full_name:'' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="small-tip">
                        {{ isset($order->order) && isset($order->order->customer)&& isset($order->order->customer->marketing)? @$order->order->customer->marketing->full_name:'' }}
                        </span>
                    <td class="text-center">
                        <span class="small-tip">
                        {{ isset($order->order) && isset($order->order->customer)&& isset($order->order->customer->carepage)? @$order->order->customer->carepage->full_name:'' }}
                        </span>
                    </td>
                    <td class="text-center">{{ isset($order->payment_type) ? $order->name_payment_type:' ' }}</td>
                    <td class="text-center">{{ isset($order->order)&& isset($order->order->owner)? @$order->order->owner->full_name:'' }}</td>
                </tr>
            @endforeach
            <tr class="fixed2">
                <td class="text-center" colspan="6"></td>
                <td class="text-center bold">Tổng trang</td>
                <td class="text-center bold">{{ @number_format($allTotalPage) }}</td>
                <td colspan="5" class="text-center"></td>
            </tr>
            <tr class="fixed">
                <td class="text-center" colspan="6"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">{{ @number_format($allTotal) }}</td>
                <td colspan="5" class="text-center"></td>

            </tr>
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="11">Không tồn tại dữ liệu</td>
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
@include('order-details.order-detail-modal')
<!-- table-responsive -->
