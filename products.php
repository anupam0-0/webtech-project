<?php
include "config/db.php";
session_start();

$category = isset($_GET['category']) ? $_GET['category'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$size = isset($_GET['size']) ? $_GET['size'] : '';

$sql = "SELECT * FROM products WHERE 1";
if ($category)
    $sql .= " AND category = '$category'";
if ($brand)
    $sql .= " AND brand = '$brand'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="css/products.css">
</head>

<body>
    <main>

        <h2>Shop Products</h2>

        <form method="GET" action="products.php" class="filter-form">
            <select name="category">
                <option value="">All Categories</option>
                <option value="tshirt">T-Shirt</option>
                <option value="cap">Cap</option>
                <option value="jacket">Jacket</option>
            </select>

            <select name="brand">
                <option value="">All Brands</option>
                <option value="redbull">Red Bull</option>
                <option value="ferrari">Ferrari</option>
                <option value="mclaren">McLaren</option>
                <option value="mercedes">Mercedes</option>
            </select>

            <button type="submit">Filter</button>
        </form>

        <div class="product-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/<?php echo $row['image']; ?>" alt="Product Image">
                    <p><strong><?php echo $row['name']; ?></strong></p>
                    <p>Price: ₹<?php echo $row['price']; ?></p>


                    <!-- we can't add item directly into cart 'cause the user hasnt't chose the size  -->
                    <!-- so instead we redirect user to the product page so that he/she can chose th size -->
                    <!-- WE WILL CHANGE IT LATER -->
                    <!-- <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Add to Cart</button>
                    </form> -->
                    <div class="button-container">
                        <a href="product.php?id=<?php echo $row['id']; ?>" class="add-to-cart-btn">
                            Add to Cart
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

</body>

</html>