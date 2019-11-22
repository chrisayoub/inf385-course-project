<head>
    <!--    Chart -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<?php

// DB credentials
include 'db.php';

// Indicates field was unspecified
const BLANK_FIELD = "all";
const BLANK_TEXT_FIELD = "";

//const lengthMap = [
//    "2-4" => [2, 4],
//    "5-7" => [5, 7],
//    "8-12" => [8, 12],
//    "13+" => [13, 20],
//];

// Gets a query based on the supplied fields
function getQuery($name, $state, $gender, $year, $length) {
    $yearVal = -1;
    if ($year !== BLANK_TEXT_FIELD) {
        $yearVal = intval($year);
        if ($yearVal == 0) {
            print("<p>Notice: year was ignored because not a valid year string.</p>");
        }
    }
    if ($name == BLANK_TEXT_FIELD) {
        // For performance reasons... don't let them query everything
        print("<h1>Error: must specify a name.</h1>");
        return "";
    }

    $query = "SELECT sex, year, state, SUM(frequency), s.fullName FROM names 
                    JOIN states s on names.state = s.id 
                    WHERE name = '$name' ";
    if ($state !== BLANK_FIELD) {
        $query .= "AND state = $state ";
    }
    if ($gender !== BLANK_FIELD) {
        $query .= "AND sex = '$gender' ";
    }
    if ($yearVal > 0) {
        $query .= "AND year = $year ";
    }
//    if ($length !== BLANK_FIELD) {
//        $pair = lengthMap[$length];
//        $startLen = $pair[0];
//        $endLen = $pair[1];
//        $query .= "AND LENGTH(name) >= $startLen AND LENGTH(name) <= $endLen ";
//    }
    $query .= "GROUP BY year ORDER BY year ";

    return $query;
}

function getResults($query) {
    global $db;
    $result = [];

    $rows = mysqli_query($db, $query);
    while ($row = mysqli_fetch_array($rows)) {
        array_push($result, $row);
    }
    return $result;
}

$name = sanitize($_POST['name']);
$state = $_POST['state'];
$gender = $_POST['gender'];
$year = $_POST['year']; // No need to sanitize, parsing.
$length = $_POST['length'];

$query = getQuery($name, $state, $gender, $year, $length);
$results = getResults($query);

$data = [];
foreach ($results as $row) {
    $dataRow = array("y" => $row[3], "label" => $row['year'] );
    array_push($data, $dataRow);
}
if (empty($data)) {
    print("<h1>No data available.</h1>");
}

$graphTitleGender = $gender == BLANK_FIELD ? "M & F" : $gender;
$graphTitleState = $state == BLANK_FIELD ? "All states" : $results[0]['fullName'];
$graphTitle = "$name ($graphTitleGender, $graphTitleState)";
?>

<body>
<script>
    window.onload = function() {
        let dataPoints = <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>;
        if (dataPoints.length == 0) {
            return;
        }

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "<?php echo $graphTitle; ?>"
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
    <div id="chartContainer" style="height: 75%; width: 100%;"></div>
    <input style="margin-top: 32px;" type="button" onclick="history.back()" class="btn btn-black py-3 btn-block" value="< Back" />
</body>