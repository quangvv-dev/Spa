<div class="table-responsive tableFixHead" id="parent">
    <table class="table card-table table-vcenter text-nowrap table-primary" id="fixTable">
        <thead class="bg-primary text-white">
        <tr>
{{--            <th class="text-white text-center">Thao tác</th>--}}
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày đặt hàng</th>
            <th class="text-white text-center">Ngày thanh toán</th>
            <th class="text-white text-center">Mã ĐH</th>
            <th class="text-white text-center">Tên KH</th>
            <th class="text-white text-center">SĐT</th>}
            <th class="text-white text-center">Số tiền</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">Phương thức thanh toán</th>
            <th class="text-white text-center">Người lên đơn</th>
        </tr>
        </thead>
        <tbody>
        @if (count($orders))
            @foreach($orders as $order)
                <tr>
{{--                    <td class="text-center">--}}
{{--                        @if (Auth::user()->role == \App\Constants\UserConstant::ADMIN)--}}
{{--                            <a title="Xóa đơn hàng" class="btn delete" href="javascript:void(0)" data-url="{{ route('order.destroy', $order->id) }}"><i class="fas fa-trash-alt"></i></a>--}}
{{--                        @endif--}}
{{--                    </td>--}}
                    <td class="text-center">{{ $rank++ }}</td>
                    <td class="text-center">{{ isset($order->order) ? @date("d-m-Y", strtotime($order->order->created_at)) : '' }}</td>
                    <td class="text-center">{{ isset($order->payment_date) ? date("d-m-Y", strtotime($order->payment_date)) : '' }}</td>
                    <td class="text-center"><a href="{{isset($order->order)?route('order.show',$order->order_id):'#'}}">{{isset($order->order) ? $order->order->code:' ' }}</a></td>
                    <td class="text-center">{{isset($order->order) && isset($order->order->customer) ? @$order->order->customer->full_name :''}}</td>
                    <td class="text-center">{{ isset($order->order) && isset($order->order->customer) ? @$order->order->customer->phone :''}}</td>
                    <td class="text-center">{{ @number_format($order->price) }}</td>
                    <td class="text-center">{{ isset($order->order) && isset($order->order->customer)&& isset($order->order->customer->telesale)? @$order->order->customer->telesale->full_name:'' }}</td>
                    <td class="text-center">{{ isset($order->order) ? $order->order->name_payment_type:' ' }}</td>
                    <td class="text-center">{{ isset($order->order) && isset($order->order->customer)&& isset($order->order->customer->marketing)? @$order->order->customer->marketing->full_name:'' }}</td>
                </tr>
            @endforeach
            <tr class="fixed2">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng trang</td>
                <td class="text-center bold">{{ @number_format($allTotalPage) }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
            <tr class="fixed">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">{{ @number_format($allTotal) }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>

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
            {{ 'Tổng số ' . $orders->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $orders->appends(['search' => request()->search ])->links() }}
    </div>
</div>
@include('order-details.order-detail-modal')
<!-- table-responsive -->
