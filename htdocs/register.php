<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registerUser";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Подготовка и выполнение SQL-запроса для вставки данных в таблицу
    $stmt = $conn->prepare("INSERT INTO users (login, email, pass, is_admin) VALUES (?, ?, ?, ?)");
    $is_admin = false; // Обычный пользователь по умолчанию
    $stmt->bind_param("sssi", $login, $email, $password, $is_admin);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Закрытие соединения
$conn->close();
?>
