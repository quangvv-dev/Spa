<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" colspan="1" rowspan="2">STT</th>
            <th class="text-center" colspan="1" rowspan="2">CHI NHÁNH</th>
            <th class="text-center" colspan="11">KHÁCH HÀNG MỚI</th>
            <th class="text-center" colspan="5">KHÁCH HÀNG CŨ</th>
            <th class="text-center" colspan="6">TỔNG CHUNG</th>
        </tr>
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center no-wrap">SĐT</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Khách đến</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center">Tỷ lệ<span class=""><br>chốt lịch</span></th>
            <th class="text-center">Tỷ lệ đến</th>
            <th class="text-center">Tỷ lệ<span class=""><br>chốt đơn</span></th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Doanh thu</th>
            <th class="text-center no-wrap">Thu nợ</th>
            <th class="text-center no-wrap">Thực thu</th>
            <th class="text-center no-wrap">Đơn chốt</th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Doanh thu</th>
            <th class="text-center">Thu nợ</th>
            <th class="text-center">Thực thu</th>
            <th class="text-center">Doanh thu<span class=""><br>TB/đơn</span></th>
            <th class="text-center">Doanh<span class=""><br>số</span></th>
            <th class="text-center">Doanh<span class=""><br>thu</span></th>
            <th class="text-center">Thu nợ</th>
            <th class="text-center">Thực thu</th>
            <th class="text-center">Thực thu</th>
        </tr>
        <tr class="number_index">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(4)/(3)</th>
            <th class="text-center">(5)/(4)</th>
            <th class="text-center">(6)/(5)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(9)</th>
            <th class="text-center">(10)</th>
            <th class="text-center">(11)</th>
            <th class="text-center">(12)</th>
            <th class="text-center">(13)</th>
            <th class="text-center">(14)</th>
            <th class="text-center">(13)+(14)</th>
            <th class="text-center">(6)+(11)</th>
            <th class="text-center">(7)+(12)</th>
            <th class="text-center">(15)</th>
            <th class="text-center">(16)</th>
            <th class="text-center">(Từ đơn hàng)</th>
            <th class="text-center">(+ Nạp ví & - tiêu ví)</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td class="text-center"></td>
            <td class="text-center bold">Tổng cộng</td>
            <td class="text-center bold">{{@number_format($users->sum('customer_new'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('schedules_new'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('schedules_den'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('order_new'))}}</td>
            <td class="text-center bold">{{!empty($users->sum('schedules_new'))&& !empty($users->sum('customer_new'))?round($users->sum('schedules_new')/$users->sum('customer_new')*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($users->sum('schedules_den'))&& !empty($users->sum('schedules_new'))?round($users->sum('schedules_den')/$users->sum('schedules_new')*100,1):0}}%</td>
            <td class="text-center bold">{{!empty($users->sum('schedules_den'))&& !empty($users->sum('order_new'))?round($users->sum('order_new')/$users->sum('schedules_den')*100,1):0}}%</td>
            <td class="text-center bold">{{@number_format($users->sum('revenue_new'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('payment_new'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('detail_new') - $users->sum('payment_new'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('detail_new'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('order_old'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('revenue_old'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('payment_old'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('all_payment') - $users->sum('detail_new') - $users->sum('payment_old'))}}</td>
            <td class="text-center bold">{{@number_format($users->sum('all_payment') - $users->sum('detail_new'))}}</td>
            <td class="text-center bold">{{!empty($users->sum('payment_old'))&& !empty($users->sum('order_old'))?number_format($users->sum('payment_old')/$users->sum('order_old')):0}}</td>
            <td class="bold">{{number_format($users->sum('revenue_total'))}}</td>
            <td class="bold">{{number_format($users->sum('payment_new') + $users->sum('payment_old'))}}</td>
            <td class="bold">{{number_format(($users->sum('all_payment') - $users->sum('payment_new') - $users->sum('payment_old'))>0?$users->sum('all_payment') - $users->sum('payment_new') - $users->sum('payment_old'):0)}}</td>
            <td class="bold">{{number_format($users->sum('all_payment'))}}</td>
            <td class="bold">{{number_format($users->sum('all_payment') +  $users->sum('payment_wallet') - $users->sum('payment_used'))}}</td>
        </tr>

        @php
            $k=0;
        @endphp
        @if(count($users))
            @foreach($users as $item)
                @php $k++;
                @endphp
                <tr class="">
                    <td class="text-center pdr10">{{$k}}</td>
                    <td class="text-center pdr10 bold">{{$item->name}}
                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_den}}</td>
                    <td class="text-center pdr10">{{$item->order_new}}</td>
                    <td class="text-center pdr10">{{!empty($item->schedules_new) && !empty($item->customer_new) ?round(($item->schedules_new/$item->customer_new)*100,1):0}}
                        %
                    </td>
                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->schedules_new) ? round($item->schedules_den/$item->schedules_new*100,1):0}}%</td>
                    <td class="text-center pdr10">{{$item->order_new>0&&$item->schedules_den >0 ?round(($item->order_new/$item->schedules_den)*100,1):0}}
                        %
                    </td>
                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->detail_new - $item->payment_new)}}</td>
                    <td class="text-center pdr10">{{number_format($item->detail_new)}}</td>
                    <td class="text-center pdr10">{{$item->order_old}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->payment_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_payment - $item->detail_new -$item->payment_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_payment - $item->detail_new)}}</td>
                    <td class="text-center pdr10">{{!empty($item->payment_old) && !empty($item->order_old) ? number_format($item->payment_old/$item->order_old):0}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_total)}}</td>

                    <td class="text-center pdr10">{{number_format($item->payment_new + $item->payment_old)}}</td>
                    <td class="text-center pdr10">{{number_format(($item->all_payment - $item->payment_new - $item->payment_old)>0?$item->all_payment - $item->payment_new - $item->payment_old:0)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_payment)}}</td>
                    <td class="text-center pdr10">{{number_format($item->all_payment + $item->payment_wallet - $item->payment_used)}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
