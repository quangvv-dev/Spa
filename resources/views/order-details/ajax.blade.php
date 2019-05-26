<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên khách hàng</th>
            <th class="text-white text-center">Dịch vụ</th>
            <th class="text-white text-center">Số lượng</th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if (count($orderDetails))
            @foreach($orderDetails as $orderDetail)
                <tr>
                    <th scope="row">{{ $orderDetail->id }}</th>
                    <td class="text-center">{{ $orderDetail->user->full_name }}</td>
                    <td class="text-center">{{ $orderDetail->service->name }}</td>
                    <td class="text-center">{{ $orderDetail->quantity }}</td>
                    <td class="text-center">{{ $orderDetail->created_at }}</td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('order-detail/' . $orderDetail->id . '/show') }}"><i
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
            {{ 'Tổng số ' . $orderDetails->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $orderDetails->appends(['search' => request()->search ])->links() }}
    </div>
</div>
<!-- table-responsive -->
