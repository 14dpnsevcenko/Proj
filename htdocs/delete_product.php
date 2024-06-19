<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Проверка наличия идентификатора
if (!$id) {
    $message = "Invalid ID";
} else {
    // Получение текущего изображения для удаления
    $query = "SELECT image FROM products WHERE id='$id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_image = $row['image'];

        // SQL-запрос для удаления данных из таблицы
        $sql = "DELETE FROM products WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            // Проверка существования файла изображения перед удалением
            $image_path = "images/" . $current_image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $message = "Product deleted successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Product not found";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<header>
    <div class="header-container">
        <h1>Admin Panel</h1>
        <div class="nav-buttons">
            <a href="index.php">Home</a>
            <a href="admin.php">Admin</a>
            <a href="add_product.html">Back</a>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
