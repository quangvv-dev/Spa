<style>
    .font-30 {
        font-size: 20px;
    }

    .h4.text-center {
        color: cornflowerblue;
        font-weight: 600;
        margin-top: 10px;
    }
</style>
@php
    $all_total = [];
    $payment = [];
    $gross_revenue = [];
    $orders = [];
    $customers = [];
    $revenue_month = [];
    $total_month = [];
    $users = [];
        foreach($response as $k =>$item){
        $all_total[]=(int)$item->all_total;
        $payment[]=(int)$item->payment;
        $orders[]=(int)$item->orders;
        $customers[]=(int)$item->customers;
        $gross_revenue[]=(int)$item->gross_revenue;

            foreach ((array)$item->users as $value1){
                if ($value1->phone >9 && $value1->payment_new>0){
                    if (array_key_exists($value1->phone, $users) ==true){
                            $users[$value1->phone] = [
                            'full_name'     =>$value1->full_name  ,
                            'customer_new'  =>(int) $value1->customer_new + $users[$value1->phone]['customer_new'],
                            'order_new'     =>(int)$value1->order_new + $users[$value1->phone]['order_new'],
                            'payment_new'   =>(int)$value1->payment_new + $users[$value1->phone]['payment_new'],
                            ];
                        }else{
                            $users[$value1->phone] = [
                            'full_name'     =>$value1->full_name,
                            'customer_new'  =>(int)$value1->customer_new,
                            'order_new'     =>(int)$value1->order_new,
                            'payment_new'   =>(int)$value1->payment_new,
                            ];
                        }
                }
            }
        }

@endphp

{{--<div class="h4 text-center">TOÀN HỆ THỐNG</div>--}}
<div class="h4 text-center">BIỂU ĐỒ</div>

<div class="row row-cards">
    <div class="col-md-12">
        <div id="user_revenue"></div>
    </div>
</div>

<div class="row row-cards">
    <div class="col-md-12">
        <div id="percent"></div>
    </div>
</div>

<div class="row row-cards">
    <div class="col-md-12">
        <div id="column" style="margin-left: 15px"></div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});

    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['Ngày', 'Doanh số', 'Doanh thu'],
                @foreach($revenue_month as $k =>$item)
            ['{{substr($k, -2)}}',{{$total_month[$k]}},{{$item}}],
            @endforeach
            // ['2020', 16, 22],
        ]);
        var options = {
            title: 'Doanh số & doanh thu theo từng ngày',
            width: '100%',
            height: 500,
            hAxis: {title: 'Các ngày trong (tuần || tháng)'},
            seriesType: 'bars',
            series: {1: {type: 'line'}},
            bar: {groupWidth: '75%'},
            isStacked: true,
        };


        var chart = new google.visualization.ColumnChart(document.getElementById('column'));
        chart.draw(data, options);
    }
</script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var height1 = {{count($users)*30}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($users))
            ['Năm', 'Doanh thu', {role: 'annotation'}],
                @foreach($users as $k =>$item1)
            ['{{$item1['full_name']}}', {{$item1['payment_new']}}, '{{number_format($item1['payment_new'])}}'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'Thực thu khách hàng theo SALE toàn hệ thống(VNĐ)',
            height: height1,
            width: '100%',
            titleFontSize: 13,
            chartArea: {
                height: '100%',
                left: 200,
                top: 70,
            },
            colors: ['#0f89d0']
        };

        var chart = new google.visualization.BarChart(document.getElementById('user_revenue'));
        chart.draw(data, options);
    };
    // column chart
</script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var height1 = {{count($users)*40}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($users))
            ['Năm', 'Tỷ lệ chốt (%)', {role: 'annotation'}],
                @foreach($users as $k =>$item2)
            ['{{$item2['full_name']}}', {{$item2['order_new']>0&&$item2['customer_new']>0?round($item2['order_new']/$item2['customer_new']*100):0}}, '{{$item2['order_new']>0&&$item2['customer_new']>0?round($item2['order_new']/$item2['customer_new']*100):0}}%'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'Tỷ lệ chốt đơn khách hàng mới từ SALE toàn hệ thống',
            height: height1,
            width: '100%',
            titleFontSize: 13,
            chartArea: {
                height: '100%',
                left: 200,
                top: 70,
            },
            colors: ['#0f89d0']
        };

        var chart = new google.visualization.BarChart(document.getElementById('percent'));
        chart.draw(data, options);
    };
    // column chart
</script>
