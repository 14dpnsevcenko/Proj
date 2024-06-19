<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

// Создание соединения
$conn_products = mysqli_connect($servername, $username, $password, $dbname);

// Проверка соединения
if (!$conn_products) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
