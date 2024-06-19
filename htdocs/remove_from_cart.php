<?php
session_start();
include('db_products.php'); // Подключаем файл для работы с базой данных товаров

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    if (isset($_SESSION['cart'][$user_id])) {
        $key = array_search($product_id, $_SESSION['cart'][$user_id]);
        if ($key !== false) {
            unset($_SESSION['cart'][$user_id][$key]);
        }
    }
}

header('Location: cart.php');
exit();
?>
