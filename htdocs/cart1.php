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
    
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = isset($_SESSION['cart'][$user_id])? $_SESSION['cart'][$user_id] : array();
$total = 0;

if (count($cart) > 0) {
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
    <title>Корзина</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>Ваша корзина</h1>
        <nav>
            <a href="index.php" class="view-cart-button">Вернуться к покупкам</a>
        </nav>
    </header>
    <div class="cart">
        <?php if (count($cart) > 0) {?>
            <?php while($row = mysqli_fetch_assoc($result)) {?>
                <div class="cart-item">
                    <h2><?php echo $row['name'];?></h2>
                    <p><?php echo $row['place'];?></p>
                    <p>Цена: <?php echo $row['price'];?> руб.</p>
                    <?php $total += $row['price'];?>
                    <form action="remove_from_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id'];?>">
                        <button type="submit">Удалить из корзины</button>
                    </form>
                </div>
            <?php }?>
            <h3>Итого: <?php echo $total;?> руб.</h3>
        <?php } else {?>
            <p>Ваша корзина пуста</p>
        <?php }?>
    </div>
</body>
</html>
