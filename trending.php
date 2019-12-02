<?php

include 'db.php';

// Get query for top names by year and gender
function getQuery($year, $gender) {
    return
        "SELECT name, frequency FROM names JOIN states WHERE sex = '$gender' AND year = $year 
                GROUP BY frequency DESC LIMIT 20";
}

function printHeader($genderName) {
    // Print necessary page header
    print("
<html>
<head>
    <!--    Chart -->
    <script src=\"https://canvasjs.com/assets/script/canvasjs.min.js\"></script>
    <!-- MAIN CSS -->
    <link rel=\"stylesheet\" href=\"css/style.css\">
    <title>$genderName Names</title>
    <style>
        body {
            text-align: center;
        }   
    </style>
</head>
<body>
");
}

function printFooter($chartData, $genderName, $year, $doQuery) {
    if ($doQuery) {
        // Format data
        $graphTitle = "Most Popular $genderName Names in $year";
        $graphData = json_encode($chartData, JSON_NUMERIC_CHECK);

        // Print chart
        print("
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart(\"chartContainer\", {
            animationEnabled: true,
            theme: \"light2\",
            title:{
                text: \"$graphTitle\"
            },
            axisX: {
                title: \"Name\"
            },
            axisY: {
                title: \"Frequency\"
            },
            data: [{
                type: \"column\",
                dataPoints: $graphData
            }]
        });
        chart.render();
    }
</script>
    <div id=\"chartContainer\" style=\"height: 75%; width: 100%;\"></div>
");
    }

    // Print back button
    backButton();
    // End page
    print("</body></html>");
}

function renderTrendingPage($genderCode, $genderFullName, $pageName) {
    printHeader($genderFullName);

    global $db;
    $data = [];
    $doQuery = array_key_exists("time", $_GET);
    // Only check DB if we are checking for a specific year
    if ($doQuery) {
        $time = $_GET['time'];
        $query = getQuery($time, $genderCode);
        $result = [];
        $rows = mysqli_query($db, $query);
        while ($row = mysqli_fetch_array($rows)) {
            array_push($result, $row);
        }
        foreach ($result as $r) {
            $dataRow = array("y" => $r['frequency'], "label" => $r['name']);
            array_push($data, $dataRow);
        }
    }

    print "<h1> Choose a year </h1>";
    print "<form method=GET action='$pageName' class='text-center'><select name='time'>";
    for ($i = 2019; $i >= 2000; $i--) {
        print "<option value='$i'> $i </option>";
    }
    print "</select>";
    print "<input type='submit' name='submit' value='submit'></form>";

    printFooter($data, $genderFullName, $time, $doQuery);
}
?>

