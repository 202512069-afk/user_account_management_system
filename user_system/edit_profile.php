<?php
session_start();
include 'db.php'; 


$firstName = $_SESSION['first_name'] ?? '';
$lastName  = $_SESSION['last_name'] ?? '';
$email     = $_SESSION['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName  = trim($_POST['last_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $userId    = $_SESSION['user_id'];

    if ($firstName === '' || $lastName === '' || $email === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        
        $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        $stmt->bind_param("si", $email, $userId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already in use.";
        } else {
            
            $stmt = $mysqli->prepare("UPDATE users SET first_name=?, last_name=?, email=? WHERE user_id=?");
            $stmt->bind_param("sssi", $firstName, $lastName, $email, $userId);
            if ($stmt->execute()) {
                $_SESSION['first_name'] = $firstName;
                $_SESSION['last_name']  = $lastName;
                $_SESSION['email']      = $email;
                $success = "Profile updated successfully!";
            } else {
                $error = "Update failed.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- same CSS as dashboard -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">
    <div class="card p-4 shadow-sm" style="max-width:500px; width:100%;">
        <h4 class="mb-3">Edit Profile</h4>
        <p>Update your name and email address.</p>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
        </form>

        <!-- Messages -->
        <?php if(isset($error)) echo "<p class='text-danger mt-3'>$error</p>"; ?>
        <?php if(isset($success)) echo "<p class='text-success mt-3'>$success</p>"; ?>
    </div>
</body>
</html>
