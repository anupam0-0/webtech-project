<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
    $product_id = $_POST["product_id"];

    if (isset($_SESSION["wishlist"])) {
        $_SESSION["wishlist"] = array_diff($_SESSION["wishlist"], [$product_id]);
    }
}

header("Location: wishlist_view.php");
exit();
?>
