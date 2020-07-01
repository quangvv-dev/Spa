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
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số SĐT</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($data['customers'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng số đơn hàng</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span class="">{{@number_format($data['orders'])}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden bg-gradient-indigo text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($data['all_total'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card overflow-hidden">
            <div class="card-body text-center  bg-gradient-indigo text-white">
                <div class="h5">Tổng doanh thu</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($data['gross_revenue'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card  overflow-hidden">
            <div class="card-body text-center bg-gradient-indigo text-white">
                <div class="h5">Đã thu trong kỳ</div>
                <div class="h3 font-weight-bold mb-4 font-30 ">{{@number_format($data['payment'])}}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="h4 text-center">SẢN PHẨM</div>
<div class="row row-cards">
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Đơn hàng</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['orders'])}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['all_total'])}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-blue text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh thu</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['gross_revenue'])}}</span>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-blue text-white">
                <div class="h5">Còn nợ</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($products['the_rest'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="h4 text-center">DỊCH VỤ</div>
<div class="row row-cards">
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-teal text-white">
            <div class="card-body text-center">
                <div class="h5">Đơn</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['orders'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-teal text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['all_total'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card  overflow-hidden bg-gradient-teal text-white">
            <div class="card-body text-center">
                <div class="h5">Doanh thu</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['gross_revenue'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-yellow" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-teal text-white">
                <div class="h5">Còn nợ</div>
                <div class="h3 font-weight-bold mb-4 font-30"><span
                        class="">{{@number_format($services['the_rest'])}}</span></div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="h4 text-center">BIỂU ĐỒ</div>
<div class="row row-cards">
    <div id="piechart-1"></div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($statusRevenues as $k =>$statusRevenue)
            ['{{ $statusRevenue['name'] }}', {{ $statusRevenue['revenue'] }}],
            {{--['{{ $k }}', {{ (int)array_sum($statusRevenue) }}],--}}
            @endforeach
        ]);

        var options = {
            title: 'DOANH THU THEO NGUỒN'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-1'));

        chart.draw(data, options);
    }
</script>
{{--counter--}}
