<?php
session_start();
include 'db.php';
$error = "";

if (isset($_POST['login'])) {
    // This grabs the information from the login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // This is where the database ask the user.
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    // To find the users.
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // This checks if the password is correct.
        if (password_verify($password, $user['password'])) { // This is where the password is success, then the login proceeds.
            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "User not found!";
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
        <h1 class="welcome-text">👋Welcome!</h1>
        <h6 class="p">Hellow! Welcome to User Account Management!<h6>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

                <!-- Login Password Error -->
            <?php if ($error !== ""): ?>
                <div class="alert alert-danger p-2 text-center" style="font-size: 0.9rem; border-radius: 10px;">
            <?php echo $error; ?>
                </div>
            <?php endif; ?>

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
