<?php
session_start();
include 'db.php';

if (isset($_POST['change_pw'])) {
    $user_id = $_SESSION['user_id'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = '$new_password' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Password updated successfully!";
    }
}
?>

<form method="POST">
    <input type="password" name="new_password" placeholder="Enter New Password" required>
    <button type="submit" name="change_pw">Change Password</button>
</form>