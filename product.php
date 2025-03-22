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

// Fetch reviews for this product
$review_sql = "SELECT users.name, reviews.rating, reviews.review, reviews.review_date 
               FROM reviews 
               JOIN users ON reviews.user_id = users.id 
               WHERE reviews.product_id = $product_id 
               ORDER BY reviews.review_date DESC";
$reviews = $conn->query($review_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $product["name"]; ?></title>
    <link rel="stylesheet" href="css/product.css">
</head>

<body>
    <section>
        <h1><?php echo $product["name"]; ?></h1>
        <div class="product-detail">
            <div class="left-main">


                <img src="images/<?php echo $product["image"]; ?>" alt="<?php echo $product["name"]; ?>">
            </div>

            <div class="right-main">

                <form action="wishlist_add.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                    <button type="submit">Add to Wishlist ❤️</button>
                </form>

                <p><?php echo $product["description"]; ?></p>
                <h3>Price: $<?php echo $product["price"]; ?></h3>



                <form action="cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                    <label for="size">Size:</label>
                    <select class="size-select" name="size" id="size" required>
                        <option value="default">Default</option>
                        <option value="s">S</option>
                        <option value="m">M</option>
                        <option value="l">L</option>
                        <option value="xl">XL</option>
                    </select> <br>
                    <button type="submit">Add to Cart</button>
                </form>

                <h3>Reviews:</h3>
                <?php if ($reviews->num_rows > 0) { ?>
                    <ul style="list-style-type: none;">
                        <?php while ($row = $reviews->fetch_assoc()) { ?>
                            <li>
                                <strong><?php echo $row["name"]; ?></strong> ⭐<?php echo $row["rating"]; ?>/5 <br>
                                <?php echo $row["review"]; ?> <br>
                                <small><?php echo $row["review_date"]; ?></small>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>No reviews yet. Be the first to review!</p>
                <?php } ?>

                <?php if (isset($_SESSION["user_id"])) { ?>
                    <h3>Leave a Review:</h3>
                    <form action="add_review.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <label for="rating">Rating (1-5):</label>
                        <select name="rating" id="rating">
                            <option value="1">⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select> <br>
                        <label for="review">Review:</label> <br>
                        <textarea name="review" id="review" cols="30" rows="10" required></textarea><br>
                        <button type="submit">Submit Review</button>
                    </form>
                <?php } ?>



                <a href="index.php">Back to Home</a>
            </div>
        </div>
    </section>

</body>

</html>