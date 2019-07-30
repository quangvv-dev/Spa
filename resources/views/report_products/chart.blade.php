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
                        {{--<div id="fix-scroll" class="row padding mb10 header-dard border-bot shadow" style="width: 100%;">--}}
                        {{--<div class="col-md-4 no-padd">--}}
                        {{--</div>--}}
                        {{--<div class="col-md-8 no-padd">--}}
                        {{--<ul class="fr mg0 pt10 no-padd">--}}
                        {{--<li class="display pl5"><a data-time="TODAY" class="btn_choose_time">Hôm nay</a>--}}
                        {{--</li>--}}
                        {{--<li class="display pl5"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần--}}
                        {{--này</a></li>--}}
                        {{--<li class="display pl5"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần--}}
                        {{--trước</a></li>--}}
                        {{--<li class="display pl5"><a data-time="THIS_MONTH"--}}
                        {{--class="btn_choose_time border b-gray active padding0-5">Tháng--}}
                        {{--này</a></li>--}}
                        {{--<li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng--}}
                        {{--trước</a></li>--}}
                        {{--<li class="display pl5"><a data-time="THIS_YEAR" class="btn_choose_time">Năm nay</a>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="row">
                            <div class="col-md-6">
                                <div id="piechart_relation_account" class="row tc">
                                    </div>
                                    <div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>
                                </div>
                                <div id="piechart" style="width: 900px; height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Index Scripts -->
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                @foreach($services as $service)
                    ['{{ $service->name }}', {{ $service->orders->sum('total_price') }}],
                @endforeach
            ]);

            var options = {
                title: 'DOANH THU SẢN PHẨM'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
@endsection

