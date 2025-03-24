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
    <title>F1 Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Main f1 banner -->
    <form class="f1-banner-div">
        <img class="f1-banner" src="images/redbull-banner.png" alt="f1-banner">
    </form>

<!-- 
    IDEA DEPRECATED
    <div class="snoppy-f1">
            <img src="images/snoppyf1.jpg" alt="snoppy" height=>
    </div> 
-->

    <div class="products">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="product">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p>₹<?php echo $row['price']; ?></p>
                <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
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
                    <img src="images/<?php echo $row['image']; ?>" alt="Ferrari Product">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₹ <?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
        <button class="view-more">View More</button>


        <h2>Mercedes Collection</h2>
        <div class="products-grid">
            <?php while ($row = $mercedesProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/<?php echo $row['image']; ?>" alt="Mercedes Product">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₹ <?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
        <button class="view-more">View More</button>


        <h2>Red Bull Collection</h2>
        <div class="products-grid">
            <?php while ($row = $redbullProducts->fetch_assoc()) { ?>
                <div class="product">
                    <img src="images/<?php echo $row['image']; ?>" alt="Red Bull Product">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₹ <?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
        <button class="view-more">View More</button>

    </div>
</body>

</html>