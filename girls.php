<html>
<head>
    <!--    Chart -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>Boys Name</title>
<?php

include 'db.php';

function helper($time) {
    $query ="SELECT name, frequency FROM names JOIN states WHERE sex = 'F' AND year = $time GROUP BY frequency DESC LIMIT 20"; 
    return $query;
}


    $time = $_GET['time'];
    $query = helper($time);
    $result = [];
    $rows = mysqli_query($db, $query);
    while ($row = mysqli_fetch_array($rows)) {
        array_push($result, $row);
    }
    $data = [];
    foreach ($result as $r) {
        $dataRow = array("y" => $r['frequency'], "label" => $r['name']);
        array_push($data, $dataRow);
    }
//    print_r($data);

    print "<center><h1> Choose a year </h1>";
    print "<form method=GET action='girls.php' class='text-center'><select name='time'>";
    for($i=2000;$i<2019;$i++) {
        print "<option value='$i'> $i </option>";
    }
//    print "<option value='2017'> 2017</option>";
//    print "<option value='2016'> 2016</option>";
//    print "<option value='2015'> 2015</option>";
//    print "<option value='2014'> 2014</option>";
    print "</select>";
    print "<input type='submit' name='submit' value='submit'></form></center>";
?>
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "<?php echo " most popular girls' name in $time"; ?>"
            },
            axisX: {
                title: "Name"
            },
            axisY: {
                title: "Frequency"
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>
</head>
<body>
    <div id="chartContainer" style="height: 75%; width: 100%;"></div>
    <input style="margin-top: 32px;" type="button" onclick="window.location.href='index.php'" class="btn btn-black py-3 btn-block" value="< Back" />
</body>

</html>
