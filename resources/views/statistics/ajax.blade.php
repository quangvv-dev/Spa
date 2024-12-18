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
                    <div class="col-md-6 col-xs-12">
                        &nbsp
                    </div>
                    <div class="col-md-6 col-xs-12">
                        &nbsp
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        SĐT: {{@number_format($data['customers'])}}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        Lịch hẹn: {{@number_format($schedules['all_schedules'])}}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        SL khách đến: {{@number_format($schedules['become'])}}
                        {{--Tương tác: {{@number_format($data['groupComment'])}}--}}
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="card overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số đơn hàng</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($data['orders'] + $wallets['orders'])}}</span>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        Đơn buổi lẻ: {{@number_format($data['order_single'])}}
                    </div>
                    <div class="col-md-6 col-xs-12">
                        Đơn liệu trình: {{@number_format($data['order_multiple'])}}
                    </div>
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
                <div class="h3 font-weight-bold mb-4 font-30">
                    <span class="">{{@number_format($data['all_total'] + $wallets['revenue'])}}</span>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">Sản phẩm:</div>
                    <div class="col-7">{{@number_format($products['all_total'])}}</div>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">Dịch vụ:</div>
                    <div class="col-7">{{@number_format($services['all_total'])}}</div>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">S.phẩm và D.vụ:</div>
                    <div class="col-7">{{@number_format($services['combo_total'])}}</div>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">Nạp ví:</div>
                    <div class="col-7">{{@number_format($wallets['revenue'])}}</div>
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
                <div class="h3 font-weight-bold mb-4 font-30">
                    {{@number_format($data['payment'] + $wallets['payment'] - $wallets['used'])}}</div>
                <div class="row">
                    <div class="col-12 row">
                        <div class="title col-5">Doanh thu:</div>
                        <div
                            class="col-7">{{@number_format($data['payment'] - $wallets['used'] - $data['is_debt'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Thu nợ:</div>
                        <div
                            class="col-7">{{number_format($data['is_debt'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Nạp ví:</div>
                        <div class="col-7">{{@number_format($wallets['payment'])}}</div>
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
                    class="h3 font-weight-bold mb-4 font-30">{{@number_format($data['payment'])}}</div>
                {{--+ $wallets['payment']--}}
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
                        <div class="title col-5">Chuyển khoản:</div>
                        <div class="col-7">{{@number_format($list_payment['CK'])}}</div>
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
</div>

<div class="d-none col-xs-none d-md-block">
    <div class="h4 text-center">BIỂU ĐỒ</div>

    <div class="row row-cards">
        <div class="col-md-6">
            <div id="piechart-1" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-3" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-4" style="margin-left: 15px"></div>
        </div>
        @if(count($data['category_product']))
            <div class="col-md-6">
                <div id="piechart-5" style="margin-left: 15px"></div>
            </div>
        @endif
        @if(count($revenue_locale))
            <div class="col-md-6">
                <div id="piechart-9" style="margin-left: 15px"></div>
            </div>
        @endif
        <div class="col-md-6">
            <div id="piechart-6" style="margin-left: 15px"></div>
        </div>
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
            @forelse($revenue_locale as $k =>$item)
            ['{{$item->name}}', {{$item->total}}],
            @empty
            @endforelse
        ]);

        var options = {
            title: 'TOP 5 TỈNH CÓ DOANH THU CAO NHẤT',
            width: 500,
            height: 300,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-9'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @forelse($data['statusCustomer'] as $k =>$item)
            ['{{$item->name}}', {{$item->total}}],
            @empty
            @endforelse
        ]);

        var options = {
            title: 'KHÁCH HÀNG MỚI THEO TRẠNG THÁI',
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
            ['Sản phầm & Dịch vụ', {{$services['combo_gross']}}],
        ]);

        var options = {
            title: 'DOANH THU THEO LOẠI ĐƠN',
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
                @forelse($data['category_product'] as $k =>$item)
            ['{{$item->name}}', {{$item->total}}],
            @empty
            @endforelse
        ]);

        var options = {
            title: 'TOP 5 SẢN PHẨM BÁN CHẠY NHẤT',
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
            ['{{$item['name']}}', {{$item['all_total']}}],
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
            ['Khách hàng mới', {{$revenue['revenueNew']}}],
            ['Khách hàng cũ', {{$revenue['revenueOld']}}],
        ]);

        var options = {
            title: 'THỰC THU THEO LOẠI KHÁCH HÀNG',
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
            ['{{substr($item->payment_date, -2)}}', {{$item->order_month + $item->wallet_month}}, {{$item->payment_revenue + $item->payment_wallet_month}}],
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
            ['Ngày', 'Thực thu'],
                @foreach($revenue_year as $k =>$item)
            ['{{'Tháng '.$item->month}}', {{$item->all_total}}],
            @endforeach
        ]);
        var options = {
            title: 'Thực thu trong năm hiện tại',
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
