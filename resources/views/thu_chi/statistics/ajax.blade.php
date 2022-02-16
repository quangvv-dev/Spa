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

<div class="h4 text-center">THỰC THU</div>
<div class="row row-cards">
    <div class="col-md-4 col-xs-12">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-gray text-white">
                <div class="h5">Thực thu</div>
                <div class="h3 font-weight-bold mb-4 font-30">
                    {{@number_format($data['payment'] + $data['wallet_payment'] - $data['used'])}}</div>
                <div class="row">
                    {{--<div class="col-12 row">--}}
                    {{--<div class="title col-5">Doanh thu:</div>--}}
                    {{--<div class="col-7">{{@number_format($data['gross_revenue'])}}</div>--}}
                    {{--</div>--}}
                    <div class="col-12 row">
                        <div class="title col-5">Tiền mặt:</div>
                        <div class="col-7">{{number_format($list_payment['money'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Chuyển khoản:</div>
                        <div class="col-7">{{@number_format($list_payment['CK'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Thẻ:</div>
                        <div class="col-7">{{@number_format($list_payment['card'])}}</div>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="card  overflow-hidden bg-gradient-gray text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng chi</div>
                <div class="h3 font-weight-bold mb-4 font-30">
                    {{@number_format($list_pay['money'] + $list_pay['CK'] +$list_pay['card'])}}</div>
                <div class="row">
                    <div class="col-12 row">
                        <div class="title col-5">Tiền mặt:</div>
                        <div class="col-7">{{number_format($list_pay['money'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Chuyển khoản:</div>
                        <div class="col-7">{{@number_format($list_pay['CK'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Thẻ:</div>
                        <div class="col-7">{{@number_format($list_pay['card'])}}</div>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="card  overflow-hidden bg-gradient-gray text-white">
            <div class="card-body text-center">
                <div class="h5">Còn lại</div>
                <div class="h3 font-weight-bold mb-4 font-30">
                    {{@number_format(($data['payment'] + $data['wallet_payment'] - $data['used'])-($list_pay['money'] + $list_pay['CK'] +$list_pay['card']))}}</div>
                <div class="row">
                    <div class="col-12 row">
                        <div class="title col-5">Tiền mặt:</div>
                        <div class="col-7">{{number_format($list_payment['money'] - $list_pay['money'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Chuyển khoản:</div>
                        <div class="col-7">{{@number_format($list_payment['CK'] - $list_pay['CK'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Thẻ:</div>
                        <div class="col-7">{{@number_format($list_payment['card'] - $list_pay['card'])}}</div>
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
        <div class="col-md-6">
            <div id="piechart-1" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-2" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-4" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-5" style="margin-left: 15px"></div>
        </div>
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
            ['Danh mục', 'Số tiền'],
                @foreach($payAll as $k =>$item)
            ['{{ @$item->danhMucThuChi->name }}', {{ $item->sum_price }}],
            @endforeach
        ]);

        var options = {
            title: 'BĐ DUYỆT CHI THEO DANH MỤC',
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
            ['Danh mục', 'Số tiền'],
                @foreach($payStatus as $k =>$item)
            ['{{ @$item->status==1?'Đã duyệt':'Chưa duyệt' }}', {{ $item->sum_price }}],
            @endforeach
        ]);

        var options = {
            title: 'BĐ PHÂN BỔ DUYỆT CHI',
            width: 500,
            height: 300,
            hAxis: {
                width: 200
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-2'));

        chart.draw(data, options);
    }
</script>
