<?php
// DB credentials/connection
$host = "127.0.0.1";
$username = "air";
$password = "inf385";
$database = "air";
$db = mysqli_connect($host, $username, $password, $database);

// Used for input sanitization
function sanitize($input) {
    return preg_replace("/[^ 0-9-a-zA-Z]+/", "", $input);
}

// Do a simple back button
function backButton() {
    print(
        "<input style=\"margin-top: 32px;\" type=\"button\" onclick=\"history.back()\" class=\"btn btn-black py-3 btn-block\" value=\"< Back\" />"
    );
}

// Get results of a query as an array
function getResults($query) {
    global $db;
    $result = [];

    $rows = mysqli_query($db, $query);
    while ($row = mysqli_fetch_array($rows)) {
        array_push($result, $row);
    }
    return $result;
}

// Print necessary page header
function printHeader($pageTitle) {
    print("
<html>
<head>
    <!--    Chart -->
    <script src=\"https://canvasjs.com/assets/script/canvasjs.min.js\"></script>
    <!-- MAIN CSS -->
    <link rel=\"stylesheet\" href=\"css/style.css\">
    <title>$pageTitle</title>
    <style>
        body {
            text-align: center;
            margin: 50px;
        }   
    </style>
</head>
<body>
");
}

// Common footer
function printFooter() {
    print("</body></html>");
}

// Render a chart for the given data
function printChart($title, $data) {
    $json = json_encode($data, JSON_NUMERIC_CHECK);
    print("
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart(\"chartContainer\", {
            animationEnabled: true,
            theme: \"light2\",
            title:{
                text: \"$title\"
            },
            axisY: {
                title: \"Frequency\"
            },
            data: [{
                type: \"column\",
                dataPoints: $json
            }]
        });
        chart.render();
    }
</script>
    <div id=\"chartContainer\" style=\"height: 75%; width: 100%;\"></div>
");
}

// Data ranges
define("YEAR_MIN", 1910);
define("YEAR_MAX", 2018);

// Indicates a field was unspecified
define("BLANK_FIELD", "all");
define("BLANK_TEXT_FIELD", "");
?>