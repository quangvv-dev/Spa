<div class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" rowspan="2">STT</th>
            <th class="text-center" rowspan="2">CSKH</th>
            <th class="text-center" colspan="4">Tổng đài</th>
            <th class="text-center no-wrap" colspan="4">Công việc</th>
            <th class="text-center" colspan="3">Khách hàng mới</th>
            <th class="text-center" colspan="3">UPSALE</th>
            <th class="text-center" rowspan="2">Tổng thực thu</th>
        </tr>
        <tr class="number_index">
            <th class="text-center">Cuộc gọi</th>
            <th class="text-center">Trả lời</th>
            <th class="text-center">Gọi lỡ</th>
            <th class="text-center">Phút gọi</th>
            <th class="text-center">Công việc</th>
            <th class="text-center">Hoàn thành</th>
            <th class="text-center">Quá hạn</th>
            <th class="text-center">Tỷ lệ hoàn thành</th>
            <th class="text-center">SĐT tạo</th>
            <th class="text-center">Đơn hàng</th>
            <th class="text-center">Thực thu</th>
            <th class="text-center">SĐT nhận</th>
            <th class="text-center">Đơn hàng</th>
            <th class="text-center">Thực thu</th>
        </tr>
        </thead>
        @if(count($users))
            <tbody>
            @foreach($users as $i => $item)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$item['full_name']}}</td>
                    <td>{{number_format($item['call'])}}</td>
                    <td>{{number_format($item['answers'])}}</td>
                    <td>{{number_format($item['call'] - $item['answers'])}}</td>
                    <td>{{number_format(!empty($item['minute'] ? $item['minute']/60 : 0))}}</td>
                    <td>{{number_format($item['task_todo'])}}</td>
                    <td>{{number_format($item['task_done'])}}</td>
                    <td>{{number_format($item['task_failed'])}}</td>
                    <td>{{($item['task_todo']+$item['task_done']+$item['task_failed']) > 0 ?round($item['task_done']/($item['task_todo']+$item['task_done']+$item['task_failed']) * 100,2) : 0}}%</td>
                    <td>{{number_format($item['phoneNew'])}}</td>
                    <td>{{number_format($item['order_new'])}}</td>
                    <td>{{number_format($item['payment_new'])}}</td>
                    <td>{{number_format($item['phoneReceive'])}}</td>
                    <td>{{number_format($item['order_upsale'])}}</td>
                    <td>{{number_format($item['payment_upsale'])}}</td>
                    <td>{{number_format($item['all_payment'])}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td class="bold text-right" colspan="2">Tổng</td>
                <td class="bold">{{number_format($users->sum('call'))}}</td>
                <td class="bold">{{number_format($users->sum('answers'))}}</td>
                <td class="bold">{{number_format($users->sum('call') - $users->sum('answers'))}}</td>
                <td class="bold">{{number_format(!empty($users->sum('minute') ? $users->sum('minute')/60 : 0))}}</td>
                <td class="bold">{{number_format($users->sum('task_todo'))}}</td>
                <td class="bold">{{number_format($users->sum('task_done'))}}</td>
                <td class="bold">{{number_format($users->sum('task_failed'))}}</td>
                <td class="bold">{{($users->sum('task_todo')+$users->sum('task_done')+$users->sum('task_failed')) > 0?round($users->sum('task_done')/($users->sum('task_todo')+$users->sum('task_done')+$users->sum('task_failed')) * 100,2):0}}%</td>
                <td class="bold">{{number_format($users->sum('phoneNew'))}}</td>
                <td class="bold">{{number_format($users->sum('order_new'))}}</td>
                <td class="bold">{{number_format($users->sum('payment_new'))}}</td>
                <td class="bold">{{number_format($users->sum('phoneReceive'))}}</td>
                <td class="bold">{{number_format($users->sum('order_upsale'))}}</td>
                <td class="bold">{{number_format($users->sum('payment_upsale'))}}</td>
                <td class="bold">{{number_format($users->sum('all_payment'))}}</td>
            </tr>
            </tfoot>
        @endif
    </table>
</div>
