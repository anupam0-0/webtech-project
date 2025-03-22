<?php
include "config/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"]; // Ensure user is logged in
    $product_id = $_POST["product_id"];
    $rating = $_POST["rating"];
    $review = $_POST["review"];

    $sql = "INSERT INTO reviews (user_id, product_id, rating, review) 
            VALUES ($user_id, $product_id, $rating, '$review')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Review submitted successfully!";
        echo "<br>";
        echo "<a href='index.php'>Back to Home</a>";

    } else {
        echo "Error: " . $conn->error;
    }
}
?>
