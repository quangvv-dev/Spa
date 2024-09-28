@extends('layout.app')
@section('content')
    <div class="container">
        <div class="side-app">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title linear-text fs-24">{{ $title }}</h3>
                        </div>
                        <div class="card-body">
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
                    ['data1', {{$detail->count}}],
                    ['data2', {{$total}}],
                ],
                type: 'pie', // default type of chart
                colors: {
                    data1:'#5797fc',
                    data2:'#f66d9b',
                },
                names: {
                    // name of each serie
                    'data1': 'Số khách của {{ $detail->marketing->full_name }}',
                    'data2': 'Tổng số lượng khách hàng',
                }
            },
            axis: {
            },
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
