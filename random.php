<html>
<head>
    <title>Random Name Generator </title>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
body {
    margin: 50px;
}
</style>

<body>

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

$gender = $_POST['gender'];
$N = $_POST['number'];
$query = getQuery($gender, $N);
$rows = mysqli_query($db, $query);
echo "<h1>Here are some options:</h1>";
echo "<ul>";
while ($row = mysqli_fetch_array($rows)) {
    echo "<li>" . $row['name'] . "</li>";
}
echo "</ul>";

backButton();
?>
</body>
</html>