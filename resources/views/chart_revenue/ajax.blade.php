<div class="row">
    <div class="col-md-4 col-xs-12">
        <div id="piechart"></div>
    </div>
    <div class="col-md-4 col-xs-12">
        <div id="sourcechart"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Doanh số'],
                @foreach($tmp2 as $k =>$item2)
                @foreach($item2 as $k22 =>$value2)
            ['{{$k22}}', {{$value2}}],
            @endforeach
            @endforeach

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'Doanh thu theo nhóm KH', 'width': 650, 'height': 500};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart2);

    // Draw the chart and set the chart values
    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Doanh số'],
                @foreach($tmp as $k =>$item)
                @foreach($item as $k2 =>$value)
            ['{{$k2}}', {{$value}}],
            @endforeach
            @endforeach

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'Doanh thu theo nguồn KH', 'width': 650, 'height': 500};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('sourcechart'));
        chart.draw(data, options);
    }
</script>

