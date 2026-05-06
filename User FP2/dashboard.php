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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#logoutModal">
    Logout
</button>
            </div>
        </div>
        <hr>

        <!-- User Information Card -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card p-3 shadow-sm blue-theme">
                    <h4>User Information</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Full Name:</strong> <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?php echo $_SESSION['username']; ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo $_SESSION['email']; ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div class="row mt-4">
            <div class="col-md-4 d-flex">
                <div class="card p-3 shadow-sm blue-theme w-100 d-flex flex-column">
                    <h4>Profile</h4>
                    <p>Edit your name and email address.</p>
                    <div class="mt-auto">
                        <a href="edit_profile.php" class="btn btn-primary w-100">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card p-3 shadow-sm blue-theme w-100 d-flex flex-column">
                    <h4>Password</h4>
                    <p>Keep your account safe by changing your password.</p>
                    <div class="mt-auto">
                        <a href="change_password.php" class="btn btn-primary w-100">Change Password</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card p-3 shadow-sm blue-theme w-100 d-flex flex-column">
                    <h4>Delete Account</h4>
                    <p>Just do it, Delete it.</p>
                    <div class="mt-auto">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account?</p>
                    <p class="text-danger"><strong>This action cannot be undone.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="delete_account.php" class="btn btn-danger">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>

        </div>
    </div>
</div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>