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
    <div class="col-md-12">
        <div id="barchart" style="overflow-x: scroll;overflow-y: hidden"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    {{--var heights = {{count($response)*70}}--}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($response))
            ['Năm', 'Số nhận được', {role: 'annotation'},'SĐT đã gọi', {role: 'annotation'}, 'SĐT đã đến', {role: 'annotation'}],
                @foreach($response as $k =>$item1)
            ['{{$item1->name}}',{{$item1->all_customer}}, '{{number_format($item1->all_customer)}}',{{$item1->call}}, '{{number_format($item1->call)}}',{{$item1->receive}} , '{{number_format($item1->receive)}}'],
                @endforeach
            ['Năm', 0, '0', 0,'0',0,'0'],
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif

        ]);

        var options = {
            title: 'THỐNG KÊ NGUỒN DATA THEO CHIẾN DỊCH',
            // height: heights,
            width: '100%',
            titleFontSize: 13,
            chartArea: {
                height: '100%',
                left: 100,
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

