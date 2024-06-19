<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'name';
$order = $_GET['order'] ?? 'ASC';

// Проверка входных параметров
if (!in_array($sort, ['name', 'date', 'price', 'place']) || !in_array($order, ['ASC', 'DESC'])) {
    die("Invalid sort or order parameter");
}

// Подготовка и выполнение запроса
$sql = "SELECT id, name, date, price, place FROM products 
        WHERE name LIKE ? OR place LIKE ?
        ORDER BY $sort $order";

$stmt = $conn->prepare($sql);
$searchTerm = '%' . $search . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($products, JSON_PRETTY_PRINT);
?>