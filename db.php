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

// Data ranges
define("YEAR_MIN", 1910);
define("YEAR_MAX", 2018);

// Indicates a field was unspecified
define("BLANK_FIELD", "all");
define("BLANK_TEXT_FIELD", "");
?>