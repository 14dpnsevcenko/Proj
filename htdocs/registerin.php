<?php
session_start();
include('db.php'); // Подключаем файл для работы с базой данных пользователей

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверка на существование пользователя
    $check_query = "SELECT * FROM users WHERE email='$email'";
    $check_result = mysqli_query($conn_users, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Пользователь с таким email уже существует";
    } else {
        // Вставка нового пользователя в базу данных
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn_users, $query)) {
            $_SESSION['user_id'] = mysqli_insert_id($conn_users);
            $_SESSION['username'] = $name;
            header('Location: iiex.php');
            exit();
        } else {
            $error = "Ошибка при регистрации пользователя";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Register</h1>
            <!-- Navigation Buttons -->
            <div class="nav-buttons">
                <a href="index.php">Home</a>
                <a href="loginin.php">Sing In</a>
            </div>
        </div>
    </header>

    <main>
        <div class="RegForm">
            <div class="form-box">
                <h1 id="title">Sign Up</h1>
                <form action="register.php" method="post" id="registrationForm">
                    <div class="input-group">
                        <div class="input-field" id="nameField">
                            <i class="fa-solid fa-circle-user"></i>
                            <input type="text" name="name" placeholder="Name" required>
                        </div>
                        <div class="input-field">
                            <i class="fa-solid fa-inbox"></i>
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-field">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="btn-field">
                        <button type="submit" id="signupBtn">Sign Up</button>
                    </div>
                </form>

                <?php if (isset($error)) { echo "<div id='registrationMessage'>$error</div>"; } ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Ticket Shop</p>
        </div>
    </footer>
</body>
</html>
