<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
    $product_id = $_POST["product_id"];

    // If the cart session does not exist, create it
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Add product to the cart (or increase quantity)
    if (isset($_SESSION["cart"][$product_id])) {
        $_SESSION["cart"][$product_id]++;
    } else {
        $_SESSION["cart"][$product_id] = 1;
    }

    header("Location: cart_view.php"); // Redirect to cart page
    exit();
}
?>
