<div class="row">
    <div class="col-md-6">
        <div id="chart-sracked" class="chartsh c3"
             style="max-height: 256px; position: relative;"></div>
    </div>
    <div class="col-md-6">
        <div id="chart-pie2" style="width: 500px; height: 300px;"></div>
    </div>
</div>
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">SĐT mới</th>
            <th class="text-white text-center">Số lần trao đổi</th>
            <th class="text-white text-center">Lịch hẹn</th>
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh thu</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center"><h2>{{ isset($statuses[0]) && $statuses[0]->customers? $statuses[0]->customers->count(): 0 }}</h2></td>
            <td class="text-center"><h2>{{ count($groupComments) }}</h2></td>
            <td class="text-center"><h2>{{ count($books) }}</h2></td>
            <td class="text-center"><h2>{{ count($orders) }}</h2></td>
            <td class="text-center"><h2>{{ number_format($orderTotal) }}</h2></td>
        </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-6">
        <div id="piechart-1"></div>
    </div>
    <div class="col-md-6">
        <div id="piechart-2"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div id="piechart-3"></div>
    </div>
    <div class="col-md-6">
        <div id="piechart-4"></div>
    </div>
</div>
@include('customers.script')