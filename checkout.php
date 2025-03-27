<?php
include "config/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /ecommerce/auth/login.php");
    exit();
}

$cart_items = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

$products = [];
if (!empty($cart_items)) {
    $ids = [];

    // Extract product IDs only
    foreach (array_keys($cart_items) as $key) {
        $parts = explode("_", $key); // Splitting "6_m" into ["6", "m"]
        $ids[] = (int) $parts[0]; // Only store numeric ID
    }

    // Ensure IDs are unique to prevent duplicate queries
    $ids = array_unique($ids);
    $ids_1 = implode(",", $ids); // Convert array to string

    $sql = "SELECT * FROM products WHERE id IN ($ids_1)";
    $result = $conn->query($sql);

    $fetched_products = [];
    while ($row = $result->fetch_assoc()) {
        $fetched_products[$row["id"]] = $row;
    }

    // Now rebuild the cart based on actual user input
    foreach ($cart_items as $key => $value) {
        $parts = explode("_", $key);
        $product_id = (int) $parts[0];
        $size = $parts[1];

        if (isset($fetched_products[$product_id])) {
            $product = $fetched_products[$product_id]; // Get product details
            $product["size"] = $size; // Assign size
            $product["quantity"] = $value["quantity"]; // Assign user-selected quantity
            $products[] = $product; // Store in final array
        }
    }

    // debug
    // echo "<pre>";
    // var_dump($products);
    // echo "</pre>";



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
    <link rel="stylesheet" href="css/checkout.css">
</head>

<body>
    <main>
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
                        <td>₹ <?php echo $total; ?></td>
                    </tr>
                <?php } ?>
            </table>

            <div class="checkout-details">
                <h3>Total Price: ₹ <?php echo $total_price; ?></h3>

                <label for="address">Shipping Address:</label>
                <input type="text" name="address" required>

                <button type="submit">Place Order</button>
            </div>

        </form>
    </main>

</body>

</html>