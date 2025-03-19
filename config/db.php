<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ecommerce";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database live! <br>";
    echo "<a href=\"index.php\">Back to Home</a>";

}
?>
