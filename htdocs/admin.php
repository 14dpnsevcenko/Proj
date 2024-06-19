<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Admin Panel</h1>
            <div class="nav-buttons">
                <a href="index.php">Home</a>
                <a href="add_product.html">Add Product</a>
                <a href="admin.php">Admin</a>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
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

            // SQL-запрос для получения данных из таблицы
            $sql = "SELECT id, name, date, price, place, image FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Выводим данные каждой строки с возможностью редактирования и удаления
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<h2>" . $row["name"] . "</h2>";
                    echo "<img src='images/" . $row["image"] . "' alt='" . $row["name"] . "'>";
                    echo "<p>Date: " . $row["date"] . "</p>";
                    echo "<p>Price: $" . $row["price"] . "</p>";
                    echo "<p>Place: " . $row["place"] . "</p>";
                    echo "<a href='edit_product.php?id=" . $row["id"] . "'>Edit</a> | ";
                    echo "<a href='delete_product.php?id=" . $row["id"] . "'>Delete</a>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            ?>
        </div>
    </main>
</body>
</html>
