<?php
session_start();
include 'db.php';

if (isset($_POST['register'])) {
    $fname    = trim($_POST['fname']);
    $lname    = trim($_POST['lname']);
    $email    = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    // Validates if it fills the requirements.
    if (empty($fname) || empty($lname) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // This checks the Password Complexity if it aligns to the password created.
    $uppercase = preg_match('@[A-Z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $special   = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$number || !$special || strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters, include one uppercase letter, one number, and one special character.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // This check if the username is unique and no duplication.
    $stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Username is already taken.";
    }

    // Checks if everything is ok, then proceed to the inserting registration
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (first_name, last_name, email, username, password, role) 
                VALUES ('$fname', '$lname', '$email', '$username', '$hashed_password', 'user')";
        
        if ($mysqli->query($sql)) {
            $_SESSION['register_success'] = "Registered successfully! Please login.";
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Database error: " . $mysqli->error;
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
    <div class="form-side">
        <h1 class="welcome-text">Register</h1>

        <form action="register.php" method="POST">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo isset($fname) ? htmlspecialchars($fname) : ''; ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo isset($lname) ? htmlspecialchars($lname) : ''; ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <div class="mb-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger p-2" style="font-size: 0.85rem;">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <button type="submit" name="register" class="login-btn w-100">Create Account</button>
        </form>

        <div class="register-footer">
            Already have an account? <a href="login.php">Login here!</a>
        </div>
    </div>
</div>
