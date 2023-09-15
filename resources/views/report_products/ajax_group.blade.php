<div style="width: 100%; overflow-y: auto;height: 570px;font-size: 12px" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" colspan="1">STT</th>
            <th class="text-center" colspan="1"></th>
            <th class="text-center" colspan="11">KHÁCH HÀNG MỚI</th>
            <th class="text-center" colspan="2">KHÁCH HÀNG CŨ</th>
            <th class="text-center" colspan="1">TỔNG CHUNG</th>
        </tr>
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center"></th>
            <th class="text-center">{{$type==2?'Nhóm sản phẩm':'Nhóm dịch vụ'}}</th>
            <th class="text-center no-wrap">SĐT</th>
            <th class="text-center">Trao đổi</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">SL khách đến</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center">%<span class=""><br>chốt lịch</span></th>
            <th class="text-center">Tỷ lệ<span class=""><br>đến</span></th>
            <th class="text-center">%<span class=""><br>chốt đơn</span></th>
            <th class="text-center">% chốt đơn<span class=""><br>khách đến</span></th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Doanh số<span class=""><br>TB/đơn</span></th>
            <th class="text-center no-wrap">Đơn chốt</th>
            <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>
            <th class="text-center">Tổng Doanh số</th>
        </tr>
        <tr class="number_index">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(5)/(3)</th>
            <th class="text-center">(6)/(5)</th>
            <th class="text-center">(7)/(3)</th>
            <th class="text-center">(7)/(6)</th>
            <th class="text-center">(9)</th>
            <th class="text-center">(10)</th>
            <th class="text-center">(11)</th>
            <th class="text-center">(12)</th>
            <th class="text-center"></th>
        </tr>
        </thead>

        <tbody>
        @php
            $customer_new = 0;
            $comment_new = 0;
            $schedules_new = 0;
            $order_new = 0;
            $order_old = 0;
            $schedules_percent = 0;
            $order_percent = 0;
            $revenue_new = 0;
            $revenue_old = 0;
            $i = 0;
            $avg = 0;
            $payment_rest = 0;
        @endphp

        @if(count($users))
            @foreach($users as $item)
                @php $i++ ;
                $customer_new += $item->customer_new;
                $comment_new += $item->comment_new;
                $schedules_new += $item->schedules_new;
                $order_new += $item->order_new;
                $order_old += $item->order_old;
                $schedules_percent += $item->schedules_new >0 && $item->customer_new>0 ?round(($item->schedules_new/$item->customer_new)*100):0;
                $revenue_new += $item->revenue_new;
                $revenue_old += $item->revenue_old;

                @endphp
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{$item->name}}
                    <td class="text-center pdr10">{{$item->customer_new}}</td>
                    <td class="text-center pdr10">{{$item->comment_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new}}</td>
                    <td class="text-center pdr10">{{$item->become}}</td>
                    <td class="text-center pdr10">{{$item->order_new}}</td>
                    <td class="text-center pdr10">{{$item->schedules_new >0 && $item->customer_new>0 ?round(($item->schedules_new/$item->customer_new)*100,1):0}}
                        %
                    </td>
                    <td class="text-center pdr10">{{!empty($item->become)?round(($item->become/$item->schedules_new)*100,1):0}}%</td>

                    <td class="text-center pdr10">{{$item->customer_new >0 ?round(($item->order_new/$item->customer_new)*100):0}}%</td>
                    <td class="text-center pdr10">{{$item->become >0 ?round(($item->order_new/$item->become)*100):0}}%</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                    <td class="text-center pdr10">{{!empty($item->revenue_new)&&!empty($item->order_new)?number_format($item->revenue_new/$item->order_new):0}}</td>
                    <td class="text-center pdr10">{{number_format($item->order_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_old)}}</td>
                    <td class="text-center pdr10">{{number_format($item->revenue_total)}}</td>
                </tr>
            @endforeach
        @endif
        <tr class="fixed">
            <td class="text-center"></td>
            <td class="text-center bold">Tổng cộng</td>
            <td class="text-center bold">{{@number_format($customer_new)}}</td>
            <td class="text-center bold">{{@number_format($comment_new)}}</td>
            <td class="text-center bold">{{@number_format($schedules_new)}}</td>
            <td class="text-center bold">{{@number_format($users->sum('become'))}}</td>
            <td class="text-center bold">{{@number_format($order_new)}}</td>
            <td class="text-center bold">{{@number_format($schedules_percent/count($users))}}%</td>
            <td class="text-center bold">{{@number_format(!empty($schedules_new)?round(($users->sum('become')/$schedules_new)*100,1):0)}}%</td>
            <td class="text-center bold">{{@!empty($customer_new)?number_format(round(($order_new/$customer_new)*100)):0}}
                %
            </td>
            <td class="text-center bold">{{@number_format(round($order_new/$users->sum('become')*100,2))}}%</td>
            <td class="text-center bold">{{@number_format($revenue_new)}}</td>
            <td class="text-center bold">{{!empty($revenue_new)&&!empty($order_new)?number_format($revenue_new/$order_new):0}}</td>
            <td class="text-center bold">{{@number_format($order_old)}}</td>
            <td class="text-center bold">{{@number_format($revenue_old)}}</td>
            <td class="text-center bold">{{number_format($allTotal)}}</td>
        </tr>
        </tbody>
    </table>
</div>
