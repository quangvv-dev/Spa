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

{{--<div class="h4 text-center">TOÀN HỆ THỐNG</div>--}}

<div class="h4 text-center">BIỂU ĐỒ</div>
<div class="row row-cards">
    <div class="col-md-6">
        <div id="barchart"style="overflow-x: scroll;overflow-y: hidden"></div>
    </div>
    <div class="col-md-6">
        <div id="chart_payment"style="overflow-x: scroll;overflow-y: hidden"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var heights = {{count($response)*50}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($response))
            ['Năm', 'Doanh số', {role: 'annotation'}],
                @foreach($response as $k =>$item)
            ['{{$k}}', {{$item->all_total}}, '{{number_format($item->all_total)}}'],
                @endforeach
                @else
            [       'Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'Thống kê doanh số toàn hệ thống (VNĐ)',
            height: heights,
            width: '100%',
            // titleFontSize:12,
            chartArea: {
                height: '100%',
                left: 100,
                top: 70,
            },
            colors: ['#62c9c3'],
            hAxis: {
                title: 'Doanh thu dich vu',
                minValue: 0,
                titleTextStyle: {
                    fontSize: 66 // or the number you want
                }
            },
            // vAxis: {
            //     title: 'Khoá hoc',
            //     titleTextStyle: {
            //         color: "#000",
            //         fontName: "sans-serif",
            //         fontSize: 11,
            //         bold: true,
            //         italic: false
            //     }
            // }
        };

        var chart = new google.visualization.BarChart(document.getElementById('barchart'));
        chart.draw(data, options);
    };
    // column chart
</script>
<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var heights = {{count($response)*50}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($response))
            ['Năm', 'Doanh thu',{role: 'annotation'}],
                @foreach($response as $k =>$item)
            ['{{$k}}', {{$item->payment}}, '{{number_format($item->payment)}}'],
                @endforeach
                @else
            [       'Năm', 0, '#fffff', '0%'],
            @endif
        ]);

        var options = {
            title: 'Thống kê thực thu toàn hệ thống (VNĐ)',
            height: heights,
            width: '100%',
            // titleFontSize:12,
            chartArea: {
                height: '100%',
                left: 100,
                top: 70,
            },
            colors: ['#62c9c3'],
            hAxis: {
                title: 'Doanh thu dich vu',
                minValue: 0,
                titleTextStyle: {
                    fontSize: 66 // or the number you want
                }
            },
            // vAxis: {
            //     title: 'CHI NHÁNH',
            //     titleTextStyle: {
            //         color: "#000",
            //         fontName: "sans-serif",
            //         fontSize: 11,
            //         bold: true,
            //         italic: false
            //     }
            // }
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_payment'));
        chart.draw(data, options);
    };
    // column chart
</script>
