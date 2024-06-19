
<?php
session_start();
include('db_products.php'); // Подключаем файл для работы с базой данных товаров

if (!isset($_SESSION['user_id'])) {
    header('Location: loginin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    if (!isset($_SESSION['cart'][$user_id])) {
        $_SESSION['cart'][$user_id] = array();
    }

    // Добавляем товар в корзину
    if (!in_array($product_id, $_SESSION['cart'][$user_id])) {
        $_SESSION['cart'][$user_id][] = $product_id;
    }
}

header('Location: index.php');
exit();
?>
