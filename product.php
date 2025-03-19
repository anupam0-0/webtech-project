<?php
include "config/db.php";
session_start();

if (!isset($_GET["id"])) {
    die("Product not found.");
}

$product_id = $_GET["id"];
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $product["name"]; ?></title>
    <link rel="stylesheet" href="css/product.css">
</head>

<body>

    <h2><?php echo $product["name"]; ?></h2>
    <div class="product-detail">
        <img src="images/<?php echo $product["image"]; ?>" alt="<?php echo $product["name"]; ?>">
        <p><?php echo $product["description"]; ?></p>
        <h3>Price: $<?php echo $product["price"]; ?></h3>

        <form action="wishlist_add.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
            <button type="submit">Add to Wishlist ❤️</button>
        </form>


        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
            <button type="submit">Add to Cart</button>
        </form>

        <a href="index.php">Back to Home</a>
    </div>

</body>

</html>