<?php
session_start();
include 'db.php';

if(isset($_POST['register'])){
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if exists
    $check_sql = "SELECT user_id FROM users WHERE username='$username' OR email='$email'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0){
        $error = "Username or email already exists!";
    } else {
        $sql = "INSERT INTO users (first_name, last_name, email, username, password, role) 
                VALUES ('$fname', '$lname', '$email', '$username', '$password', 'user')";
        
        if($conn->query($sql)){
            $_SESSION['register_success'] = "Registered successfully! Please login.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - User System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-card">
    <!-- Left Side: Form Section -->
    <div class="form-side">
        <h1 class="welcome-text">Register</h1>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" name="register" class="login-btn w-100">Create Account</button>
        </form>

        <div class="register-footer">
            Already have an account? <a href="login.php">Login here!</a>
        </div>
    </div>

    <!-- Right Side: Visual Section (Identical to login) -->
    <div class="image-side">
        <div class="abstract-overlay"></div>
    </div>
</div>

</body>
</html>
