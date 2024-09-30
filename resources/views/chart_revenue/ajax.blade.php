<div class="container mt-24">
    <div class="mt-24">
        <canvas id="myChart"></canvas>
        <input type="hidden" id="branch" value="{{$branchs}}">
    </div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let arr = $('#branch').val();
    let newArr = arr.replace(/&#039;/g,'"');
    console.log(newArr)
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["CN - Quận 10","CN - Tân Bình"],
            datasets: [
                {
                    label: 'Doanh số',
                    data: [{{$all_totals}}],
                    backgroundColor: '#C4F2FF',
                    // borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    barThickness: 30 // Height of the bars
                },
                {
                    label: 'Doanh thu',
                    data: [{{$gross_revenues}}],
                    backgroundColor: '#3BDBFF',
                    // borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    barThickness: 30 // Height of the bars
                },
                {
                    label: 'Đã thu trong kỳ',
                    data: [{{$payments}}],
                    backgroundColor: '#00AEFF',
                    // borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    barThickness: 30 // Height of the bars
                }
            ]
        },

        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'white' // Thay đổi màu của label ở đây
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'white' // Thay đổi màu của label trục x
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white' // Thay đổi màu của label trục x
                    }
                }
            },
            layout: {
                padding: {
                    top: 0,   // Adjust top margin
                    bottom: 100 // Adjust bottom margin
                }
            },
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            barPercentage: 0.9, // Giảm độ rộng của thanh để gần nhau hơn
            categoryPercentage: 0.9, // Tăng khoảng cách giữa các thanh
            // indexAxis: 'y',
        }
    });
</script>
{{--end barchart--}}

