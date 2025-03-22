<?php
include "config/db.php";
session_start();

$sql = "SELECT * FROM products LIMIT 3";
$result = $conn->query($sql);
function fetchProductsByBrand($conn, $brand)
{
    $sql = "SELECT * FROM products WHERE brand = '$brand' LIMIT 4";
    return $conn->query($sql);
}

$ferrariProducts = fetchProductsByBrand($conn, "ferrari");
$mercedesProducts = fetchProductsByBrand($conn, "mercedes");
$redbullProducts = fetchProductsByBrand($conn, "redbull");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>E-Commerce Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- <h1>Welcome to Our Store <span style="display:none"  >,  <?php echo $_SESSION["user_name"]; ?> </span>!</h1> -->
    <!-- <a href="cart_view.php">🛒 View Cart</a>
    <a href="wishlist_view.php">❤️ View Wishlist</a>
    <a href="dashboard.php">Dashboard</a> -->

    <div class="f1-banner-div">
        <img class="f1-banner" src="images/f1banner.svg" alt="f1-banner">
    </div>

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


    <div class="shopby-teams">
        <a href="products.php">
            <img class="f1-teams-img" src="images/shopbyteams2.png" alt="f1-teams">
        </a>
    </div>


    <div class="categories">
        <h2>Ferrari Collection</h2>
        <div class="products-grid">
            <?php while ($row = $ferrariProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/<?php echo $row['image']; ?>" alt="Ferrari Product">
                    <p><strong><?php echo $row['name']; ?></strong></p>
                    <p>Price: $<?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>

                </div>
            <?php } ?>
        </div>

        <h2>Mercedes Collection</h2>
        <div class="products-grid">
            <?php while ($row = $mercedesProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/<?php echo $row['image']; ?>" alt="Mercedes Product">
                    <p><strong><?php echo $row['name']; ?></strong></p>
                    <p>Price: $<?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>

                </div>
            <?php } ?>
        </div>

        <h2>Red Bull Collection</h2>
        <div class="products-grid">
            <?php while ($row = $redbullProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/<?php echo $row['image']; ?>" alt="Red Bull Product">
                    <p><strong><?php echo $row['name']; ?></strong></p>
                    <p>Price: $<?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>