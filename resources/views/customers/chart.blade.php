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
                                <div class="uppercase bold tc mb10">Tăng trưởng số lượng khách hàng</div>
                                <div id="chart-sracked" class="chartsh c3"
                                     style="max-height: 256px; position: relative;"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="piechart_relation_account" class="row tc">
                                    <ul class="ct-legend ct-legend-inside" style="margin: 0px auto;">
                                        @foreach($statuses as $status)
                                            <li class="ct-series-0 color-picker-cl-3" data-legend="{{ $status->id }}">
                                                <span class="color-picker-chart"
                                                      style="background-color: {{$status->color}} !important;"></span>
                                                {{ $status->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="uppercase bold tc mb10" style="width: 100%">Số lượng theo mối quan hệ
                                    </div>
                                    <div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>
                                </div>
                                <div id="chart-pie2" class="chartsh"></div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-white text-center">Khách hàng mới</th>
                                    <th class="text-white text-center">Đơn hàng</th>
                                    <th class="text-white text-center">Doanh thu</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center"><h2>{{ @$statuses[0]->customers->count() }}</h2></td>
                                    <td class="text-center"><h2>{{ count($orders) }}</h2></td>
                                    <td class="text-center"><h2>{{ number_format($orderTotal) }}</h2></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            {{--<div class="col-md-6">--}}
                                {{--<div id="piechart_relation_account" class="row tc">--}}
                                {{--</div>--}}
                                {{--<div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>--}}
                            {{--</div>--}}
                            <div class="col-md-6">
                                <div id="piechart"></div>
                            </div>
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
                    @foreach($customerBases as $customerBase)
                ['{{ $customerBase->name }}', {{ $customerBase->customers->count() }}],
                @endforeach
            ]);

            var options = {
                title: 'SỐ LƯỢNG THEO NGUỒN'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
    <!-- Index Scripts -->
    <script>
        /*chart-area-spline-sracked*/
        var chart = c3.generate({
            bindto: '#chart-sracked', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1',
                        @foreach($customer as $item)
                        {{ $item->totalCustomer }},
                        @endforeach
                    ],
                ],
                labels: true,
                type: 'area-spline', // default type of chart
                groups: [
                    ['data1', 'data2']
                ],
                colors: {
                    data1: '#17a2b8'
                },
                names: {
                    // name of each serie
                    'data1': 'Tổng số khách hàng'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: [
                        @foreach($customer as $item)
                            '{{ $item->monthNum }}',
                        @endforeach
                    ]
                },
            },
            legend: {
                show: false, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });

        /*chart-pie*/
        var chart = c3.generate({
            bindto: '#chart-pie2', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                        @foreach($statuses as $status)
                    [{{ $status->id }}, {{ $status->customers->count() }}],
                    @endforeach
                ],
                type: 'pie', // default type of chart
                colors: {
        @foreach($statuses as $status)
        {{$status->id}}:
        '{{$status->color}}',
        @endforeach
        },
        names: {
            // name of each serie
            @foreach($statuses as $key => $status)
            {{$status->id}}:
            '{{$status->name}}',
            @endforeach
        }
        },
        axis: {
        }
        ,
        legend: {
            show: false, //hide legend
        }
        ,
        padding: {
            bottom: 0,
                top
        :
            0
        }
        ,
        })
        ;
    </script>
@endsection
