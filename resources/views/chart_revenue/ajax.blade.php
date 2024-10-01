<div class="container mt-24">
    <div class="mt-24">
        <canvas id="myChart"></canvas>
    </div>
</div>

<script type="text/javascript">
    var ctx  = document.getElementById('myChart').getContext('2d');
    new Chart(ctx , {
        type: 'bar',
        data: {
            labels: [{!! $branchs !!}],
            datasets: [
                {
                    label: 'Doanh số',
                    data: [{{$all_totals}}],
                    backgroundColor: '#C4F2FF',
                    borderWidth: 1,
                    barThickness: 30 // Độ cao của các thanh
                },
                {
                    label: 'Doanh thu',
                    data: [{{$gross_revenues}}],
                    backgroundColor: '#3BDBFF',
                    borderWidth: 1,
                    barThickness: 30 // Độ cao của các thanh
                },
                {
                    label: 'Đã thu trong kỳ',
                    data: [{{$payments}}],
                    backgroundColor: '#00AEFF',
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
{{--end barchart--}}

