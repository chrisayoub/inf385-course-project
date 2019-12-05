<?php

// DB credentials
include 'db.php';

function getQuery($gender, $N) {
    $query = "SELECT name FROM distinctNamesWithSex ";
    if ($gender !== BLANK_FIELD) {
        $query .= "WHERE sex = '$gender' ";
    }
    $query .= "ORDER BY RAND() LIMIT $N";
    return $query;
}

printHeader("Random Name Generator");

$gender = $_POST['gender'];
$N = $_POST['number'];
$query = getQuery($gender, $N);
$results = getResults($query);
echo "<h1>Here are some options:</h1>";
echo "<ul>";
foreach ($results as $row) {
    echo "<li>" . $row['name'] . "</li>";
}
echo "</ul>";

backButton();
printFooter();
?>
