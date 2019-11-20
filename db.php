<?php
$host = "127.0.0.1";
$username = "air";
$password = "inf385";
$database = "air";
$db = mysqli_connect($host, $username, $password, $database);

function sanitize($input) {
    return preg_replace("/[^ 0-9-a-zA-Z]+/", "", $input);
}
?>