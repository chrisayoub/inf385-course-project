<?php

include 'db.php';

// Get query for top names by year and gender
function getQuery($year, $gender) {
    return
        "SELECT name, frequency FROM names WHERE sex = '$gender' AND year = $year 
                GROUP BY frequency DESC LIMIT 20";
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
            $dataRow = array("y" => $r['frequency'], "label" => $r['name']);
            array_push($data, $dataRow);
        }
    }

    print "<h1> Choose a year </h1>";
    print "<form method=GET action='$pageName' class='text-center'><select name='time'>";
    for ($i = YEAR_MAX; $i >= 2000; $i--) {
        print "<option value='$i'> $i </option>";
    }
    print "</select>";
    print "<input type='submit' name='submit' value='submit'></form>";

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

