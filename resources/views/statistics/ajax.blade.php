<div class="mt-16 d-flex justify-content-between gap-16">
    <div style="height: 178px;width: 50%;;background: url('{{asset('layout/images/BG_tong_dai.png')}}') no-repeat; background-size: 100% 178px;">
        <div class="d-flex justify-content-center align-items-center" style="height: calc(100% - 77px);">
            <div class="text-center">
                <div class="fs-18 linear-text">Khách hàng mới</div>
                <div class="linear-text fs-32 bold number-gradient">{{@number_format($data['customers'])}}</div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center"
             style="height: 77px;background: url('{{asset('layout/images/test.png')}}') no-repeat; background-size: 100% 76px;background-size: 99.8% 76px;background-position-x: 1px;">
            <div class="d-flex justify-content-between p-5-c" style="width: 815px;height: 19px;margin-top: 15px">
                <div class="d-flex gap-16">
                    <span class="color-dark fs-16">Số điện thoại</span>
                    <span class="fs-18">{{@number_format($data['customers'])}}</span>
                </div>
                <div class="" style="border: 1px solid #005A7F;"></div>
                <div class="d-flex gap-16">
                    <span class="color-dark fs-16">Lịch hẹn</span>
                    <span class="fs-18">{{@number_format($schedules['all_schedules'])}}</span>
                </div>
                <div class="" style="border: 1px solid #005A7F;"></div>
                <div class="d-flex gap-16">
                    <span class="color-dark fs-16">SL khách đến</span>
                    <span class="fs-18">{{@number_format($schedules['become'])}}</span>
                </div>
            </div>
        </div>
    </div>

    <div
        style="height: 178px;width: 50%;background: url('{{asset('layout/images/BG_tong_dai.png')}}') no-repeat; background-size: 100% 178px;">
        <div class="d-flex justify-content-center align-items-center" style="height: calc(100% - 77px);">
            <div class="text-center">
                <div class="fs-18 linear-text">Tổng số đơn hàng</div>
                <div class="linear-text fs-32 bold number-gradient">{{@number_format($data['orders'] + $wallets['orders'])}}</div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center"
             style="height: 77px;background: url('{{asset('layout/images/test.png')}}') no-repeat; background-size: 100% 76px;background-size: 99.8% 76px;background-position-x: 1px;flex-direction: column;">
            <div class="d-flex justify-content-around" style="width: 815px;height: 19px;">
                <div class="d-flex gap-16 justify-content-center" style="width: 50%;">
                    <span class="color-dark fs-16">Đơn buổi lẻ</span>
                    <span class="fs-18">{{@number_format($data['order_single'])}}</span>
                </div>
                <div class="" style="border: 1px solid #005A7F;"></div>
                <div class="d-flex gap-16 justify-content-center" style="width: 50%;">
                    <span class="color-dark fs-16">Đơn liệu trình</span>
                    <span class="fs-18">{{@number_format($data['order_multiple'])}}</span>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-8" style="width: 815px;height: 19px;">
                <div class="d-flex justify-content-around" style="width: 50%;">
                    <div class="d-flex gap-16">
                        <span class="color-dark fs-16">Sản phẩm</span>
                        <span class="fs-18">{{@number_format($products['orders'])}}</span>
                    </div>
                    <div class="" style="border: 1px solid #005A7F;"></div>
                    <div class="d-flex gap-16">
                        <span class="color-dark fs-16">Dịch vụ</span>
                        <span class="fs-18">{{@number_format($services['orders'])}}</span>
                    </div>
                </div>
                <div class="" style="border: 1px solid #005A7F;"></div>

                <div class="d-flex justify-content-around" style="width: 50%;">
                    <div class="d-flex gap-16">
                        <span class="color-dark fs-16">Combo</span>
                        <span
                            class="fs-18">{{@number_format($data['orders'] - $products['orders'] -$services['orders'])}}</span>
                    </div>
                    <div class="" style="border: 1px solid #005A7F;"></div>
                    <div class="d-flex gap-16">
                        <span class="color-dark fs-16">Nạp ví</span>
                        <span class="fs-18">{{@number_format($wallets['orders'])}}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="mt-24 d-flex justify-content-between gap-16">
    <div class="thong-ke__item">
        <div class="top d-flex justify-content-center align-items-center mt-16">
            <div class="text-center">
                <div class="linear-text" style="font-size: 17px;">Tổng doanh số</div>
                <div class="number bold">{{@number_format($data['all_total'] + $wallets['revenue'])}}</div>
            </div>
{{--            <div class="color-red" style="color: #FF0000;">--}}
{{--                <img src="images/TrendDown.png" alt=""> 12%--}}
{{--            </div>--}}
        </div>
        <div class="p-16">
            <div class="d-flex justify-content-between">
                <span class="fs-16">Sản phẩm</span>
                <div class="fs-16">{{@number_format($products['all_total'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Dịch vụ</span>
                <div class="fs-16">{{@number_format($services['all_total'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Sản phẩm & dịch vụ</span>
                <div class="fs-16">{{@number_format($services['combo_total'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Nạp ví</span>
                <div class="fs-16">{{@number_format($wallets['revenue'])}}</div>
            </div>
        </div>
    </div>
    <div class="thong-ke__item">
        <div class="top d-flex justify-content-center align-items-center mt-16">
            <div class="text-center">
                <div class="linear-text" style="font-size: 17px;">Thực thu</div>
                <div class="number bold">{{@number_format($data['payment'] + $wallets['payment'] - $wallets['used'])}}</div>
            </div>
{{--            <div class="color-red" style="color: #FF0000;">--}}
{{--                <img src="images/TrendDown.png" alt=""> 12%--}}
{{--            </div>--}}
        </div>
        <div class="p-16">
            <div class="d-flex justify-content-between">
                <span class="fs-16">Doanh thu</span>
                <div class="fs-16">{{@number_format($data['payment'] - $wallets['used'] - $data['is_debt'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Thu nợ</span>
                <div class="fs-16">{{number_format($data['is_debt'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Nạp ví</span>
                <div class="fs-16">{{@number_format($wallets['payment'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <div class="fs-16">Còn nợ</div>
                <div class="fs-16">{{@number_format($data['all_total']-$data['gross_revenue'])}}</div>
            </div>
        </div>
    </div>
    <div class="thong-ke__item">
        <div class="top d-flex justify-content-center align-items-center mt-16">
            <div class="text-center">
                <div class="linear-text" style="font-size: 17px;">Nguồn tiền từ đơn hàng</div>
                <div class="number bold">{{@number_format($data['payment'])}}</div>
            </div>
{{--            <div class="color-red" style="color: #FF0000;">--}}
{{--                <img src="images/TrendDown.png" alt=""> 12%--}}
{{--            </div>--}}
        </div>
        <div class="p-16">
            <div class="d-flex justify-content-between">
                <span class="fs-16">Tiền mặt</span>
                <div class="fs-16">{{@number_format($list_payment['money'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Chuyển khoản</span>
                <div class="fs-16">{{@number_format($list_payment['CK'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Thẻ</span>
                <div class="fs-16">{{@number_format($list_payment['card'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Tiêu từ ví</span>
                <div class="fs-16">{{@number_format($wallets['used'])}}</div>
            </div>
        </div>
    </div>
</div>

<div class="d-none col-xs-none d-md-block">
    <div class="fs-32 text-center mt-4 linear-text">BIỂU ĐỒ</div>

    <div class="row row-cards">
        <div class="col-md-4">
            <div id="piechart-1" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-4">
            <div id="piechart-3" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-4">
            <div id="piechart-4" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-4">
            <div id="piechart-5" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-4">
            <div id="piechart-6" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-4">
            <div id="piechart-7" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-4">
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
            title: 'NGUỒN DOANH THU',
            width: '500',
            pieHole: 0.5,
            height: 300,
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 13 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
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
                @foreach($data['category_product'] as $k =>$item)
                @if(!empty($item))
            ['{{$item->name}}', {{$item->total}}],
            @endif
            @endforeach
        ]);

        var options = {
            title: 'TOP 5 SẢN PHẨM BÁN CHẠY NHẤT',
            width: 500,
            height: 300,
            pieHole: 0.5,
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 13 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            }
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
            title: 'DOANH THU THEO ĐƠN',
            width: 500,
            height: 300,
            pieHole: 0.5,
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 13 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            }
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
        data.sort([{ column: 1, desc: true }]);

        // Select only the top 10 values
        var topValues = new google.visualization.DataView(data);
        topValues.setColumns([0, 1], [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

        var options = {
            title: 'DOANH SỐ TOP 5 NHÀ CUNG CẤP',
            width: 500,
            height: 300,
            pieHole: 0.5,
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 13 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            }
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
        var topValues = new google.visualization.DataView(data);
        topValues.setColumns([0, 1], [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        var options = {
            title: 'DOANH THU THEO GIỚI TÍNH',
            width: 500,
            height: 300,
            pieHole: 0.5,
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 13 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            }
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
        var topValues = new google.visualization.DataView(data);
        topValues.setColumns([0, 1], [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        var options = {
            title: 'THỰC THU THEO LOẠI KHÁCH HÀNG',
            width: 500,
            height: 300,
            pieHole: 0.5,
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 13 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            }
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
            // series: {1: {type: 'line'}},
            bar: {groupWidth: '75%'},
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 16 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            },
            textStyle: {
                color: '#fff',
            },
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
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
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 16 // Set title font size
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            },
            textStyle: {
                color: '#fff',
            },
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            isStacked: true,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('column2'));
        chart.draw(data, options);
    }
</script>
