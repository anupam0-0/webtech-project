<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ecommerce";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
?>
    <nav style='
        color: white; 
        height: 4em; 
        padding: 0 4em;
        display:flex; align-items: center;
        justify-content: space-between; 
        gap: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.1)

    '>
    <div>
    <input type='text' placeholder='What you looking for?' 
        onfocus="this.style.border='0px';"
        style='width: 15rem; padding: 0.6em 1.8em; border-radius: 50px; outline: none; border:0px; background-color: #f5f5f5;'>
    </div> 
    <div>
        <a href="index.php"
            style='padding-right:6rem; font-size:1.8rem; font-weight:500; font-family:monospace; text-decoration: none; color: black;'
        > Jivilla
        </a>
    </div> 
    <div style='display:flex; gap: 1rem; '>
        <a href="/ecommerce/cart_view.php"
                style=' font-size:1.5rem; font-family:monospace; color: black; text-decoration: none; '
        > 👜</a>
        <a href="/ecommerce/wishlist_view.php"
                style=' font-size:1.5rem; font-family:monospace; color: black; text-decoration: none;'
        > ❤️</a>
        <a href="/ecommerce/dashboard.php"
                style=' font-size:1.5rem; font-family:monospace; color: black; text-decoration: none; '
        > 🤵</a>
    </div>
    </nav>
<?php
}
?>
