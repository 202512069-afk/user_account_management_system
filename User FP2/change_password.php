<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = trim($_POST['current_password'] ?? '');
    $newPassword     = trim($_POST['new_password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');
    $userId          = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        $error = "No user is logged in.";
    } else {
        $stmt = $mysqli->prepare("SELECT password FROM users WHERE user_id=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($storedHash);
        $stmt->fetch();
        $stmt->close();

        if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
            $error = "All fields are required.";
        } elseif (!password_verify($currentPassword, $storedHash)) {
            $error = "Current password is incorrect.";
        } elseif ($newPassword !== $confirmPassword) {
            $error = "New passwords do not match.";
        } elseif ($newPassword === $currentPassword) {
            $error = "New password must be different.";
        } elseif (strlen($newPassword) < 8) {
            $error = "Password must be at least 8 characters.";
        } else {
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("UPDATE users SET password=? WHERE user_id=?");
            $stmt->bind_param("si", $newHash, $userId);
            if ($stmt->execute()) {
                $success = "Password changed successfully!";
            } else {
                $error = "Password update failed.";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css"> <!-- same CSS as dashboard -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-#40a1fe d-flex align-items-center justify-content-center" style="height:100vh;">
    <div class="card p-4 shadow-sm" style="max-width:500px; width:100%;">
        <h4 class="mb-3">Change Password</h4>
        <p>Keep your account safe by changing your password.</p>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" class="form-control" name="current_password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Update Password</button>
        </form>
        <a href="dashboard.php" class="btn btn-primary w-100 mb-2">Back to Dashboard</a>
        <?php if(isset($error)) echo "<p class='text-danger mt-3'>$error</p>"; ?>
        <?php if(isset($success)) echo "<p class='text-success mt-3'>$success</p>"; ?>
    </div>
</body>
</html>
