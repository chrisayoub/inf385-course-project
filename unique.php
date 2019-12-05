<?php

include 'db.php';

// Get a query for rare names by year and gender
// Frequency of 5 is the absolute min
function getQuery($year, $gender) {
    return
        "SELECT * FROM (
                      SELECT name, SUM(frequency) AS f
                      FROM names
                      WHERE sex = '$gender'
                        AND year = $year
                      GROUP BY name
                  ) AS n WHERE n.f = 5 ORDER BY RAND() LIMIT 20";
}

printHeader("The Most Unique Names");

$doQuery = array_key_exists("year", $_GET);
if ($doQuery){
    $year = $_GET['year'];
    $gender = $_GET['gender'];
    $genderName = '';
    if ($gender == "M"){
        $genderName = "Male";
    }
    else {
        $genderName = "Female";
    }
    $query = getQuery($year, $gender);
    $results = getResults($query);
    echo "<h3>Some Unique $genderName Names in $year</h3>";
    echo "<ul>";
    foreach ($results as $row) {
        echo "<li>" . $row['name'] . "</li>";
    }
    echo "</ul>";
}

printYearPicker(YEAR_MAX, YEAR_MIN, 'unique.php', 'year');
print "<h1> Choose a gender: </h1>";
print "<select name='gender'><option value='M'>Male</option><option value='F'>Female</option></select>";
printSubmit();

// Print back button
backButton();
// End page
printFooter();
?>

