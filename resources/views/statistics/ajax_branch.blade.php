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
    $all_total = 0;
    $payment = 0;
    $gross_revenue = 0;
    $orders = 0;
    $customers = 0;
    $schedules = 0;
    $revenue_month = [];
    $total_month = [];
    $total_year = [];
    $users = [];
    $wallets_orders = 0;
    $wallets_revenue = 0;
    $wallets_used = 0;
        foreach($response as $k =>$item){
        $all_total      += (int)$item->data->all_total;
        $schedules      += (int)$item->schedules;
        $payment        += (int)$item->data->payment;
        $orders         += (int)$item->data->orders;
        $customers      += (int)$item->data->customers;
        $gross_revenue  += (int)$item->data->gross_revenue;
        $wallets_orders  += (int)$item->wallets->orders;
        $wallets_revenue  += (int)$item->wallets->revenue;
        $wallets_used  += (int)$item->wallets->used;

            foreach ((array)$item->data->revenue_month as $key => $value){
                if (array_key_exists($key, $revenue_month) ==false){
                    $revenue_month[$key] = (int)$value->revenue;
                }else{
                    $revenue_month[$key] = (int)$revenue_month[$key] + (int)$value->revenue;
                }

                if (array_key_exists($key, $total_month) ==false){
                    $total_month[$key] = $value->total;
                }else{
                    $total_month[$key] = $total_month[$key] + $value->total;
                }
            }
            foreach ((array)$item->revenue_year as $key => $value){
                if (array_key_exists($key, $total_year) ==false){
                    $total_year[$key] = $value;
                }else{
                    $total_year[$key] = $total_year[$key] + $value;
                }
            }
        }

@endphp

<div class="h4 text-center">THÔNG SỐ CHI TIẾT</div>
<div class="row row-cards">
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số SĐT</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($customers)}}</span></div>
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
                <div class="h3 font-weight-bold mb-4 font-30"><span class="">{{@number_format($orders)}}</span>
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
                <div class="h5">Tổng số lịch hẹn</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($schedules)}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards">
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($all_total)}}</span></div>
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
                        class="">{{@number_format($gross_revenue)}}</span></div>
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
                <div class="h3 font-weight-bold mb-4 font-30 ">{{@number_format($payment)}}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="h4 text-center">Ví tiền</div>

<div class="row row-cards">
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng đơn nạp ví</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($wallets_orders)}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-blue text-white">
                <div class="h5">Tổng doanh thu từ gói nạp</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($wallets_revenue)}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden">
            <div class="card-body text-center bg-gradient-blue text-white">
                <div class="h5">Tổng tiền khách tiêu từ ví</div>
                <div class="h3 font-weight-bold mb-4 font-30 ">{{@number_format($wallets_used)}}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>


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

<div class="row row-cards">
    <div class="col-md-12">
        <div id="column2" style="margin-left: 15px"></div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var heights = {{count($response)*70}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($response))
            ['Năm', 'Doanh số', {role: 'annotation'}, 'Doanh thu', {role: 'annotation'}, 'Đã thu trong kỳ', {role: 'annotation'}],
                @foreach($response as $k =>$item1)
            ['{{$k}}',{{$item1->data->all_total}}, '{{number_format($item1->data->all_total)}}',{{$item1->data->gross_revenue}}, '{{number_format($item1->data->gross_revenue)}}',{{$item1->data->payment}} , '{{number_format($item1->data->payment)}}'],
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
            vAxis: {
                textStyle: {
                    bold: true,
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

{{--<script>--}}
    {{--google.charts.load('current', {callback: drawBasic, packages: ['corechart']});--}}

    {{--function drawBasic() {--}}
        {{--var data = google.visualization.arrayToDataTable([--}}
            {{--['Ngày', 'Doanh số', 'Doanh thu'],--}}
                {{--@foreach($revenue_month as $k =>$item)--}}
            {{--['{{substr($k, -2)}}',{{$total_month[$k]}},{{$item}}],--}}
            {{--@endforeach--}}
        {{--]);--}}
        {{--var options = {--}}
            {{--title: 'Doanh số & doanh thu theo từng ngày',--}}
            {{--width: '100%',--}}
            {{--height: 500,--}}
            {{--hAxis: {title: 'Các ngày trong (tuần || tháng)'},--}}
            {{--seriesType: 'bars',--}}
            {{--series: {1: {type: 'line'}},--}}
            {{--bar: {groupWidth: '75%'},--}}
            {{--isStacked: true,--}}
        {{--};--}}


        {{--var chart = new google.visualization.ColumnChart(document.getElementById('column'));--}}
        {{--chart.draw(data, options);--}}
    {{--}--}}
{{--</script>--}}

{{--<script>--}}
    {{--google.charts.load('current', {callback: drawBasic, packages: ['corechart']});--}}

    {{--function drawBasic() {--}}
        {{--var data = google.visualization.arrayToDataTable([--}}
            {{--['Tháng', 'Doanh thu', 'Tăng trưởng'],--}}
                {{--@foreach($total_year as $k =>$item)--}}
            {{--[{{$k}},{{$item}},{{$item}}],--}}
            {{--@endforeach--}}
        {{--]);--}}
        {{--var options = {--}}
            {{--title: 'Doanh thu theo các tháng trong năm',--}}
            {{--width: '100%',--}}
            {{--height: 500,--}}
            {{--hAxis: {title: 'Các tháng trong năm'},--}}
            {{--seriesType: 'bars',--}}
            {{--series: {1: {type: 'line'}},--}}
            {{--bar: {groupWidth: '75%'},--}}
            {{--isStacked: true,--}}
        {{--};--}}


        {{--var chart = new google.visualization.ColumnChart(document.getElementById('column2'));--}}
        {{--chart.draw(data, options);--}}
    {{--}--}}
{{--</script>--}}
