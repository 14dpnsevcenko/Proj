<?php
// Start the session if not already started
if (!session_id()) {
    session_start();
}

// Include database configuration files
include('db_products.php');
include('db.php');

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login or set a default behavior
    echo "<p>Для просмотра корзины необходимо авторизоваться. Пожалуйста, <a href='loginin.php'>войдите</a>.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = isset($_SESSION['cart'][$user_id]) ? $_SESSION['cart'][$user_id] : array();
$total = 0;


if (is_array($cart) && count($cart) > 0) {
    $ids = implode(',', $cart);
    $query = "SELECT * FROM products WHERE id IN ($ids)";
    $result = mysqli_query($conn_products, $query);
} else {
    $result = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>Your cart</h1>
        <!-- Navigation Buttons -->
        <div class="nav-buttons">
                    <a href="index.php">Home</a>
                    <a href="search.html">Search</a>
                    <a href="aboutus.html">About Us</a>
                    <a href="iiex.php" class="view-cart-button">Back to purshare</a>
        </div>            
    </header>
    <div class="cart">
        <?php if (is_array($cart) && count($cart) > 0) {?>
            <?php while($row = mysqli_fetch_assoc($result)) {?>
                <div class="cart-item">
                    <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                    <p><?php echo htmlspecialchars($row['place']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($row['price']); ?> $.</p>
                    <?php $total += $row['price'];?>
                    <form action="remove_from_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <button type="submit">Delete from cart</button>
                    </form>
                </div>
            <?php }?>
            <h3>Total: <?php echo $total;?> $.</h3>
        <?php } else {?>
            <h1>Your cart empty</h1>
        <?php }?>
    </div>
</body>
</html>
