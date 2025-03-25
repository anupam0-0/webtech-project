<?php
include "config/db.php";
session_start();

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


    // echo "<pre>";
    // var_dump($products);
    // echo "</pre>";



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
                        $total = (int) $product["price"] * (int) $product["quantity"];
                        $total_price += $total;
                        ?>
                        <tr class="product-row">
                            <td id="img-td"><img src="images/merch/<?php echo $product["image"]; ?>"
                                    alt="<?php echo $product["name"]; ?>"></td>
                            <td><?php echo $product["name"]; ?></td>
                            <td>₹ <?php echo $product["price"]; ?> </td>
                            <td><?php echo $product["size"]; ?></td>
                            </td>

                            <td class="quantity-td">
                                <form action="cart_update.php" method="POST" ">
                                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                    <input type="hidden" name="size" value="<?php echo $product["size"]; ?>">
                                    <button type="submit" name="action" value="decrement" style="text-decoration: none;" >-</button>
                                </form>

                                <div>
                                    <?php echo $product["quantity"]; ?>
                                </div>

                                <form action="cart_update.php" method="POST" ">
                                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                    <input type="hidden" name="size" value="<?php echo $product["size"]; ?>">
                                    <button type="submit" name="action" value="increment" style="text-decoration: none;"  >+</button>
                                </form>
                            </td>
                            <td>₹ <?php echo $total; ?></td>
                            <td>
                                <form action="cart_remove.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                    <input type="hidden" name="size" value="<?php echo $product["size"]; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <div class="total-container">
                    <div>

                    </div>

                    <div>
                        <div id="total-amt">
                            <h3>Total:</h3>
                            <h3>₹ <?php echo $total_price; ?></h3>
                        </div>

                        <div class="proceed-container">
                            <a href="checkout.php" class="proceed">Proceed to Checkout</a>
                            <a href="index.php" class="continue-shopping">Continue Shopping</a>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </main>

</body>

</html>