<?php
include "config/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$cart_items = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

$products = [];
if (!empty($cart_items)) {
    $ids = implode(",", array_keys($cart_items));
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $row["quantity"] = $cart_items[$row["id"]];
        $products[] = $row;
    }
}

// If cart is empty, prevent checkout
if (empty($products)) {
    die("<p>Your cart is empty. <a href='index.php'>Shop Now</a></p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h2>Checkout</h2>

    <form action="place_order.php" method="POST">
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php 
            $total_price = 0;
            foreach ($products as $product) { 
                $total = $product["price"] * $product["quantity"];
                $total_price += $total;
            ?>
                <tr>
                    <td><?php echo $product["name"]; ?></td>
                    <td><?php echo $product["quantity"]; ?></td>
                    <td>$<?php echo $total; ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3>Total Price: $<?php echo $total_price; ?></h3>

        <label for="address">Shipping Address:</label>
        <input type="text" name="address" required>

        <button type="submit">Place Order</button>
    </form>

</body>
</html>
