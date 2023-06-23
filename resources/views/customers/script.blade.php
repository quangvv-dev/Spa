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
            title: 'DOANH THU THEO NGUỒN'
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
                @foreach($customerRevenueByGenders as $customerRevenueByGender)
            ['{{ $customerRevenueByGender['name'] }}', {{ $customerRevenueByGender['revenue'] }}],
            @endforeach
        ]);

        var options = {
            title: 'DOANH THU THEO GIỚI TÍNH'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-4'));

        chart.draw(data, options);
    }
</script>
