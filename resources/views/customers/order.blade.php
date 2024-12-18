<style>
    th.text-white.text-center {
        text-transform: unset;
    }
</style>

<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Trừ liệu trình</th>
            <th class="text-white text-center">C.Nhánh</th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Ng.hết hạn</th>
            <th class="text-white text-center">Tên DV</th>
            <th class="text-white text-center">Loại đơn</th>
            <th class="text-white text-center">Người lên đơn</th>
            <th class="text-white text-center">Hỗ trợ</th>
            <th class="text-white text-center">Buổi còn lại</th>
            <th class="text-white text-center">Số tiền DH</th>
            <th class="text-white text-center">Đã thanh toán</th>
            <th class="text-white text-center">Còn lại</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody style="background: white;">
        @if (count($orders))
            @foreach($orders as $order)
                <tr>
                    <td class="text-center">
                        <a class="btn tooltip-nav"
                           href="{{$order->role_type== 2 ?url('/orders/'.$order->id.'/edit'):url('/orders-service/'.$order->id.'/edit')}}"><i
                                class="fas fa-edit"></i>
                            <span class="tooltiptext">Chỉnh sửa đơn</span>
                        </a>
                        @if($order->count_day > 0 && Auth::user()->department_id != \App\Constants\DepartmentConstant::CSKH)
                            <a class="btn edit-order tooltip-nav" data-order-id="{{ $order->id }}"><i
                                    class="fas fa-check-square"></i>
                                <span class="tooltiptext">Trừ liệu trình</span>
                            </a>
                        @endif
                        <a title="Thanh toán" class="btn tooltip-nav" href="{{ url('order/' . $order->id . '/show') }}"><i
                                class="fas fa-file-invoice-dollar"></i>
                            <span class="tooltiptext">Thanh toán (IN)</span>
                        </a>
                    </td>
                    <td class="text-center">{{ @$order->branch->name }}</td>
                    <td class="text-center">{{ date('d/m/Y',strtotime($order->created_at)) }}</td>
                    <td class="text-center">{{ @$order->hsd}}</td>
                    <td class="text-center" style="min-width:300px;white-space: normal;">
                        <b><a id="edit-history-order" data-order-id="{{ $order->id }}" data-toggle="modal"
                              data-target="#largeModal">
                                {{str_limit(str_replace('<br>',',',$order->service_text),70)}}
                            </a></b>
                    </td>
                    <td class="text-center order-type" data-id="{{ $order->id }}">{{ $order->name_type }}</td>
                    <td class="text-center">{{ @$order->owner->full_name }}</td>
                    <td class="text-center" {{!empty($order->supportOrder->doctor) ||!empty($order->supportOrder->tuVanChinh)
                        ?'style=min-width:350px;white-space:normal':'' }}>
                        <span style="color: gray; font-size: 11px">
                        {{!empty($order->supportOrder->doctor)?'(BS: '.@$order->supportOrder->doctor->full_name.')':''}}
                        {{!empty($order->supportOrder->yTaChinh)?'(Y.Tá: '.@$order->supportOrder->yTaChinh->full_name.')':''}}
                        {{!empty($order->supportOrder->yTaPhu)?'(Y.Tá: '.@$order->supportOrder->yTaPhu->full_name.')':''}}
                        {{!empty($order->supportOrder->tuVanChinh)?'(TVV: '.@$order->supportOrder->tuVanChinh->full_name.')':''}}
                        {{!empty($order->supportOrder->tuVanPhu)?'(TVV: '.@$order->supportOrder->tuVanPhu->full_name.')':''}}
                        </span>
                    </td>
                    <td class="text-center">{{ $order->count_day }}</td>
                    <td class="text-center">{{ number_format($order->all_total) }}</td>
                    <td class="text-center">{{ number_format($order->gross_revenue) }}</td>
                    <td class="text-center">{{ number_format($order->the_rest) }}</td>
                    <td class="text-center">
                        <a title="Xóa đơn hàng" class="btn delete" href="javascript:void(0)"
                           data-url="{{ route('order.destroy', $order->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="12">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    @if (count($orders))
        <div class="pull-left">
            <div class="page-info">
                {{ 'Tổng số ' . $orders->total(). ' bản ghi ' . (request()->search ? 'found' : '') }}
            </div>
        </div>
        <div class="pull-right order-pagination">
            {{ $orders->appends(['search' => request()->search ])->links() }}
        </div>
    @endif
</div>
@include('customers.modal_order')
@include('customers.modal_update_history_order')
