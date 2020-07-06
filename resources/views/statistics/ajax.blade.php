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

<div class="h4 text-center">TOÀN HỆ THỐNG</div>
<div class="row row-cards">
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số SĐT</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($data['customers'])}}</span></div>
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
                <div class="h3 font-weight-bold mb-4 font-30"><span class="">{{@number_format($data['orders'])}}</span>
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
                        class="">{{@number_format($data['all_total'])}}</span></div>
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
                        class="">{{@number_format($data['gross_revenue'])}}</span></div>
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
                <div class="h3 font-weight-bold mb-4 font-30 ">{{@number_format($data['payment'])}}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="h4 text-center">SẢN PHẨM</div>
<div class="row row-cards">
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Đơn hàng</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['orders'])}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['all_total'])}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh thu</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['gross_revenue'])}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-blue text-white">
                <div class="h5">Còn nợ</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['the_rest'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="h4 text-center">DỊCH VỤ</div>
<div class="row row-cards">
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-teal text-white">
            <div class="card-body text-center">
                <div class="h5">Đơn</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['orders'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-teal text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['all_total'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-teal text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh thu</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['gross_revenue'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-yellow" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-teal text-white">
                <div class="h5">Còn nợ</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['the_rest'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="h4 text-center">BIỂU ĐỒ</div>
<div class="row row-cards">
    <div class="col-md-6">
        <div id="piechart-1" style="margin-left: 15px"></div>
    </div>
    <div class="col-md-6">
        <div id="piechart-2"></div>
        {{--<div id="barchart"style="overflow-x: scroll;overflow-y: hidden;"></div>--}}
    </div>
</div>
<div class="row row-cards">
    <div class="col-md-6">
        <div id="piechart-3" style="margin-left: 15px"></div>
    </div>
</div>
<div class="row row-cards">
    <div class="col-md-12">
        <div id="column" style="margin-left: 15px"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($statusRevenues as $k =>$statusRevenue)
            ['{{ $statusRevenue['name'] }}', {{ $statusRevenue['revenue'] }}],
            {{--['{{ $k }}', {{ (int)array_sum($statusRevenue) }}],--}}
            @endforeach
        ]);

        var options = {
            title: 'DOANH THU THEO NGUỒN',
            width: 500,
            height: 300,
            hAxis: {
                width: 200
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-1'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($data['category_service'] as $k =>$item)
            ['{{$item->name}}', {{$item->all_total}}],
            @endforeach
        ]);

        var options = {
            title: 'TOP 5 NHÓM DICH VỤ CÓ DOANH THU CAO NHẤT',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-2'));

        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($data['category_product'] as $k =>$item)
            ['{{!empty($item->service)?$item->service->name:'Sản phẩm khác'}}', {{$item->total}}],
            @endforeach
        ]);

        var options = {
            title: 'TOP 5 SẢN PHẨM BÁN CHẠY NHẤT',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-3'));

        chart.draw(data, options);
    }
</script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});

    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['Ngày', 'Doanh số', 'Doanh thu'],
                @foreach($data['revenue_month'] as $k =>$item)
            ['{{substr($item->payment_date, -2)}}', {{$item->total}},{{$item->revenue}}],
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

{{--<script>--}}
{{--google.charts.load('current', {callback: drawBasic, packages: ['corechart']});--}}
{{--var heights = {{count($data['category_service'])*50}}--}}
{{--function drawBasic() {--}}
{{--var data = google.visualization.arrayToDataTable([--}}
{{--@if(count($data['category_service']))--}}
{{--['Năm', 'Doanh số', {role: 'style'}],--}}
{{--@foreach($data['category_service'] as $item)--}}
{{--['{{$item->name}}', {{$item->all_total}}, '{{generateRandomColor()}}'],--}}
{{--@endforeach--}}
{{--@else--}}
{{--['Năm', 0, '#fffff'],--}}
{{--@endif--}}
{{--]);--}}

{{--var options = {--}}
{{--title: 'Top 5 nhóm DV có doanh số cao nhất',--}}
{{--height: heights,--}}
{{--width: '100%',--}}
{{--// titleFontSize:12,--}}
{{--chartArea: {--}}
{{--height: '100%',--}}
{{--left: 200,--}}
{{--top: 70,--}}
{{--},--}}
{{--colors: ['#62c9c3'],--}}
{{--hAxis: {--}}
{{--title: 'Doanh thu dich vu',--}}
{{--minValue: 0,--}}
{{--titleTextStyle: {--}}
{{--fontSize: 66 // or the number you want--}}
{{--}--}}
{{--},--}}
{{--// vAxis: {--}}
{{--//     title: 'Khoá hoc',--}}
{{--//     titleTextStyle: {--}}
{{--//         color: "#000",--}}
{{--//         fontName: "sans-serif",--}}
{{--//         fontSize: 11,--}}
{{--//         bold: true,--}}
{{--//         italic: false--}}
{{--//     }--}}
{{--// }--}}
{{--};--}}

{{--var chart = new google.visualization.BarChart(document.getElementById('barchart'));--}}
{{--chart.draw(data, options);--}}
{{--};--}}
{{--// column chart--}}
{{--</script>--}}
{{--counter--}}
