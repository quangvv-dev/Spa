<style>
    .font-30 {
        font-size: 20px;
    }

    .h4.text-center {
        color: cornflowerblue;
        font-weight: 600;
        margin-top: 10px;
    }
    #column text {
        fill: #fff; /* Đổi màu văn bản trong legend thành màu xanh */
        font-weight: bold; /* Đặt đậm cho văn bản trong legend */
    }
    #column2 text {
        fill: #fff; /* Đổi màu văn bản trong legend thành màu xanh */
        font-weight: bold; /* Đặt đậm cho văn bản trong legend */
    }
</style>

<div class="h4 text-center">SỐ LIỆU</div>
<div class="mt-24 d-flex justify-content-between gap-16">
    <div class="thong-ke__item">
        <div class="top d-flex justify-content-center align-items-center mt-16">
            <div class="text-center">
                <div class="linear-text" style="font-size: 17px;">Thực thu</div>
                <div class="number bold">{{@number_format($data['payment'] + $data['wallet_payment'] - $data['used'])}}</div>
            </div>
{{--            <div class="color-red" style="color: #FF0000;">--}}
{{--                <img src="images/TrendDown.png" alt=""> 12%--}}
{{--            </div>--}}
        </div>
        <div class="p-16">
            <div class="d-flex justify-content-between">
                <span class="fs-16">Tiền mặt</span>
                <div class="fs-16">{{number_format($list_payment['money'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Chuyển khoản</span>
                <div class="fs-16">{{number_format($list_payment['CK'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Thẻ</span>
                <div class="fs-16">{{number_format($list_payment['card'])}}</div>
            </div>
        </div>
    </div>
    <div class="thong-ke__item">
        <div class="top d-flex justify-content-center align-items-center mt-16">
            <div class="text-center">
                <div class="linear-text" style="font-size: 17px;">Tổng chi</div>
                <div class="number bold">{{@number_format($list_pay['money'] + $list_pay['CK'] +$list_pay['card'])}}</div>
            </div>
{{--            <div class="color-red" style="color: #FF0000;">--}}
{{--                <img src="images/TrendDown.png" alt=""> 12%--}}
{{--            </div>--}}
        </div>
        <div class="p-16">
            <div class="d-flex justify-content-between">
                <span class="fs-16">Tiền mặt</span>
                <div class="fs-16">{{number_format($list_pay['money'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Chuyển khoản</span>
                <div class="fs-16">{{number_format($list_pay['CK'])}}</div>
            </div>
        </div>
    </div>
    <div class="thong-ke__item">
        <div class="top d-flex justify-content-center align-items-center mt-16">
            <div class="text-center">
                <div class="linear-text" style="font-size: 17px;">Còn lại</div>
                <div class="number bold">{{@number_format(($data['payment'] + $data['wallet_payment'] - $data['used'])-($list_pay['money'] + $list_pay['CK'] +$list_pay['card']))}}</div>
            </div>
{{--            <div class="color-red" style="color: #FF0000;">--}}
{{--                <img src="images/TrendDown.png" alt=""> 12%--}}
{{--            </div>--}}
        </div>
        <div class="p-16">
            <div class="d-flex justify-content-between">
                <span class="fs-16">Tiền mặt</span>
                <div class="fs-16">{{number_format($list_payment['money'] - $list_pay['money'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Chuyển khoản</span>
                <div class="fs-16">{{@number_format($list_payment['CK'] - $list_pay['CK'])}}</div>
            </div>
            <div class="d-flex justify-content-between mt-12">
                <span class="fs-16">Thẻ</span>
                <div class="fs-16">{{@number_format($list_payment['card'] - $list_pay['card'])}}</div>
            </div>
        </div>
    </div>
</div>


<div class="d-none col-xs-none d-md-block">
    <div class="h4 text-center linear-text fs-32">BIỂU ĐỒ</div>

    <div class="row row-cards">
        <div class="col-md-6">
            <div id="piechart-1" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-2" style="margin-left: 15px"></div>
        </div>
    </div>
    <div class="container mt-24">
        <div class="mt-24">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/loader.js')}}"></script>
<script type="text/javascript">
    var ctx  = document.getElementById('myChart').getContext('2d');
    new Chart(ctx , {
        type: 'bar',
        data: {
            labels: [{!! $branch_names !!}],
            datasets: [
                {
                    label: 'Thực thu',
                    data: [{{$prices}}],
                    backgroundColor: '#C4F2FF',
                    borderWidth: 1,
                    barThickness: 30 // Độ cao của các thanh
                }
            ]
        },

        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'white'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'white'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white'
                    }
                }
            },
            layout: {
                padding: {
                    top: 0,
                    bottom: 100
                }
            },
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            barPercentage: 0.9,
            categoryPercentage: 0.9,
        }
    });
</script>
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
            pieHole: 0.5,
            colors: ['#3BDBFF', '#005A7F', '#00AEFF', '#00688B','#87CEEB','#87CEFF','#7EC0EE','#6CA6CD'],
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: '#fff', // Set title text color
                fontSize: 13 // Set title font size
            },
            textStyle: {
                color: '#fff',
            },
            legend: {
                textStyle: {
                    color: '#fff' // Set legend text color
                }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-2'));

        chart.draw(data, options);
    }
</script>
