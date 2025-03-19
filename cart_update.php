<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"], $_POST["action"])) {
    $product_id = $_POST["product_id"];
    $action = $_POST["action"];

    if (isset($_SESSION["cart"][$product_id])) {
        if ($action === "increment") {
            $_SESSION["cart"][$product_id]++;
        } elseif ($action === "decrement") {
            if ($_SESSION["cart"][$product_id] > 1) {
                $_SESSION["cart"][$product_id]--;
            } else {
                unset($_SESSION["cart"][$product_id]); // Remove item if quantity reaches 0
            }
        }
    }
}

header("Location: cart_view.php");
exit();
?>
