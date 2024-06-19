
<?php
session_start();
include('db_products.php'); // Подключаем файл для работы с базой данных товаров

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Получаем все товары из базы данных
$query = "SELECT * FROM products";
$result = mysqli_query($conn_products, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All stuff</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>All stuff</h1>
        <div class="nav-buttons">
                    <a href="index.php">Home</a>
                    <a href="search.html">Search</a>
                    <a href="aboutus.html">About Us</a>
                    <a href="cart.php" class="view-cart-button">Your cart</a>
        </div>           
    </header>
    <div class="products">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="product">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['place']; ?></p>
                <p>Price: <?php echo $row['price']; ?> $.</p>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Add to cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>
