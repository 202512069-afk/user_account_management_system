<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .blue-theme .card { border-left: 5px solid #0d6efd; }
        .blue-theme .btn-primary { background-color: #0d6efd; border-color: #0d6efd; }
        .blue-theme .btn-primary:hover { background-color: #0b5ed7; border-color: #0a58ca; }
        .blue-theme .admin-badge { background-color: #0d6efd !important; color: white; }
        .blue-theme .admin-panel { background-color: #0d6efd !important; border-color: #0d6efd !important; }
        .blue-theme .admin-panel:hover { background-color: #0b5ed7 !important; }
    </style>
</head>
<body class="bg-light blue-theme">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <span class="badge admin-badge">ADMIN</span>
                <?php endif; ?>
            </div>
            <div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="admin_view.php" class="btn btn-primary admin-panel me-2">Admin Panel</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-primary" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>
        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm blue-theme">
                    <h4>Profile</h4>
                    <p>Edit your name and email address.</p>
                    <a href="edit_profile.php" class="btn btn-primary w-100">Edit Profile</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm blue-theme">
                    <h4>Password</h4>
                    <p>Keep your account safe by changing your password.</p>
                    <a href="change_password.php" class="btn btn-primary w-100">Change Password</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm blue-theme">
                    <h4>Delete Account</h4>
                    <p>Just do it, Delete it.</p>
                    <a href="delete_account.php" class="btn btn-primary w-100"
                    onclick="return confirm('Are you sure you want to delete your account?\nThis action cannot be undone.');">
                        Delete Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    document.querySelector('.btn-outline-primary[onclick*="delete"]').onclick = function(e) {
        e.preventDefault();
        if (confirm('You are an admin. This will:\n• Remove admin privileges\n• Delete all data permanently\n• Cannot be recovered\n\nType CONFIRM to continue:')) {
            if (prompt('Type CONFIRM to delete your admin account:') === 'CONFIRM') {
                window.location.href = 'delete_account.php';
            }
        }
    };
    <?php endif; ?>
    </script>
</body>
</html>