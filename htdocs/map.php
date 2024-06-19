
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>User Dashboard</h1>
            <div class="nav-buttons">
                <a href="index.html">Home</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>This is the user dashboard.</p>
        </div>
    </main>
</body>
</html>
