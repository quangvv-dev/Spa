<h3
        class="bor-bot uppercase font12 mg0 bold padding5">Lịch sử thanh toán</h3></div>
<div class="col-md-12 no-padd">
    <table class="table table-bordered">
        <thead class="b-gray">
        <tr class="bor-bot">
            <th class="tl pl10 gray" width="20%">Ngày</th>
            <th class="tc gray" width="30%">Số tiền</th>
            <th class="tc gray" width="60%">Ghi chú</th>
            <th class="tc gray" width="10%"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->paymentHistories as $item)
            <tr data-payment-id="628">
                <td class="tc pl10">{{ $item->payment_date }}</td>
                <td class="tc">{{ number_format($item->price) }}</td>
                <td>{{ $item->description }}</td>
                <td class="tc">
                    <a class="remove_payment" title="Xóa">
                        <i class="gf-icon-hover fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
