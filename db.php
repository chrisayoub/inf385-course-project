<?php
$host = "127.0.0.1";
$username = "air";
$password = "inf385";
$database = "air";
$db = mysqli_connect($host, $username, $password, $database);

function sanitize($input) {
    return preg_replace("/[^ 0-9-a-zA-Z]+/", "", $input);
}

function backButton() {
    print(
        "<input style=\"margin-top: 32px;\" type=\"button\" onclick=\"history.back()\" class=\"btn btn-black py-3 btn-block\" value=\"< Back\" />"
    );
}
?>