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


<div class="h4 text-center">BIỂU ĐỒ</div>

<div class="row row-cards">
    <div class="col-md-12">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-md-12">
        <div id="percent"></div>
    </div>
</div>
<script type="text/javascript" src="{{asset('layout/js/chart.js')}}"></script>
<script type="text/javascript">
    var ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [{!! $name !!}],
            datasets: [

                {
                    label: 'Tổng lịch hẹn',
                    data: [{{$schedules}}],
                    backgroundColor: '#C4F2FF',
                    borderWidth: 1,
                },
                {
                    label: 'Lịch tới mua',
                    data: [{{$schedules_buy}}],
                    backgroundColor: '#4bcc4b',
                    borderWidth: 1,
                },
                {
                    label: 'Lịch tới k.mua',
                    data: [{{$schedules_notbuy}}],
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Lịch hủy',
                    data: [{{$schedules_cancel}}],
                    backgroundColor: '#ccc',
                    borderWidth: 1,
                }
            ]
        },
        options: {
            indexAxis: 'y',  // This makes the bar chart horizontal
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
