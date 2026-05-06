<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$query = "SELECT first_name, last_name, email, username FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update_profile'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $email = $_POST['email'];

    $update_sql = "UPDATE users SET first_name='$fname', last_name='$lname', email='$email' WHERE user_id='$user_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Profile Updated!'); window.location='profile.php';</script>";
    }
}
?>

<form method="POST">
    <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required>
    <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    <button type="submit" name="update_profile">Update Profile</button>
</form>