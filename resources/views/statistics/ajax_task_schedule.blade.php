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
                if ($value1->all_schedules>0){
                    if (array_key_exists($value1->phone, $users) ==true){
                            $users[$value1->phone] = [
                            'full_name'         =>$value1->full_name  ,
                            'all_schedules'     =>(int) $value1->all_schedules + $users[$value1->phone]['all_schedules'],
                            'schedules_buy'     =>(int)$value1->schedules_buy + $users[$value1->phone]['schedules_buy'],
                            'schedules_notbuy'  =>(int)$value1->schedules_notbuy + $users[$value1->phone]['schedules_notbuy'],
                            'schedules_cancel'  =>(int)$value1->schedules_cancel + $users[$value1->phone]['schedules_cancel'],
                            'all_task'          =>(int)$value1->all_task + $users[$value1->phone]['all_task'],
                            'all_done'          =>(int)$value1->all_done + $users[$value1->phone]['all_done'],
                            'all_failed'        =>(int)$value1->all_failed + $users[$value1->phone]['all_failed'],
                            ];
                        }else{
                            $users[$value1->phone] = [
                            'full_name'         =>$value1->full_name,
                            'all_schedules'     =>(int)$value1->all_schedules,
                            'schedules_buy'     =>(int)$value1->schedules_buy,
                            'schedules_notbuy'  =>(int)$value1->schedules_notbuy,
                            'schedules_cancel'  =>(int)$value1->schedules_cancel,
                            'all_task'          =>(int)$value1->all_task,
                            'all_done'          =>(int)$value1->all_done,
                            'all_failed'        =>(int)$value1->all_failed,
                            ];
                        }
                }
            }
        }

        $users2 = $users;
        $schedule = array_column($users, 'all_schedules');
        array_multisort($schedule, SORT_DESC, $users);
        $task = array_column($users2, 'all_task');
        array_multisort($task, SORT_DESC, $users2);

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
    var height = {{count($users)*90}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($users))
            ['Năm', 'Tổng lịch hẹn', {role: 'annotation'}, 'Đến/Đã mua', {role: 'annotation'}, 'Đến/Chưa mua', {role: 'annotation'}, 'Hủy', {role: 'annotation'}],
                @foreach($users as $k =>$item1)
            ['{{$item1['full_name']}}',{{$item1['all_schedules']}}, '{{number_format($item1['all_schedules'])}}',{{$item1['schedules_buy']}}, '{{number_format($item1['schedules_buy'])}}',{{$item1['schedules_notbuy']}}, '{{number_format($item1['schedules_notbuy'])}}',{{$item1['schedules_cancel']}}, '{{number_format($item1['schedules_cancel'])}}'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'BĐ THỐNG KÊ LỊCH HẸN THEO SALES',
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
    var height1 = {{count($users2)*55}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($users2))
            ['Năm', 'Tổng công việc', {role: 'annotation'}, 'Hoàn thành', {role: 'annotation'}, 'Quá hạn', {role: 'annotation'}],
                @foreach($users2 as $k =>$item2)
                    @if($item2['all_task']>0)
                        ['{{$item2['full_name']}}',{{$item2['all_task']}}, '{{number_format($item2['all_task'])}}',{{$item2['all_done']}}, '{{number_format($item2['all_done'])}}',{{$item2['all_failed']}}, '{{number_format($item2['all_failed'])}}'],
                    @endif
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'BĐ THỐNG KÊ CÔNG VIỆC THEO SALE',
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
