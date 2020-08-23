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
        foreach($response as $k =>$item){
            foreach ((array)$item as $value1){
                if ($value1->phone >9 && $value1->payment_new>0&& $value1->order_new>0){
                    if (array_key_exists($value1->phone, $users) ==true){
                            $users[$value1->phone] = [
                            'full_name'     =>$value1->full_name  ,
                            'customer_new'  =>(int) $value1->customer_new + $users[$value1->phone]['customer_new'],
                            'order_new'     =>(int)$value1->order_new + $users[$value1->phone]['order_new'],
                            'payment_new'   =>(int)$value1->payment_new + $users[$value1->phone]['payment_new'],
                            'comment'       =>(int)$value1->comment + $users[$value1->phone]['comment'],
                            ];
                        }else{
                            $users[$value1->phone] = [
                            'full_name'     =>$value1->full_name,
                            'customer_new'  =>(int)$value1->customer_new,
                            'order_new'     =>(int)$value1->order_new,
                            'payment_new'   =>(int)$value1->payment_new,
                            'comment'       =>(int)$value1->comment,
                            ];
                        }
                }
            }
        }
        $users2 = $users;
        $price = array_column($users, 'payment_new');
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
    google.charts.load('current', {callback: drawBasic, packages: ['corechart','bar']});
    var height1 = {{count($users)*30}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($users))
            ['Năm', 'Doanh thu', {role: 'annotation'}],
                @foreach($users as $k =>$item1)
            ['{{$item1['full_name']}}',{{$item1['payment_new']}} ,'{{number_format($item1['payment_new'])}}'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'Sale toàn hệ thống(VNĐ)',
            height: height1,
            width: '100%',
            titleFontSize: 13,
            chartArea: {
                height: '100%',
                left: 200,
                top: 70,
            },
            // colors: ['#0f89d0'],
            vAxis: {
                textStyle: {
                    // fontSize: 10,
                    bold: true,
                    color: '#848484'
                },
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('user_revenue'));
        chart.draw(data, options);
    };
    // column chart
</script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var height1 = {{count($users2)*40}}
    function drawBasic() {
        {{--{{dd($users)}}--}}
        var data = google.visualization.arrayToDataTable([
                @if(count($users2))
            ['Năm','Tương tác',{role: 'annotation'}, 'Tỷ lệ chốt (%)', {role: 'annotation'}],
                @foreach($users2 as $k =>$item2)
            ['{{$item2['full_name']}}',{{$item2['comment']}},'{{number_format($item2['comment'])}}', {{$item2['order_new']>0&&$item2['customer_new']>0?round($item2['order_new']/$item2['customer_new']*100):0}},
                '{{$item2['order_new']>0&&$item2['customer_new']>0?round($item2['order_new']/$item2['customer_new']*100):0}}%'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'Biểu đồ tương tác và tỷ lệ chốt của SALE toàn hệ thống.',
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
                    // fontSize: 12,
                    bold: true,
                    color: '#848484'
                },
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('percent'));
        chart.draw(data, options);
    };
    // column chart
</script>
