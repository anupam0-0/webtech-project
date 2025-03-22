<?php
include "config/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Order History</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <main></main>

    <div class="dashboard-container">
        <h2>Order History 📜</h2>

        <?php if (isset($_GET["order_success"])) { ?>
            <p class="success-message">✅ Order placed successfully!</p>
        <?php } ?>

        <?php if ($result->num_rows == 0) { ?>
            <p>No orders placed yet.</p>
        <?php } else { ?>
            <table class="order-table">
                <tr>
                    <th>Order ID</th>
                    <th>Address</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                </tr>
                <?php while ($order = $result->fetch_assoc()) { ?>
                    <tr>
                        <td>#<?php echo $order["id"]; ?></td>
                        <td><?php echo $order["address"]; ?></td>
                        <td>$<?php echo $order["total_price"]; ?></td>
                        <td><?php echo $order["order_date"]; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>


    <div>

        <form action="auth/logout.php" method="POST">
            <label for="logout">Logout</label>
            <button type="submit" id="logout">Logout</button>
        </form>
    </div>



    </main>

</body>

</html>