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
@php
    $campaign = 0;
    $posts = 0;
    $all_customer = 0;
    $call = 0;
    $receive = 0;
        foreach($response as $k =>$item){
            $campaign       += (int)$item->campaign;
            $posts          += (int)$item->posts;
            $all_customer   += (int)$item->all_customer;
            $call           += (int)$item->call;
            $receive        += (int)$item->receive;
        }

@endphp

{{--<div class="h4 text-center">TOÀN HỆ THỐNG</div>--}}
<div class="h4 text-center">THÔNG SỐ CHI TIẾT</div>
<div class="row row-cards">
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Chiến dịch tạo mới</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format($campaign)}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng landing page</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format($posts)}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card overflow-hidden">
            <div class="card-body text-center  bg-gradient-indigo text-white">
                <div class="h5">Tổng số nhận được</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format($all_customer)}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số đã gọi</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{number_format($call)}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden">
            <div class="card-body text-center bg-gradient-indigo text-white">
                <div class="h5">Tổng khách đã đến</div>
                <div class="h3 font-weight-bold mb-4 font-30 ">{{number_format($receive)}}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="h4 text-center">BIỂU ĐỒ</div>
<div class="row row-cards">
    <div class="col-md-12">
        <div id="barchart" style="overflow-x: scroll;overflow-y: hidden"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});
    var heights = {{count($response)*70}}
    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
                @if(count($response))
                {{--{{dd(count($response))}}--}}
            ['Năm', 'Số nhận được', {role: 'annotation'},'SĐT đã gọi', {role: 'annotation'}, 'SĐT đã đến', {role: 'annotation'}],
                @foreach($response as $k =>$item1)
            ['{{$k}}',{{$item1->all_customer}}, '{{number_format($item1->all_customer)}}',{{$item1->call}}, '{{number_format($item1->call)}}',{{$item1->receive}} , '{{number_format($item1->receive)}}'],
                @endforeach
                @else
            ['Năm', 0, '#fffff', '0%'],
            @endif

        ]);

        var options = {
            title: 'THỐNG KÊ NGUỒN DATA THEO CHIẾN DỊCH',
            height: heights,
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

