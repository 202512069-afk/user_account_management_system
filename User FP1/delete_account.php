<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password'] ?? '');
    $userId   = $_SESSION['user_id'];

    if ($password === '') {
        $error = "Password is required.";
    } else {
        // Fetch stored password hash
        $stmt = $mysqli->prepare("SELECT password FROM users WHERE user_id=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($storedHash);
        $stmt->fetch();
        $stmt->close();

        // Verify entered password
        if (!password_verify($password, $storedHash)) {
            $error = "Current password is incorrect.";
        } else {
            // Delete account
            $stmt = $mysqli->prepare("DELETE FROM users WHERE user_id=?");
            $stmt->bind_param("i", $userId);
            if ($stmt->execute()) {
                session_destroy();
                header("Location: login.php?msg=Account deleted");
                exit;
            } else {
                $error = "Account deletion failed.";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-#40a1fe d-flex align-items-center justify-content-center" style="height:100vh;">
    <div class="card p-4 shadow-sm" style="max-width:500px; width:100%;">
        <h4 class="mb-3 text-primary">Delete Account</h4>
        <p class="text-primary">Warning: This action cannot be undone!</p>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone!');">
            <div class="mb-3">
                <label class="form-label">Enter Current Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Delete My Account</button>
        </form>
        <a href="dashboard.php" class="btn btn-primary w-100 mb-2">Back to Dashboard</a>
        <?php if(isset($error)) echo "<p class='text-primary mt-3'>$error</p>"; ?>
    </div>
</body>
</html>
