<?php
include "config/db.php";
session_start();

$sql = "SELECT * FROM collection";
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
    <title>F1 Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Main f1 banner -->
    <div class="f1-banner-div">
        <img class="f1-banner" src="images/redbull-banner.png" alt="f1-banner">
        <div class="banner-text">
            <h1>Your Ultimate Pit Stop for F1 Gear!</h1>
            <button>Shop Now</button>
        </div>
    </div>


    <div class="category-row">
        <a href="products.php">shop by team</a>
        <a href="products.php">shop by driver</a>
        <a href="products.php">men</a>
        <a href="products.php">women</a>
        <a href="products.php">kids</a>
        <a href="products.php">headwear</a>
        <a href="products.php">collectibles</a>
    </div>
    <!-- 
    IDEA DEPRECATED
    <div class="snoppy-f1">
            <img src="images/snoppyf1.jpg" alt="snoppy" height=>
    </div> 
-->

    <div class="collections">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="collection-items">
                <a href="products.php">
                    <img src="images/collection/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <!-- <h2><?php echo $row['name']; ?></h2> -->
                    <!-- <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a> -->
                </a>
            </div>
        <?php } ?>
    </div>

    <!-- shop by team banner -->
    <div class="shopby-teams">
        <a href="products.php">
            <img class="f1-teams-img" src="images/shopbyteams2.png" alt="f1-teams">
        </a>
    </div>



    <div class="categories">
        <!-- <div class="ferrari-banner">
            <img src="https://images.ctfassets.net/p85mj7v2zszd/1JSv5TriJ4QtuXisPSgPQX/4f884ed3189d6af58f00688f73621161/New_Hero_H1_D.jpg?w=2880&h=1406&fm=webp" alt="">

        </div> -->
        <h2>Ferrari Collection</h2>
        <div class="products-grid">
            <?php while ($row = $ferrariProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/merch/<?php echo $row['image']; ?>" alt="Ferrari Product">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₹ <?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
        <!-- <a href="products.php" style="text-decoration: none; width: fit-content; height: 1.9em; margin: 0 auto;">
            <button class="view-more">View More</button>
        </a> -->


        <h2>Mercedes Collection</h2>
        <div class="products-grid">
            <?php while ($row = $mercedesProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/merch/<?php echo $row['image']; ?>" alt="Mercedes Product">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₹ <?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
        <!-- <a href="products.php" style="text-decoration: none; width: fit-content; height: 1.9em; margin: 0 auto;">
            <button class="view-more">View More</button>
        </a> -->

        <h2>Red Bull Collection</h2>
        <div class="products-grid">
            <?php while ($row = $redbullProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/merch/<?php echo $row['image']; ?>" alt="Red Bull Product">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₹ <?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
        <!-- <a href="products.php" style="text-decoration: none; width: fit-content; height: 1.9em; margin: 0 auto;">
            <button class="view-more">View More</button>
        </a> -->
    </div>


    <footer>
        <!-- <div>hi</div> -->
        <img src="images/footer0.png" alt="footer" draggable="false">
        <img src="images/footer.png" alt="footer" draggable="false">
    </footer>
</body>

</html>