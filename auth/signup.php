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
            header('Location: login.php');
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            position: relative;
            top: -7rem;
        }

        .signup-container {
            background: white;
            padding: 2rem;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
            border-radius: 10px;
            text-align: center;
            width: 500px;
            margin:0 auto;
            margin-top: 22vh;
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        input {
            width: 100%;
            padding: 1rem;
            margin: 0.4rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            font-size: 18px;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background: #222;
            color: white;
            border: none;
            margin-top: 0.4rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px;
            transition: background 0.3s;
        }

        button:hover {
            background: #000;
        }

        a {
            display: block;
            color: #007bff;
            margin: 0.4rem 0;
            text-decoration: none;
            font-size: 16px;
            text-align: right;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form action="" method="POST">
        <div class="signup-container">
            <h2>Signup</h2>
            <input type="text" name="name" required placeholder="Full Name">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Signup</button>
            <a href="login.php">Login</a>
            <a href="../index.php">Back to Home</a>
        </div>
    </form>

</body>
</html>
