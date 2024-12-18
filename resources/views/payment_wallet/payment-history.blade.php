<h3
    class="bor-bot uppercase font12 mg0 bold padding5">Lịch sử thanh toán</h3></div>
<div class="col-md-12 no-padd">
    <table class="table table-bordered">
        <thead class="b-gray">
        <tr class="bor-bot">
            <th class="tl pl10 gray" width="30%" style="text-transform:uppercase;">Ngày</th>
            <th class="tc gray" width="30%" style="text-transform:uppercase;">Số tiền</th>
            <th class="tc gray" width="60%" style="text-transform:uppercase;">Ghi chú</th>
            <th class="tc gray" width="10%"></th>
        </tr>
        </thead>
        <tbody id="payment-history" style="font-size: 12px">
        @if(isset($payment) &&count($payment))
            @foreach($payment as $item)
                <tr>
                    <td class="fz-12">{{ date('d-m-Y', strtotime($item->payment_date)) }}</td>
                    <td class="fz-12"><span style="color: grey;font-size: 10px">({{$item->payment_type==0?'Tiền mặt':'C.Khoản'}})</span>  {{ number_format($item->price) }}</td>
                    <td class="fz-12">{{ $item->description }}</td>
                    @if(in_array(\Illuminate\Support\Facades\Auth::user()->department_id,[\App\Constants\DepartmentConstant::WAITER,\App\Constants\DepartmentConstant::ADMIN,\App\Constants\DepartmentConstant::KE_TOAN]))
                    <td class="fz-12">
                        <a title="Xóa" class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('payment-wallet/' . $item->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    @endif
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
