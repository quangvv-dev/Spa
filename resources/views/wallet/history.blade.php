<div class="div" style="height: 50px">
    {{--<h3>Số dư ví :</h3>--}}
    <a style="color: #ffffff;margin-bottom: 8px;"
       class="right btn btn-primary btn-flat" data-toggle="modal"
       data-target="#wallet"><i class="fa fa-plus-circle"></i>Nạp tiền</a>
</div>

<div class="col">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Gói nạp</th>
            <th class="text-white text-center">Số tiền nạp</th>
            <th class="text-white text-center">Nhân viên nạp</th>
        </tr>
        </thead>
        <tbody>
        @foreach($wallet as $k => $item)
            <tr>
                <td class="text-center">{{$k+1}}</td>
                <td class="text-center">{{@$item->package->name}}</td>
                <td class="text-center">{{@number_format($item->price)}}</td>
                <td class="text-center">{{@$item->user->full_name}}</td>
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
