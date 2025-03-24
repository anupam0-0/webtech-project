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
                            <span class="wishlist-price">₹ <?php echo $product["price"]; ?></span>
                        </div>

                        <!-- we can't add item directly into cart 'cause the user hasnt't chose the size  -->
                         <!-- so instead we redirect user to the product page so that he/she can chose th size -->
                          <!-- WE WOULD CHANGE IT LATER -->
                        <div class="button-container">
                            <!-- <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                <a href="submit" class="add-to-cart-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>    
                                <p>Select</p></a>
                            </form> -->
                            <div>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="add-to-cart-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>    
                                <p>Select</p>
                            </a>


   
                            </div>

                            <form action="wishlist_remove.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                <button type="submit" class="remove-btn">Remove </button>
                            </form>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>

</body>

</html>