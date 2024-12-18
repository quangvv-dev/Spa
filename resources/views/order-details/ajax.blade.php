<div class="table-responsive tableFixHead" id="parent">
    <table class="table card-table table-vcenter text-nowrap table-primary" id="fixTable">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Thao tác</th>
            <th class="text-white">C.Nhánh</th>
            <th class="text-white text-center">Ngày đặt hàng</th>
            <th class="text-white text-center">Ng.Hết hạn</th>
            <th class="text-white text-center">Mã ĐH</th>
            <th class="text-white text-center">Mã KH</th>
            <th class="text-white text-center">Tên KH</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Dịch vụ</th>
            <th class="text-white text-center">Số lượng</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Đã thanh toán</th>
            <th class="text-white text-center">Còn lại</th>
            <th class="text-white text-center">khuyến mại(voucher)</th>
            <th class="text-white text-center">Phương thức thanh toán</th>
            <th class="text-white text-center">Người lên đơn</th>
        </tr>
        </thead>
        <tbody>
        @if (count($orders))
            @foreach($orders as $order)
                <tr>
                    <td class="text-center">
                        @if (Auth::user()->department_id == \App\Constants\UserConstant::ADMIN||Auth::user()->department_id == \App\Constants\DepartmentConstant::WAITER||Auth::user()->department_id == \App\Constants\DepartmentConstant::CSKH)
                            <a title="Xóa đơn hàng" class="btn delete" href="javascript:void(0)"
                               data-url="{{ route('order.destroy', $order->id) }}"><i class="fas fa-trash-alt"></i></a>
                        @endif
                    </td>
                    <td class="text-center">{{ @$order->branch->name }}</td>
                    <td class="text-center">{{ isset($order->created_at) ? date("d-m-Y", strtotime($order->created_at)) : '' }}</td>
                    <td class="text-center">{{ isset($order->hsd) ? date("d-m-Y", strtotime($order->hsd)) : '' }}</td>
                    <td class="text-center">{{ $order->code }}</td>
                    <td class="text-center">
                        <a class="order-detail-modal" data-toggle="modal" data-target="#oderDetailModal"
                           data-order-id="{{ $order->id }}" href="#">
                            <i class="fas fa-info-circle"></i>
                        </a>
                        {{ @$order->customer->account_code }}</td>
                    <td class="text-center">{{ @$order->customer->full_name }}</td>
                    <td class="text-center">{{ auth()->user()->permission('phone.open') ? @$order->customer->phone : @str_limit($order->customer->phone, 7, 'xxx') }}</td>
                    <td class="text-center">{!!@$order->service_text !!}</td>
                    <td class="text-center">{{ @$order->orderDetails->sum('quantity') }}</td>
                    <td class="text-center">{{ number_format($order->all_total) }}</td>
                    <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
                    <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
                    <td class="text-center">{{ number_format($order->the_rest) }}</td>
                    <td class="text-center">{{ number_format($order->discount)}}</td>
                    <td class="text-center">{{ $order->name_payment_type }}</td>
                    <td class="text-center">{{ @$order->owner->full_name }}</td>
                </tr>
            @endforeach
            <tr class="fixed2">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng trang</td>
                <td class="text-center bold"> {{ @number_format($allTotalPage) }} </td>
                <td class="text-center bold"> {{ @number_format($grossRevenuePage) }} </td>
                <td class="text-center bold"> {{ @number_format($grossRevenuePage) }}</td>
                <td class="text-center bold">{{ @number_format($theRestPage) }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
            <tr class="fixed">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold"> {{ @number_format($allTotal) }} </td>
                <td class="text-center bold"> {{ @number_format($grossRevenue) }} </td>
                <td class="text-center bold"> {{ @number_format($grossRevenue) }}</td>
                <td class="text-center bold">{{ @number_format($theRest) }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="17">Không tồn tại dữ liệu</td>
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
