<?php

// DB credentials
include 'db.php';

// Gets a query based on the supplied fields
function getQuery($name, $state, $gender, $year) {
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
    $query .= "GROUP BY year ORDER BY year ";

    return $query;
}

// Grab input vals
$name = sanitize($_POST['name']);
$state = $_POST['state'];
$gender = $_POST['gender'];
$year = $_POST['year']; // No need to sanitize, parsing.

// Query db
$query = getQuery($name, $state, $gender, $year);
$results = getResults($query);

// Format for graph
$data = [];
foreach ($results as $row) {
    $dataRow = array("y" => $row[3], "label" => $row['year'] );
    array_push($data, $dataRow);
}

// Print page
$graphTitleGender = $gender == BLANK_FIELD ? "M & F" : $gender;
$graphTitleState = $state == BLANK_FIELD ? "All states" : $results[0]['fullName'];
$graphTitle = "$name ($graphTitleGender, $graphTitleState)";

printHeader("Name Search");

if (empty($data)) {
    print("<h1>No data available.</h1>");
} else {
    printChart($graphTitle, $data);
}

backButton("history.back()");
printFooter();
?>
