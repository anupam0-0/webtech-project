<?php
include "config/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["address"])) {
    $user_id = (int) $_SESSION["user_id"];
    $address = $conn->real_escape_string($_POST["address"]);

    // Get cart items
    $cart_items = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];
    if (empty($cart_items)) {
        die("Your cart is empty.");
    }

    // Insert order into database
    $total_price = 0;
    $product_prices = [];

    foreach ($cart_items as $key => $item) {
        $parts = explode("_", $key); // Extract product ID and size
        $product_id = (int) $parts[0];
        $size = $parts[1];
        $quantity = (int) $item["quantity"];

        $sql = "SELECT price FROM products WHERE id = $product_id";
        $result = $conn->query($sql);

        if ($row = $result->fetch_assoc()) {
            $price = (float) $row["price"];
            $total_price += $price * $quantity;
            $product_prices[] = [
                "id" => $product_id,
                "size" => $size,
                "quantity" => $quantity,
                "price" => $price
            ];
        }
    }


    // Insert order into `orders` table
    $sql = "INSERT INTO orders (user_id, address, total_price) VALUES ($user_id, '$address', '$total_price')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert order details into `order_items` table
        foreach ($product_prices as $item) {
            $product_id = $item["id"];
            $size = $conn->real_escape_string($item["size"]);
            $quantity = $item["quantity"];
            $price = $item["price"];

            $conn->query("INSERT INTO order_items (order_id, product_id, size, quantity, price) 
                      VALUES ($order_id, $product_id, '$size', $quantity, $price)");
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