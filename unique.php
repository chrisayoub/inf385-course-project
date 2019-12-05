<?php

include 'db.php';

// Get a query for rare names by year and gender
function getQuery($year, $gender) {
    return
        "SELECT name, frequency FROM names WHERE sex = '$gender' AND year = $year 
                ORDER BY frequency ASC LIMIT 20";
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
            echo "<h3>The Most Unique $genderName Names in $year</h3>";
            echo "<table><tr><th>Name</th><th>frequency</th><tr>";
            while ($row = mysqli_fetch_array($rows)) {
                echo "<tr><th>" . $row['name'] . "</th><th>" . $row['frequency'] . "</th></tr>";
            }
        }

    print "<h1> Choose a year: </h1>";
    print "<form method=GET action='unique.php' class='text-center'><select name='year'>";
    for ($i = 2018; $i >= 2000; $i--) {
        print "<option value='$i'> $i </option>";
    }
    print "</select>";
    print "<h1> Choose a gender: </h1>";
    print "<select name='gender'><option value='M'>Male</option><option value='F'>Female</option></select>";
    print "<input type='submit' name='submit' value='submit'></form><br>";



        // while ($row = mysqli_fetch_array($rows)) {
        //     $result = $row['name'];
        // }
        // foreach ($result as $key) {
        // // print "<table>";
        // print "$key";
        // // print "<tr><td>$key<td><tr>";
        // // print "</table>";
        // }

//Edited - added semicolon at the End of line.1st and 4th(prev) line

    // Print back button
    backButton();
    // End page
    print("</body></html>");
?>