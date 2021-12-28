<div class="div" style="height: 50px">
    {{--<h3>Số dư ví :</h3>--}}
    <a style="color: #ffffff;margin-bottom: 8px;"
       class="right btn btn-primary btn-flat" data-toggle="modal"
       data-target="#wallet">Nạp tiền</a>
</div>

<div class="col">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Ngày nạp</th>
            <th class="text-white text-center">Gói nạp</th>
            <th class="text-white text-center">Số tiền nạp</th>
            <th class="text-white text-center">Đã thanh toán</th>
            <th class="text-white text-center">Số tiền được hưởng</th>
            <th class="text-white text-center">Nhân viên nạp</th>
            <th class="text-white text-center"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($wallet as $k => $item)
            <tr>
                <td class="text-center">{{$k+1}}</td>
                <td class="text-center">{{$item->created_at}}</td>
                <td class="text-center">{{@$item->package->name}}</td>
                <td class="text-center">{{@number_format($item->order_price)}}</td>
                <td class="text-center">{{@number_format($item->gross_revenue)}}</td>
                <td class="text-center">{{@number_format($item->price)}}</td>
                <td class="text-center">{{@$item->user->full_name}}</td>
                <td class="text-center">
                    <a title="Thanh toán" class="btn tooltip-nav" href="{{ url('wallet/' . $item->id) }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span class="tooltiptext">Thanh toán (IN)</span>
                    </a>
                    @if(\Illuminate\Support\Facades\Auth::user()->role==1)
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('wallet/' . $item->id) }}"><i class="fas fa-trash-alt"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $wallet->total() . ' lịch sử ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $wallet->appends(['search' => request()->search ])->links() }}
    </div>
</div>
@include('wallet.modal_cash')
