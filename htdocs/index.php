<?php
session_start();
include('db_products.php'); // Подключаем файл для работы с базой данных товаров

// Получаем все товары из базы данных
$query = "SELECT * FROM products";
$result = mysqli_query($conn_products, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Shop</title>
    <link rel="stylesheet" href="index.css">
</head>
<body class="background">
    <button class="report-button" onclick="showPopup()">Report</button>
    <div class="wrapper">
        <header>
            <div class="header-container">
                <h1>Welcome to the Ticket Shop!</h1>
                <p>Choose from a wide variety of events and buy tickets online.</p>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <a href="index.php">Home</a>
                    <a href="registerin.php">Registration</a>
                    <a href="loginin.php">Log in</a>
                    <a href="search.html">Search</a>
                    <a href="aboutus.html">About Us</a>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="iiex.php">All tickets</a>
                        <a href="logout.php">Logout</a>
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?>
                            <a href="admin.php">Admin Panel</a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </header>

        <main>
            <section class="featured-events-section">
                <div class="container featured-events-container">
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="event-card">
                            <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                            <h3><?php echo $row['name']; ?></h3>
                            <p><?php echo $row['place']; ?></p>
                            <p>Date: <?php echo $row['date']; ?> | Price: <?php echo $row['price']; ?> $.</p>
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <form action="add_to_cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="buy-ticket-button">Buy ticket</button>
                                </form>
                            <?php } else { ?>
                                <button class="buy-ticket-button" onclick="alert('Please register or sign in to purchase.');">Buy ticket</button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </main>
        
        <footer>
            <div class="container">
                <p>&copy; 2024 Ticket Shop</p>
            </div>
        </footer>
    </div>

     <!-- Pop-up form -->
     <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Let us call you</h2>
            <p>Leave your number and we will call you back</p>
            <form id="callbackForm">
                <label for="phoneNumber">Your phone number*</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" required>
                <button type="submit">I am waiting for a call</button>
                <p>Call back now | <a href="#" id="chooseTimeLink">Choose a convenient time</a></p>
                <div id="timeSelection" style="display: none;">
                    <label for="preferredTime">Choose a convenient time</label>
                    <input type="time" id="preferredTime" name="preferredTime">
                </div>
                <p>You agree to the processing of personal data.</p>
            </form>            
        </div>
    </div>

    <script src="scripts.js"></script>

    <script>
        function navigateToEvent(eventPage) {
            window.location.href = eventPage;
        }
    </script>
</body>
</html>
