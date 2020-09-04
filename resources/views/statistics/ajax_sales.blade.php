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
    $users = [];
        foreach($response as $k =>$item){;
            foreach ((array)$item as $value1){
                if ($value1->all_payment>0){
                    if (array_key_exists($value1->phone, $users) ==true){
                            $users[$value1->phone] = [
                            'full_name'     =>$value1->full_name  ,
                            'customer_new'  =>(int) $value1->customer_new + $users[$value1->phone]['customer_new'],
                            'order_new'     =>(int)$value1->order_new + $users[$value1->phone]['order_new'],
                            'payment_new'   =>(int)$value1->payment_new + $users[$value1->phone]['payment_new'],
                            'comment'       =>(int)$value1->comment + $users[$value1->phone]['comment'],
                            'all_total'     =>(int)$value1->all_total + $users[$value1->phone]['all_total'],
                            'all_payment'   =>(int)$value1->all_payment + $users[$value1->phone]['all_payment'],
                            ];
                        }else{
                            $users[$value1->phone] = [
                            'full_name'     =>$value1->full_name,
                            'customer_new'  =>(int)$value1->customer_new,
                            'order_new'     =>(int)$value1->order_new,
                            'payment_new'   =>(int)$value1->payment_new,
                            'comment'       =>(int)$value1->comment,
                            'all_total'     =>(int)$value1->all_total,
                            'all_payment'   =>(int)$value1->all_payment,
                            ];
                        }
                }
            }
        }
        $users2 = $users;
        $price = array_column($users, 'all_payment');
        array_multisort($price, SORT_DESC, $users);

        $comment = array_column($users2, 'comment');
        array_multisort($comment, SORT_DESC, $users2);

@endphp

<div class="h4 text-center">BIỂU ĐỒ</div>

<div class="row row-cards">
    <div class="col-md-12">
        <div id="user_revenue"></div>
    </div>
    <div class="col-md-12">
        <div id="percent"></div>
    </div>
</div>

<div class="row row-cards">

</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart', 'bar']});
    var height = {{count($users)*70}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($users))
            ['Năm', 'Doanh số', {role: 'annotation'}, 'Doanh thu', {role: 'annotation'}, 'Đã thu trong kỳ', {role: 'annotation'}],
                @foreach($users as $k =>$item1)
            ['{{$item1['full_name']}}',{{$item1['all_total']}}, '{{number_format($item1['all_total'])}}',{{$item1['payment_new']}}, '{{number_format($item1['payment_new'])}}',{{$item1['all_payment']}}, '{{number_format($item1['all_payment'])}}'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'BĐ DOANH THU THEO SALE TOÀN HỆ THỐNG (VNĐ)',
            height: height,
            width: '900px',
            titleFontSize: 13,
            chartArea: {
                height: '100%',
                left: 200,
                top: 70,
            },
            // colors: ['#0f89d0'],
            vAxis: {
                textStyle: {
                    bold: true,
                    fontSize: 15,
                },
            },
            annotations: {
                highContrast: false,
                textStyle: {
                    color: '#000000',
                    fontSize: 11,
                    bold: true
                }
            },
        };

        var chart = new google.visualization.BarChart(document.getElementById('user_revenue'));
        chart.draw(data, options);
    };
    // column chart
</script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var height1 = {{count($users2)*60}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($users2))
            ['Năm', 'SĐT nhận', {role: 'annotation'},'Tương tác', {role: 'annotation'}, 'Tỷ lệ chốt (%)', {role: 'annotation'}],
                @foreach($users2 as $k =>$item2)
            ['{{$item2['full_name']}}',{{$item2['customer_new']}}, '{{number_format($item2['customer_new'])}}',{{$item2['comment']}}, '{{number_format($item2['comment'])}}', {{$item2['order_new']>0&&$item2['customer_new']>0?round($item2['order_new']/$item2['customer_new']*100):0}},
                '{{$item2['order_new']>0&&$item2['customer_new']>0?round($item2['order_new']/$item2['customer_new']*100):0}}%'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'BĐ TƯƠNG TÁC & TỶ LỆ CHỐT THEO SALE',
            height: height1,
            width: '100%',
            titleFontSize: 13,
            chartArea: {
                height: '100%',
                left: 200,
                top: 70,
            },
            // colors: ['#0f89d0'],
            hAxis: {
                title: 'Doanh thu dich vu',
                minValue: 0,
                titleTextStyle: {
                    fontSize: 66 // or the number you want
                }
            },
            vAxis: {
                textStyle: {
                    bold: true,
                    fontSize: 15,
                },
            },
            annotations: {
                highContrast: false,
                textStyle: {
                    color: '#000000',
                    fontSize: 11,
                    bold: true
                }
            },
        };

        var chart = new google.visualization.BarChart(document.getElementById('percent'));
        chart.draw(data, options);
    };
    // column chart
</script>
