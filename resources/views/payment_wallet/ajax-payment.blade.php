<div class="table-responsive tableFixHead" id="parent">
    <table class="table card-table table-vcenter text-nowrap table-primary" id="fixTable">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày đặt hàng</th>
            <th class="text-white text-center">Ngày thanh toán</th>
            <th class="text-white text-center">Tên KH</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Gói nạp</th>
            <th class="text-white text-center">Thanh toán</th>
            <th class="text-white text-center">Còn nợ</th>
            <th class="text-white text-center">Phương thức thanh toán</th>
            <th class="text-white text-center">Người lên đơn</th>
            <th class="text-white text-center">Chi nhánh</th>
        </tr>
        </thead>
        <tbody>
        @if (count($datas))
{{--            @php--}}
{{--            $theRest =0;--}}
{{--            @endphp--}}
            @foreach($datas as $key => $data)
{{--                @php--}}
{{--                    $theRest += $data->order_wallet->order_price - $data->price;--}}
{{--                @endphp--}}
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td class="text-center">{{isset($data->order_wallet) ? @date("d-m-Y", strtotime($data->order_wallet->created_at)):'' }}</td>
                    <td class="text-center">{{ isset($data->payment_date) ? date("d-m-Y", strtotime($data->payment_date)) : '' }}</td>
                    <td class="text-center"><a href="{{route('wallet.show',$data->order_wallet_id)}}">
                            {{isset($data->order_wallet) && isset($data->order_wallet->customer) ? @$data->order_wallet->customer->full_name :''}}
                        </a></td>
                    <td class="text-center">{{isset($data->order_wallet) && isset($data->order_wallet->customer) ? @$data->order_wallet->customer->phone :''}}</td>
                    <td class="text-center">{{isset($data->order_wallet) && isset($data->order_wallet->package) ? @$data->order_wallet->package->name :''}}
                    <td class="text-center">{{ @number_format($data->price) }}</td>
                    <td class="text-center">{{isset($data->order_wallet) ? ($data->order_wallet->order_price - $data->price)>0? @number_format($data->order_wallet->order_price - $data->price) :0:0}}
                    <td class="text-center">{{ @$data->name_payment_type }}</td>
                    <td class="text-center">{{isset($data->order_wallet) && isset($data->order_wallet->user) ? @$data->order_wallet->user->full_name :''}}</td>
                    <td class="text-center">{{@$data->branch->name}}</td>

                </tr>
            @endforeach
            <tr class="fixed2">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng trang</td>
                <td class="text-center bold">{{ @number_format($datas->sum('price')) }}</td>
                <td class="text-center"></td>
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
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">{{ @number_format($allTotal) }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>

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
