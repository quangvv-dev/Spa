@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
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
                        <div class="row">
{{--                            <div class="col-md-6">--}}
                                <div id="piechart_relation_account" class="row tc">
                                    </div>
                                    <div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>
                                </div>
                        <div id="chart_div" style="height: 100%; width: 100%;"></div>
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{--    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>--}}
<script>
    google.charts.load('current', {
        callback: drawBasic,
        packages: ['corechart']
    });

    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['City', 'Doanh thu', ],
                @foreach($services as $service)
            ['{{ $service->name }}', {{ $service->orders->sum('total_price') }}],
            @endforeach
        ]);

        var options = {
            // backgroundColor: 'cyan',
            title: 'Population of Largest U.S. Cities',

            // total size of chart
            height: 1200,
            width: '100%',

            // adjust size of chart area
            chartArea: {
                // backgroundColor: 'magenta',

                // allow 70px for hAxis title and ticks
                height: '100%',

                // allow 200px for vAxis title and ticks
                // left: 200,

                // allow 50px for chart title
                top: 50,

                // allow 200px for legend on right
                // width: 500
            },

            colors: ['#62c9c3'],
            hAxis: {
                title: 'Doanh thu dich vu',
                minValue: 0
            },
            vAxis: {
                title: 'SP/DV'
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
    <!-- Index Scripts -->
@endsection

