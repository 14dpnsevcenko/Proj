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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $place = $_POST['place'];
    
    // Check if a new image is uploaded
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = basename($image['name']);
        $target_dir = "images/";
        $target_file = $target_dir . $image_name;
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $valid_types = array("jpg", "jpeg", "png", "gif");
        
        if(in_array($imageFileType, $valid_types)) {
            if(move_uploaded_file($image['tmp_name'], $target_file)) {
                // Retrieve current image to delete
                $query = "SELECT image FROM products WHERE id='$id'";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                $current_image = $row['image'];
                
                // Update database with new image
                $sql = "UPDATE products SET name='$name', date='$date', price='$price', place='$place', image='$image_name' WHERE id='$id'";
                
                if ($conn->query($sql) === TRUE) {
                    // Delete old image if exists
                    $old_image_path = $target_dir . $current_image;
                    if ($current_image && file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                    $message = "Product updated successfully";
                } else {
                    $message = "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        $sql = "UPDATE products SET name='$name', date='$date', price='$price', place='$place' WHERE id='$id'";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Product updated successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="index.css">
</head>
<header>
    <h1>Editor</h1>
    <!-- Navigation Buttons -->
    <div class="nav-buttons">
        <a href="index.php">Home</a>
        <a href="search.html">Search</a>
        <a href="admin.php">Admin Panel</a>
    </div>
</header>
<body>
    <div class="container">
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="edit_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            
            <label for="name">Event Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>
            
            <label for="date">Event Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($row['date']); ?>" required><br><br>
            
            <label for="price">Event Price:</label>
            <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required><br><br>
            
            <label for="place">Event Place:</label>
            <input type="text" id="place" name="place" value="<?php echo htmlspecialchars($row['place']); ?>" required><br><br>
            
            <label for="image">Event Image:</label>
            <input type="file" id="image" name="image" accept="image/*"><br><br>
            
            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
