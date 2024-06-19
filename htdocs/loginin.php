<?php
// Enable error reporting for development/testing
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include database configuration file
require_once('db.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!<br>";
}

$error = ''; // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Debugging input data
        var_dump($email, $password);

        if (empty($email) || empty($password)) {
            $error = "Email and password are required.";
        } else {
            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND pass = ?");
            if ($stmt === false) {
                $error = "Error in SQL query: " . $conn->error;
            } else {
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                // Debugging SQL query result
                if ($result->num_rows > 0) {
                    echo "User found!<br>";
                    $row = $result->fetch_assoc();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $row['login'];
                    $_SESSION['is_admin'] = $row['is_admin'];
                    $_SESSION['user_id'] = $row['id']; // Save user_id in session
                    $stmt->close();
                    $conn->close();
                    
                    if ($row['is_admin']) {
                        header("Location: admin.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit(); // Ensure the script stops after redirection
                } else {
                    echo "User not found!<br>";
                    $error = "Invalid email or password.";
                }

                $stmt->close();
            }
        }
    } else {
        $error = "Email and password are required.";
    }
}

// Закрытие соединения
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Login</h1>
            <!-- Navigation Buttons -->
            <div class="nav-buttons">
                <a href="index.php">Home</a>
                <a href="search.html">Search</a>
            </div>
        </div>
    </header>

    <main>
        <div class="RegForm">
            <div class="form-box">
                <h1 id="title">Sign In</h1>
                <form action="loginin.php" method="post" id="loginForm">
                    <div class="input-group">
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
                        <button type="submit" id="loginSubmitBtn">Login</button>
                    </div>
                </form>

                <?php if (!empty($error)) { echo "<div id='registrationMessage'>$error</div>"; } ?>
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
