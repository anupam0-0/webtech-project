<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"]) && isset($_POST["size"])) {
    $product_id = $_POST["product_id"];
    $size = $_POST["size"];

    // If the cart session does not exist, create it
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    $key = (string)$product_id . "_" . $size; // Unique key

    if (isset($_SESSION["cart"][$key])) {
        $_SESSION["cart"][$key]["quantity"] += $quantity; // Increment if exists
    } else {
        $_SESSION["cart"][$key] = [
            "id" => $product_id,
            "size" => $size,
            "quantity" => 1
        ];
    }

    // // Add product to the cart (or increase quantity)
    // if (isset($_SESSION["cart"][$product_id][$size])) {
    //     $_SESSION["cart"][$product_id][$size]++;
    // } else {
    //     $_SESSION["cart"][$product_id][$size] = 1;
    // }

    header("Location: cart_view.php"); // Redirect to cart page
    exit();
}
?>

