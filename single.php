<html>
<head>
    <title>Random Name Generator </title>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
// report mysql bug to php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// DB credentials
 include 'db.php';

function getQuery($gender) {
    $query = "SELECT name FROM distinctNamesWithSex WHERE sex='$gender' ORDER BY RAND() LIMIT 1";
    return $query;
}

$gender = $_POST['gender'];
$query = getQuery($gender);
$rows = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($rows)) {
        print "<h2>Name your baby $row[name] .</h2>";
    }

?>
</body>
</html>