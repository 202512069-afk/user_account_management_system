<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_usermanagement";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check if the connection worked
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
