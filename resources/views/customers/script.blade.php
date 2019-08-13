<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($statusRevenues as $statusRevenue)
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
                @foreach($statusRevenueByRelations as $statusRevenueByRelation)
            ['{{ $statusRevenueByRelation['name'] }}', {{ $statusRevenueByRelation['revenue'] }}],
            @endforeach
        ]);

        var options = {
            title: 'DOANH THU THEO MỐI QUAN HỆ'
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
                @foreach($categoryRevenues as $categoryRevenue)
            ['{{ $categoryRevenue['name'] }}', {{ $categoryRevenue['revenue'] }}],
            @endforeach
        ]);

        var options = {
            title: 'DOANH THU THEO NHÓM KHÁCH HÀNG'
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
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
                @foreach($statuses as $status)
            ['{{ $status->name }}', {{ $status->customers->count() }}],
            @endforeach
        ]);

        var options = {
            title: 'SỐ LƯỢNG THEO MỐI QUAN HỆ'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart-pie2'));

        chart.draw(data, options);
    }
</script>
{{--<!-- Index Scripts -->--}}
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', ''],
            @foreach($customer as $item)
            ['{{ $item->monthNum }}', {{ $item->totalCustomer }}],
                @endforeach
        ]);

        var options = {
            title: 'TĂNG TRƯỞNG SỐ LƯỢNG KHÁCH HÀNG',
            curveType: 'function',
            legend: { position: 'bottom' },
            label: true
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart-sracked'));

        chart.draw(data, options);
    }
</script>