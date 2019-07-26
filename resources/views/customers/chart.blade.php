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
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div id="piechart_relation_account" class="row tc">
                                <ul class="ct-legend ct-legend-inside" style="margin: 0px auto;">
                                    @foreach($statuses as $status)
                                        <li class="ct-series-0 color-picker-cl-3" data-legend="{{ $status->id }}">
                                            <span class="color-picker-chart" style="background-color: {{$status->color}} !important;"></span>
                                            {{ $status->name }}
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="uppercase bold tc mb10" style="width: 100%">Số lượng theo mối quan hệ</div>
                                <div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>
                            </div>
                            <div id="chart-pie2" class="chartsh"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <!-- Index Scripts -->
    <script>
        /*chart-pie*/
        var chart = c3.generate({
            bindto: '#chart-pie2', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    @foreach($statuses as $status)
                            [{{ $status->id }}, {{ $status->customers->count() }}],
                    @endforeach
                    {{--['data1', {{$detail->count}}],--}}
                    {{--['data2', {{$total}}],--}}
                ],
                type: 'pie', // default type of chart
                colors: {
                    @foreach($statuses as $status)
                    {{$status->id}}: '{{$status->color}}',
                    @endforeach
                },
                names: {
                    // name of each serie
                    @foreach($statuses as $key => $status)
                        {{$status->id}}: '{{$status->name}}',
                    @endforeach
                    {{--'data1': 'Số khách của {{ $detail->marketing->full_name }}',--}}
                    {{--'data2': 'Tổng số lượng khách hàng',--}}
                }
            },
            axis: {},
            legend: {
                show: false, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    </script>
@endsection
