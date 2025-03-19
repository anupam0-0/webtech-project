<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
    $product_id = $_POST["product_id"];

    // Initialize wishlist if not set
    if (!isset($_SESSION["wishlist"])) {
        $_SESSION["wishlist"] = [];
    }

    // Add product to wishlist if not already added
    if (!in_array($product_id, $_SESSION["wishlist"])) {
        $_SESSION["wishlist"][] = $product_id;
    }

    header("Location: wishlist_view.php");
    exit();
}
?>
