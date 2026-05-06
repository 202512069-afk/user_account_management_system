<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied! Your role is: " . ($_SESSION['role'] ?? 'none') . "'); window.location='login.php';</script>";
    exit();
}


$sql = "SELECT user_id, first_name, last_name, email, username, role FROM users ORDER BY username ASC";
$result = $mysqli->query($sql);

if (!$result) {
    die("Database query failed: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #e3f2fd; }
        .navbar { background-color: #0d6efd !important; }
        .navbar-brand { color: white !important; font-weight: 600; }
        .nav-link { color: white !important; }
        .table-container { background: white; padding: 30px; border-radius: 10px; margin: 30px auto; max-width: 1200px; border: 2px solid #0d6efd; box-shadow: 0 2px 10px rgba(13,110,253,0.1); }
        .table-header { background-color: #0d6efd; color: white; padding: 20px 25px; border-radius: 8px 8px 0 0; margin: -30px -30px 25px -30px; }
        .table-blue { border-collapse: separate; border-spacing: 0; border: 1px solid #dee2e6; }
        .table-blue th { background-color: #0d6efd !important; color: white !important; border-color: #0b5ed7 !important; font-weight: 600; border-right: 1px solid #0b5ed7; }
        .table-blue th:last-child { border-right: none; }
        .table-blue td { border-right: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6; }
        .table-blue td:last-child { border-right: none; }
        .table-blue code { color: #000 !important; font-weight: 500; font-size: 0.9em; }
        .btn-secondary { background-color: #0d6efd; border-color: #0d6efd; color: white; }
        .btn-secondary:hover { background-color: #0d6efd; border-color: #0d6efd; color: white; }
        .user-count { background-color: #0d6efd; color: white; border-radius: 20px; padding: 8px 16px; font-weight: 600; font-size: 0.9em; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand">
    <div class="container">
        <a class="navbar-brand" href="#">Admin System</a>
        <div class="navbar-nav ms-auto">
            <a href="dashboard.php" class="nav-link me-3 btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="table-container">
        <div class="table-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Registered Users</h2>
                <span class="user-count">
                    <?php echo $result->num_rows; ?> Users
                </span>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover table-blue">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td class="fw-bold"><?php echo $count++; ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><code><?php echo htmlspecialchars($row['username']); ?></code></td>
                    <td>
                        <span class="badge p-2 <?php echo ($row['role'] == 'admin') ? 'bg-danger' : 'bg-primary'; ?>">
                            <?php echo ucfirst($row['role']); ?>
                        </span>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
