<?php
include "config/db.php";
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>
    <main>

        <h1>Your Shopping Cart</h1>
        <div class="cart-container">

            <?php if (empty($products)) { ?>
                <p id="cart-empty-text">Your cart is empty.</p>
                <a href="index.php" id="continue-shopping-text">Continue Shopping</a>
            <?php } else { ?>
                <table>
                    <tr id="table-header">
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Sizes</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $total_price = 0;
                    foreach ($products as $product) {
                        $total = $product["price"] * $product["quantity"];
                        $total_price += $total;
                        ?>
                        <tr class="product-row">
                            <td id="img-td"><img src="images/<?php echo $product["image"]; ?>"
                                    alt="<?php echo $product["name"]; ?>"></td>
                            <td><?php echo $product["name"]; ?></td>
                            <td>$<?php echo $product["price"]; ?> </td>
                            <td><?php echo $product["size"]; ?></td>
                            </td>

                            <td>
                                <form action="cart_update.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                    <button type="submit" name="action" value="decrement">-</button>
                                </form>

                                <?php echo $product["quantity"]; ?>

                                <form action="cart_update.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                    <button type="submit" name="action" value="increment">+</button>
                                </form>
                            </td>
                            <td>$<?php echo $total; ?></td>
                            <td>
                                <form action="cart_remove.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <h3 id="total-amt">Total Price: $<?php echo $total_price; ?></h3>
                <div class="proceed-container">
                    <a href="checkout.php" class="proceed">Proceed to Checkout</a>
                    <a href="index.php" class="continue-shopping">Continue Shopping</a>

                </div>
            <?php } ?>
        </div>
    </main>

</body>

</html>