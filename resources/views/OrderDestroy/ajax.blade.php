<div class="table-responsive tableFixHead" id="parent">
    <table class="table card-table table-vcenter text-nowrap table-primary" id="fixTable">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày đặt hàng</th>
            <th class="text-white text-center">Ngày thanh toán</th>
            <th class="text-white text-center">Tên KH</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Dịch vụ</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Người lên đơn</th>
            <th class="text-white text-center">Chi nhánh</th>
            <th class="text-white text-center"></th>
        </tr>
        </thead>
        <tbody>
        @if (count($datas))
            @foreach($datas as $key => $data)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td class="text-center">{{@date("d-m-Y", strtotime($data->created_at))}}</td>
                    <td class="text-center">{{@date("d-m-Y", strtotime($data->payment_date))}}</td>
                    <td class="text-center">{{isset($data->customer) ? @$data->customer->full_name :''}}</td>
                    <td class="text-center">{{isset($data->customer) ? @$data->customer->phone :''}}</td>
                    <td class="text-center">{{@$data->service_text_destroy}}
                    <td class="text-center">{{ @number_format($data->all_total) }}</td>
                    <td class="text-center">{{ @number_format($data->gross_revenue) }}</td>
                    <td class="text-center">{{isset($data->user) ? @$data->user->full_name :''}}</td>
                    <td class="text-center">{{@$data->branch->name}}</td>
                </tr>
            @endforeach
            <tr class="fixed2">
                <td class="text-center" colspan="5"></td>
                <td class="text-center bold">Tổng trang</td>
                <td class="text-center bold">{{ @number_format($datas->sum('all_total')) }}</td>
                <td class="text-center bold">{{ @number_format($datas->sum('gross_revenue')) }}</td>
                <td class="text-center" colspan="3"></td>
            </tr>
            <tr class="fixed">
                <td class="text-center" colspan="5"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">{{ @number_format($allTotal) }}</td>
                <td class="text-center bold">{{ @number_format($allGross) }}</td>
                <td class="text-center" colspan="3"></td>

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
            {{ 'Tổng số ' . $datas->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $datas->appends(['search' => request()->search ])->links() }}
    </div>
</div>
@include('order-details.order-detail-modal')
<!-- table-responsive -->
