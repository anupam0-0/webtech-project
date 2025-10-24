<?php
include "../config/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            echo "Login successful!";
            header('Location: ../index.php');
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background: #111
        }

        .login-container {
            padding: 2rem;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
            border-radius: 10px;
            /* text-align: center; */
            width: 500px;
            margin: 0 auto;
            margin-top: 22vh;
        }

        h2 {
            margin-bottom: 1.4rem;
            color: #ddd;
            text-align: center;

        }

        input {
            width: 100%;
            padding: 1rem;
            margin: 0.4rem 0;
            border: 1px solid #333;
            border-radius: 0.5rem;
            outline: none;
            font-size: 18px;
            background: #111;
            color: #eee;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background: #ddd;
            color: #222;
            border: 1px solid #333;
            border-radius: 0.5rem;
            margin: 0.6rem 0;
            cursor: pointer;
            font-size: 20px;

            /* font-family: monospace; */
            /* font-weight: 700; */
        }

        button:hover {
            background: #aaa;
        }

        a {
            display: block;
            margin-top: 10px;
            color: lightskyblue;
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
        <div class="login-container">
            <h2>Login</h2>
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
            <a href="signup.php">Signup</a>
            <a href="../index.php">Back to Home</a>
        </div>
    </form>

</body>

</html>