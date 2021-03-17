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
    <div class="col-md-6 col-xs-12">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Khách hàng mới</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($data['customers'])}}</span></div>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        SĐT: {{@number_format($data['customers'])}}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        Lịch hẹn: {{@number_format($schedules)}}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        Tương tác: {{@number_format($data['groupComment'])}}
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="col">--}}
    {{--<div class="card  overflow-hidden bg-gradient-indigo text-white">--}}
    {{--<div class="card-body text-center">--}}
    {{--<div class="h5">Tổng số lịch hẹn</div>--}}
    {{--<div class="h3 font-weight-bold mb-4 font-30"><span--}}
    {{--class="">{{@number_format($schedules)}}</span></div>--}}
    {{--<div class="progress progress-sm">--}}
    {{--<div class="progress-bar bg-gradient-orange" style="width: 100%"></div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="col-md-6 col-xs-12">
        <div class="card overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số đơn hàng</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($data['orders'] + $wallets['orders'])}}</span>
                </div>
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        Sản phẩm: {{@number_format($products['orders'])}}
                    </div>
                    <div class="col-md-3 col-xs-12">
                        Dịch vụ: {{@number_format($services['orders'])}}
                    </div>
                    <div class="col-md-3 col-xs-12">
                        Combo: {{@number_format($data['orders'] - $products['orders'] -$services['orders'])}}
                    </div>
                    <div class="col-md-3 col-xs-12">
                        Nạp ví: {{@number_format($wallets['orders'])}}
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards">
    <div class="col-md-4 col-xs-12">
        <div class="card  overflow-hidden bg-gradient-gray text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30" style="margin-bottom: 3.6rem !important;">
                    <span class="">{{@number_format($data['all_total'])}}</span>
                </div>
                <div class="row">
                    <div class="col-12 row">
                        <div class="title col-5">Sản phẩm:</div>
                        <div class="col-7">{{@number_format($products['all_total'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Dịch vụ:</div>
                        <div class="col-7">{{@number_format($services['all_total'])}}</div>
                    </div>

                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-gray text-white">
                <div class="h5">Thực thu</div>
                <div
                    class="h3 font-weight-bold mb-4 font-30 ">{{@number_format($data['payment'] + $wallets['revenue']-$wallets['used'])}}</div>
                <div class="row">
                    <div class="col-12 row">
                        <div class="title col-5">Doanh thu:</div>
                        <div class="col-7">{{@number_format($data['gross_revenue'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Thu nợ:</div>
                        <div class="col-7">{{@number_format($data['payment']-$data['gross_revenue'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Nạp ví:</div>
                        <div class="col-7">{{@number_format($wallets['revenue'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Còn nợ:</div>
                        <div class="col-7">{{@number_format($data['all_total']-$data['gross_revenue'])}}</div>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="card  overflow-hidden">
            <div class="card-body text-center bg-gradient-gray text-white">
                <div class="h5">Nguồn tiền từ đơn hàng</div>
                <div
                    class="h3 font-weight-bold mb-4 font-30" style="margin-bottom: 2.3rem !important;">{{@number_format($data['payment'])}}</div>
                <div class="row">
                    <div class="col-12 row">
                        <div class="title col-5">Tiền mặt:</div>
                        <div class="col-7">{{@number_format($list_payment['money'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Thẻ:</div>
                        <div class="col-7">{{@number_format($list_payment['card'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Tiêu từ ví:</div>
                        <div class="col-7">{{@number_format($wallets['used'])}}</div>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div class="h4 text-center">Ví tiền</div>--}}

<div class="row row-cards">
    {{--<div class="col">--}}
    {{--<div class="card  overflow-hidden bg-gradient-blue text-white">--}}
    {{--<div class="card-body text-center">--}}
    {{--<div class="h5">Tổng đơn nạp ví</div>--}}
    {{--<div class="h3 font-weight-bold mb-4 font-30"><span--}}
    {{--class="">{{@number_format($wallets['orders'])}}</span></div>--}}
    {{--<div class="progress progress-sm">--}}
    {{--<div class="progress-bar bg-gradient-orange" style="width: 100%"></div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col">--}}
    {{--<div class="card overflow-hidden">--}}
    {{--<div class="card-body text-center bg-gradient-blue text-white">--}}
    {{--<div class="h5">Tổng doanh thu từ gói nạp</div>--}}
    {{--<div class="h3 font-weight-bold mb-4 font-30"><span--}}
    {{--class="">{{@number_format($wallets['revenue'])}}</span></div>--}}
    {{--<div class="progress progress-sm">--}}
    {{--<div class="progress-bar bg-gradient-orange" style="width: 100%"></div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col">--}}
    {{--<div class="card  overflow-hidden">--}}
    {{--<div class="card-body text-center bg-gradient-blue text-white">--}}
    {{--<div class="h5">Tổng tiền khách tiêu từ ví</div>--}}
    {{--<div class="h3 font-weight-bold mb-4 font-30 ">{{@number_format($wallets['used'])}}</div>--}}
    {{--<div class="progress progress-sm">--}}
    {{--<div class="progress-bar bg-gradient-orange" style="width: 100%"></div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
</div>

<div class="d-none col-xs-none d-md-block">
    <div class="h4 text-center">BIỂU ĐỒ</div>

    <div class="row row-cards">
        <div class="col-md-6">
            <div id="piechart-1" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-2"></div>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-md-6">
            <div id="piechart-3" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-4" style="margin-left: 15px"></div>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-md-6">
            <div id="piechart-5" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-6" style="margin-left: 15px"></div>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-md-6">
            <div id="piechart-7" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-8" style="margin-left: 15px"></div>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-md-12">
            <div id="column" style="margin-left: 15px"></div>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-md-12">
            <div id="column2" style="margin-left: 15px"></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/loader.js')}}"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($statusRevenues as $k =>$statusRevenue)
            ['{{ $statusRevenue['name'] }}', {{ $statusRevenue['revenue'] }}],
            @endforeach
        ]);

        var options = {
            title: 'DOANH THU THEO NGUỒN',
            width: 500,
            height: 300,
            hAxis: {
                width: 200
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-1'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($data['category_service'] as $k =>$item)
            ['{{$item->name}}', {{$item->all_total}}],
            @endforeach
        ]);

        var options = {
            title: 'TOP 5 NHÓM DICH VỤ CÓ DOANH THU CAO NHẤT',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-2'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($data['category_product'] as $k =>$item)
                @if(!empty($item))
            ['{{$item->service->name}}', {{$item->total}}],
            @endif
            @endforeach
        ]);

        var options = {
            title: 'TOP 5 SẢN PHẨM BÁN CHẠY NHẤT',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-3'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Sản phẩm', {{$products['gross_revenue']}}],
            ['Dịch vụ', {{$services['gross_revenue']}}],
        ]);

        var options = {
            title: 'DOANH THU SẢN PHẨM & DỊCH VỤ',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-4'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @if(count($trademark))
                @foreach($trademark as $item)
            ['{{$item->name}}', {{$item->price}}],
            @endforeach
            @endif
        ]);

        var options = {
            title: 'DOANH SỐ 5 NHÀ CUNG CẤP BÁN CHẠY NHẤT',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-5'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @if(count($revenue_gender))
                @foreach($revenue_gender as $k => $item)
            ['{{$k==0?"NỮ":'NAM'}}', {{@array_sum($item)}}],
            @endforeach
            @endif
        ]);

        var options = {
            title: 'DOANH THU THEO GIỚI TÍNH',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-6'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @if(count($revenue_genitive))
                @foreach($revenue_genitive as $k => $item)
            ['{{$k}}', {{@array_sum($item)}}],
            @endforeach
            @endif
        ]);

        var options = {
            title: 'DOANH THU THEO NHÓM TÍNH CÁCH',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-8'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Khách hàng mới', {{$revenue['revenueNew']}}],
            ['Khách hàng cũ', {{$revenue['revenueOld']}}],
            ['Thu còn nợ', {{$revenue['revenueRest']}}],
        ]);

        var options = {
            title: 'DOANH THU THEO LOẠI KHÁCH HÀNG',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-7'));

        chart.draw(data, options);
    }
</script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});

    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['Ngày', 'Doanh số', 'Doanh thu'],
                @foreach($data['revenue_month'] as $k =>$item)
            ['{{substr($item->payment_date, -2)}}', {{$item->total}},{{$item->revenue}}],
            @endforeach
        ]);
        var options = {
            title: 'Doanh số & doanh thu theo từng ngày',
            width: '100%',
            height: 500,
            hAxis: {title: 'Các ngày trong (tuần || tháng)'},
            seriesType: 'bars',
            series: {1: {type: 'line'}},
            bar: {groupWidth: '75%'},
            isStacked: true,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('column'));
        chart.draw(data, options);
    }
</script>

<script>
    google.charts.load('current', {callback: drawBasic, packages: ['corechart']});

    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['Ngày', 'Doanh thu'],
                @foreach($revenue_year as $k =>$item)
            ['{{'Tháng '.$k}}', {{$item}}],
            @endforeach
        ]);
        var options = {
            title: 'Doanh thu trong năm hiện tại',
            width: '100%',
            height: 500,
            hAxis: {title: 'Các tháng trong năm'},
            seriesType: 'bars',
            // series: {1: {type: 'line'}},
            bar: {groupWidth: '75%'},
            isStacked: true,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('column2'));
        chart.draw(data, options);
    }
</script>
