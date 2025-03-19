<?php
include "config/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["address"])) {
    $address = $conn->real_escape_string($_POST["address"]);

    // Get cart items
    $cart_items = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];
    if (empty($cart_items)) {
        die("Your cart is empty.");
    }

    // Insert order into database
    $total_price = 0;
    foreach ($cart_items as $product_id => $quantity) {
        $sql = "SELECT price FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $total_price += $row["price"] * $quantity;
        }
    }

    $sql = "INSERT INTO orders (user_id, address, total_price) VALUES (1, '$address', '$total_price')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert order details
        foreach ($cart_items as $product_id => $quantity) {
            $conn->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $product_id, $quantity)");
        }

        // Clear cart after order is placed
        unset($_SESSION["cart"]);

        echo "<p>Order placed successfully! <a href='index.php'>Continue Shopping</a></p>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
