<?php include 'db.php'; ?>

<h2>Register</h2>

<form method="POST">
    First Name: <input type="text" name="fname"><br><br>
    Last Name: <input type="text" name="lname"><br><br>
    Email: <input type="text" name="email"><br><br>
    Username: <input type="text" name="username"><br><br>
    Password: <input type="password" name="password"><br><br>

    <button type="submit" name="register">Register</button>
</form>

<?php
if(isset($_POST['register'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (first_name,last_name,email,username,password)
            VALUES ('$fname','$lname','$email','$username','$password')";

    if($conn->query($sql)){
        echo "Registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>