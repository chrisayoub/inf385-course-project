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

function printHeader() {
    print("
<html>
<head>
    <!-- MAIN CSS -->
    <link rel=\"stylesheet\" href=\"css/style.css\">
    <title>The Most Unique Names</title>
    <style>
        body {
            text-align: center;
        }   
    </style>
</head>
<body>
");
}

    printHeader();
    global $db;
    $data = [];
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
        $result = [];
        $rows = mysqli_query($db, $query);
        echo "<h3>Some Unique $genderName Names in $year</h3>";
        echo "<ul>";
        while ($row = mysqli_fetch_array($rows)) {
            echo "<li>" . $row['name'] . "</li>";
        }
        echo "</ul>";
    }

    print "<h1> Choose a year: </h1>";
    print "<form method=GET action='unique.php' class='text-center'><select name='year'>";
    for ($i = YEAR_MAX; $i >= YEAR_MIN; $i--) {
        print "<option value='$i'> $i </option>";
    }
    print "</select>";
    print "<h1> Choose a gender: </h1>";
    print "<select name='gender'><option value='M'>Male</option><option value='F'>Female</option></select>";
    print "<input type='submit' name='submit' value='submit'></form><br>";

    // Print back button
    backButton();
    // End page
    print("</body></html>");
?>