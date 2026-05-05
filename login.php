<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    
        header("Location: dashboard.php");
        exit();
    }
        else {
            echo "<script>alert('Invalid Password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-card">
    <!-- Left Side: Form Section -->
    <div class="form-side">
        <div class="brand-icon">👋</div>
        <h1 class="welcome-text">Welcome!</h1>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            
            <div class="options-row">
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" name="login" class="login-btn">Login</button>
        </form>

        <div class="register-footer">
            Don't have an account? <a href="register.php">Sign up here!</a>
        </div>
    </div>

    <!-- Right Side: Visual Section -->
    <div class="image-side">
        <div class="abstract-overlay"></div>
    </div>
</div>

</body>
</html>
