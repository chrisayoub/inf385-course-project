<head>
    <title>Random Name Generator </title>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<?php
// DB credentials
// include 'db.php';
//
// function getQuery($gender) {
//     $query = "SELECT name FROM distinctNamesWithSex WHERE sex='$gender' ORDER BY RAND() LIMIT 1");
//     return $query;
// }
//
// function getResults($query) {
//     global $db;
//     $result = [];
//
//     $rows = mysqli_query($db, $query);
//     while ($row = mysqli_fetch_array($rows)) {
//         array_push($result, $row);
//     }
//     return $result;
// }

// Get the gender
$gender = $_POST['gender'];
print "<p>$gender</p>";
// $query = getQuery($gender);
// $result = getResults($query);
//
// print "<h3 class="heading-29201 text-center">Name your baby $result[0] .</h3>";
?>
