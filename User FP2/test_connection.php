<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "db_usermanagement");

if (!$conn) {
    echo "<h3>Connection Failed!</h3>";
    echo "Error Number: " . mysqli_connect_errno() . "<br>";
    echo "Error Message: " . mysqli_connect_error();
} else {
    echo "<h3>Success! The database is connected.</h3>";
}
?>