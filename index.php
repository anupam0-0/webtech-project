<?php
include "config/db.php";
session_start();

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce Home</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- <style>
        body {
            background-color: #eee;
        }
    </style> -->


</head>
<body>

    <h1>Welcome to Our Store <span style="display:none"  >,  <?php echo $_SESSION["user_name"]; ?> </span>!</h1>
    <!-- <a href="cart_view.php">🛒 View Cart</a>
    <a href="wishlist_view.php">❤️ View Wishlist</a>
    <a href="dashboard.php">Dashboard</a> -->


    <div class="products">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="product">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h3><?php echo $row['name']; ?></h3>
                <p>₹<?php echo $row['price']; ?></p>
                <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
            </div>
        <?php } ?>
    </div>

</body>
</html>
