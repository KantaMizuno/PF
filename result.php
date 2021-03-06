<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql = "select answer, count(id) as count from answers group by answer";

$rows = array();
foreach ($dbh->query($sql) as $row) {
    array_push($rows, array($row['answer'], (int)$row['count']));
}
$data = json_encode($rows);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="result.css">
    <title>投票システム</title>
</head>
<body>

<h1>投票結果</h1>
<div id="chart_div">投票結果を読込中です...</div>
<p><a href="ranking.php">戻る</a></p>

<script src="https://www.google.com/jsapi"></script>
<script>
    google.load('visualization', '1.0', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
      var data = new google.visualization.DataTable();
        data.addColumn('string', 'Answer');
        data.addColumn('number', '票数');
        data.addRows(<?php echo $data; ?>);
        var options = {
            'title': '投票結果',
            'width': 400,
            'height': 300
        }
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>
</body>
</html>