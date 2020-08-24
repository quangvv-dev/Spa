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
            foreach ((array)$item->revenue_month as $key => $value){
                if (array_key_exists($key, $revenue_month) ==false){
                    $revenue_month[$key] = $value;
                }else{
                    $revenue_month[$key] = $revenue_month[$key] + $value;
                }
            }
            foreach ((array)$item->total_month as $key => $value){
                if (array_key_exists($key, $total_month) ==false){
                    $total_month[$key] = $value;
                }else{
                    $total_month[$key] = $total_month[$key] + $value;
                }
            }
        }

@endphp

{{--<div class="h4 text-center">TOÀN HỆ THỐNG</div>--}}
<div class="h4 text-center">THÔNG SỐ CHI TIẾT</div>
<div class="row row-cards">
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số SĐT</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format(array_sum($customers))}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số đơn hàng</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format(array_sum($orders))}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format(array_sum($all_total))}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card overflow-hidden">
            <div class="card-body text-center  bg-gradient-indigo text-white">
                <div class="h5">Tổng doanh thu</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format(array_sum($gross_revenue))}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden">
            <div class="card-body text-center bg-gradient-indigo text-white">
                <div class="h5">Đã thu trong kỳ</div>
                <div class="h3 font-weight-bold mb-4 font-30 ">{{number_format(array_sum($payment))}}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="h4 text-center">BIỂU ĐỒ</div>
<div class="row row-cards">
    <div class="col-md-12">
        <div id="barchart" style="overflow-x: scroll;overflow-y: hidden"></div>
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
    var heights = {{count($response)*70}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($response))
            {{--{{dd(count($response))}}--}}
            ['Năm', 'Doanh số', {role: 'annotation'}, 'Doanh thu', {role: 'annotation'}, 'Đã thu trong kỳ', {role: 'annotation'}],
            @foreach($response as $k =>$item1)
            ['{{$k}}',{{$item1->all_total}}, '{{number_format($item1->all_total)}}',{{$item1->gross_revenue}}, '{{number_format($item1->gross_revenue)}}',{{$item1->payment}} , '{{number_format($item1->payment)}}'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif


        ]);

        var options = {
            title: 'THỐNG KÊ NGUỒN THU TOÀN HỆ THỐNG (VNĐ)',
            height: heights,
            width: '100%',
            titleFontSize: 13,
            chartArea: {
                height: '100%',
                left: 150,
                top: 70,
            },
            // colors: ['#0f89d0'],
            vAxis: {
                textStyle: {
                    bold: true,
                    // fontSize: 15,
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

        var chart = new google.visualization.BarChart(document.getElementById('barchart'));
        chart.draw(data, options);
    };
    // column chart
</script>

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
