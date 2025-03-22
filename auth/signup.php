<?php
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encrypt password

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "Email already registered!";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Signup successful!";
            header('Location: /ecommerce/auth/login.php');
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<style>
    body {
        position: relative;
        top: -4.5rem;
    }
</style>

<form action="" method="POST">
    <h2>Signup</h2>
   
    <input type="text" name="name" required placeholder="Full Name">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit">Signup</button>
    <a href="login.php">Login</a>
    <a href="../index.php">Back to Home</a>

</form>
