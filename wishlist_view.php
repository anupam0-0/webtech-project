<?php
include "config/db.php";
session_start();

$wishlist_items = isset($_SESSION["wishlist"]) ? $_SESSION["wishlist"] : [];

$products = [];
if (!empty($wishlist_items)) {
    $ids = implode(",", array_map('intval', $wishlist_items)); // Ensure IDs are safe
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Wishlist</title>
    <link rel="stylesheet" href="css/wishlist.css">
</head>

<body>

    <div class="wishlist-container">
        <h2>Your Wishlist ❤️</h2>

        <?php if (empty($products)) { ?>
            <p class="empty-message">Your wishlist is empty.</p>
            <a href="index.php" class="continue-shopping">Continue Shopping</a>
        <?php } else { ?>
            <ul class="wishlist-list">
                <?php foreach ($products as $product) { ?>
                    <li class="wishlist-item">
                        <img src="images/<?php echo $product["image"]; ?>" class="wishlist-img">
                        <div class="wishlist-details">
                            <span class="wishlist-name"><?php echo $product["name"]; ?></span>
                            <span class="wishlist-price">$<?php echo $product["price"]; ?></span>
                        </div>

                        <form action="cart.php" method="POST" class="wishlist-buttons">
                            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                        </form>

                        <form action="wishlist_remove.php" method="POST" class="wishlist-buttons">
                            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                            <button type="submit" class="remove-btn">Remove </button>
                        </form>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>

</body>

</html>
