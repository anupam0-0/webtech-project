<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"], $_POST["size"], $_POST["action"])) {
    $product_id = $_POST["product_id"];
    $size = $_POST["size"];
    $action = $_POST["action"];

    // Create unique key (same as cart storage)
    $cart_key = $product_id . "_" . $size;


    if (isset($_SESSION["cart"][$cart_key])) {
        if ($action === "increment") {
            $_SESSION["cart"][$cart_key]["quantity"]++;
        } elseif ($action === "decrement") {
            if ($_SESSION["cart"][$cart_key]["quantity"] > 1) {
                $_SESSION["cart"][$cart_key]["quantity"]--;
            } else {
                unset($_SESSION["cart"][$cart_key]); // Remove if quantity becomes 0
            }
        }
    }
}

header("Location: cart_view.php");
exit();
?>