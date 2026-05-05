<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; 

$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);

if (mysqli_stmt_execute($stmt)) {
    session_destroy();

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Account Deleted</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='bg-light d-flex align-items-center justify-content-center' style='min-height:100vh;'>
        <div class='text-center p-5 border rounded-4 shadow-lg bg-white' style='max-width:500px;'>
            <div class='mb-4'>
                <i class='bi bi-check-circle-fill text-success' style='font-size:4rem;'></i>
            </div>
            <h2 class='mb-3'>Account Deleted Successfully</h2>
            <p class='text-muted mb-4'>Your account is now permanent deleted. Thank you!</p>
            <a href='login.php' class='btn btn-primary btn-lg px-5'>Go to Login</a>
        </div>
    </body>
    </html>";
} else {
    $_SESSION['error'] = "Failed to delete account. Please try again.";
    header("Location: dashboard.php");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>