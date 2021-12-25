<div class="row row-cards">
    <div class="col-md-12">
        <div id="barchart" style="overflow-x: scroll;overflow-y: hidden;margin-left: 15px"></div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/loader.js')}}"></script>
{{--Barchart--}}
<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var heights = {{count($result)*70}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($result))
            ['Năm', 'Doanh số', {role: 'annotation'}, 'Doanh thu', {role: 'annotation'}, 'Đã thu trong kỳ', {role: 'annotation'}],
                @foreach($result as $k =>$item1)
            ['{{$item1['branch']}}',{{$item1['all_total']}}, '{{number_format($item1['all_total'])}}',{{$item1['gross_revenue']}}, '{{number_format($item1['gross_revenue'])}}',{{$item1['payment']}} , '{{number_format($item1['payment'])}}'],
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
{{--end barchart--}}

