<?php

// DB credentials
include 'db.php';

// Indicates field was unspecified
const BLANK_FIELD = "all";
const BLANK_TEXT_FIELD = "";

const lengthMap = [
    "2-4" => [2, 4],
    "5-7" => [5, 7],
    "8-12" => [8, 12],
    "13+" => [13, 20],
];

// Gets a query based on the supplied fields
function getQuery($name, $state, $gender, $year, $length) {
    $yearVal = intval($year);
    if ($yearVal == 0) {
        print("<p>Notice: year was ignored because not a valid year string.</p>");
    }

    $query = "SELECT * FROM names WHERE true = true ";
    if ($name !== BLANK_TEXT_FIELD) {
        $query .= "AND name = '$name' ";
    }
    if ($state !== BLANK_FIELD) {
        $query .= "AND state = $state ";
    }
    if ($gender !== BLANK_TEXT_FIELD) {
        $query .= "AND sex = '$gender' ";
    }
    if ($yearVal != 0) {
        $query .= "AND year = $year ";
    }
    if ($length !== BLANK_FIELD) {
        $pair = lengthMap[$length];
        $startLen = $pair[0];
        $endLen = $pair[1];
        $query .= "AND LENGTH(name) >= $startLen AND LENGTH(name) <= $endLen ";
    }

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

$name = $_POST['name'];
$state = $_POST['state'];
$gender = $_POST['gender'];
$year = $_POST['year'];
$length = $_POST['length'];

$query = getQuery($name, $state, $gender, $year, $length);
$results = getResults($query);

print($query);
print("<br><br>");
print_r($results);
?>

