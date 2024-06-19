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

// Проверяем, загружен ли файл
if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image = $_FILES['image'];
    $image_name = basename($image['name']);
    $target_dir = "images/";
    $target_file = $target_dir . $image_name;
    
    // Проверяем тип файла
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $valid_types = array("jpg", "jpeg", "png", "gif");
    
    if(in_array($imageFileType, $valid_types)) {
        // Перемещаем загруженный файл в папку
        if(move_uploaded_file($image['tmp_name'], $target_file)) {
            echo "The file ". htmlspecialchars($image_name). " has been uploaded.";
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    } else {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }
} else {
    die("No file uploaded or there was an error uploading the file.");
}

// Получаем данные из формы
$name = $_POST['name'];
$date = $_POST['date'];
$price = $_POST['price'];
$place = $_POST['place'];

// SQL-запрос для добавления данных в таблицу
$sql = "INSERT INTO products (name, date, price, place, image) VALUES ('$name', '$date', '$price', '$place', '$image_name')";

if ($conn->query($sql) === TRUE) {
    echo "New product added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="index.css">
</head>
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
</html>
