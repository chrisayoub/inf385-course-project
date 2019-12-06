<?php

include 'db.php';

// Get query for top names by year and gender
function getQuery($year, $gender) {
    return
        "SELECT name, SUM(frequency) AS f FROM names WHERE sex = '$gender' AND year = $year
                    GROUP BY name ORDER BY f DESC LIMIT 20";
}

function renderTrendingPage($genderCode, $genderFullName, $pageName) {
    printHeader($genderFullName . " Names");

    $data = [];
    $doQuery = array_key_exists("time", $_GET);
    // Only check DB if we are checking for a specific year
    if ($doQuery) {
        $time = $_GET['time'];
        $query = getQuery($time, $genderCode);
        $result = getResults($query);
        foreach ($result as $r) {
            $dataRow = array("y" => $r['f'], "label" => $r['name']);
            array_push($data, $dataRow);
        }
    }

    printYearPicker(YEAR_MAX, 2000, $pageName, 'time');
    printSubmit();

    if ($doQuery) {
        // Format title
        $graphTitle = "Most Popular $genderFullName Names in $time";

        // Print chart
        printChart($graphTitle, $data);
    }

    // Print back button
    backButton();
    printFooter();
}
?>

