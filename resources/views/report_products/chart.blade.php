@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <style>
        text {
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="side-app">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        {!! Form::textArea('note', null, array('class' => 'form-control autocomplete-textarea','rows'=>5)) !!}
                        <div class="row">
                            <div id="piechart_relation_account" class="row tc">
                            </div>
                            <div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>
                        </div>
                        <div id="chart_div" style="width:100%;height:100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.5/jquery.textcomplete.min.js"></script>
    <script>
        $('.autocomplete-textarea').textcomplete([{
            match: /(^|\s)@(\w*(?:\s*\w*))$/,

            search: function(query, callback) {
                let data = [{
                    name: "Quang"
                }, {
                    name: "Tèo"
                }, {
                    name: "Mít"
                }];
                callback(data);
            },

            template: function(hit) {
                // phan hien thi o dropdown
                let html = `
<a class="tag-item" href="">
<span class="label">${hit.name} <img width="40" src='http://spa.test/assets/images/brand/logo.png'/></span>
</a>`;
                return html;
            },

            replace: function(hit) {
                // phan hien thi khi
                return hit.name.trim();
            }
        }]);
    </script>
    {{----}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script>
        google.charts.load('current', {
            callback: drawBasic,
            packages: ['corechart']
        });
        var heights = {{count($services)*30}}
        function drawBasic() {
            var data = google.visualization.arrayToDataTable([
                ['City', 'Doanh thu'],
                    @foreach($services as $service)
                    @if($service->count >0)
                        ['{{ @$service->service->name }}', {{ $service->count }}],
                    @endif
                @endforeach
            ]);

            var options = {
                // backgroundColor: 'cyan',
                title: 'Biểu đồ doanh thu sản phẩm dịch vụ',

                // total size of chart
                height: heights,
                width: '100%',
                // titleFontSize:12,
                // adjust size of chart area
                chartArea: {

                    height: '100%',

                    // allow 200px for vAxis title and ticks
                    left: 300,

                    // allow 50px for chart title
                    top: 50,

                    // allow 200px for legend on right
                    // width: 500
                },

                colors: ['#62c9c3'],
                hAxis: {
                    title: 'Doanh thu dich vu',
                    minValue: 0,
                    titleTextStyle: {
                        fontSize: 66 // or the number you want
                    }
                },
                vAxis: {
                    title: 'SP/DV',
                    titleTextStyle: {
                        color: "#000",
                        fontName: "sans-serif",
                        fontSize: 11,
                        bold: true,
                        italic: false
                    }
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    <!-- Index Scripts -->
@endsection

