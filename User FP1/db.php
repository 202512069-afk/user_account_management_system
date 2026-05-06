<?php

$host     = "localhost";
$user     = "root";
$pass     = "";
$dbname   = "db_usermanagement";


$mysqli = new mysqli($host, $user, $pass, $dbname);


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


$mysqli->set_charset("utf8mb4");
?>
