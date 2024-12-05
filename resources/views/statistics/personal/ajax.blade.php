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
        <div class="card overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Nhân sự</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($statistics['all'])}}</span></div>

                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        Đang hoạt động: {{@number_format($statistics['active'])}}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        Nhân sự nghỉ việc (Khóa TK) : {{@number_format($statistics['all'] - $statistics['active'])}}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        Nhân sự tạm nghỉ: {{@number_format($statistics['pause'])}}
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-none col-xs-none d-md-block">
    <div class="h4 text-center">BIỂU ĐỒ</div>

    <div class="row row-cards">
        <div class="col-md-12">
            <div id="barchart" style="overflow-x: scroll;overflow-y: hidden;margin-left: 15px"></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/loader.js')}}"></script>
<script type="text/javascript">
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var heights = {{count($chart)*60}};
        function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['Lý do', 'Nhân viên nghỉ'],
            @if(count($chart))
                @foreach($chart as $k => $item)
            ['{{$item->name}}',{{100 - $k}}],
                @endforeach
                @else
            ['Năm', 0],
            @endif

        ]);

        var options = {
            title: 'Biểu đồ nhân viên nghỉ theo lý do',
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
                    fontSize:11,
                    width: 500,
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
