<?php
require '../config/db.php';

if (isset($_POST['submit'])) {
    $order_name = mysqli_real_escape_string($conn, $_POST['order_name']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];

        // Define upload directory
        $upload_dir = "../uploads/";

        // Check if directory exists, create if not
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory with proper permissions
        }

        // Define upload path
        $upload_path = $upload_dir . $image_name;

        // Move uploaded image to the uploads folder
        if (move_uploaded_file($tmp_name, $upload_path)) {
            // Insert order data into the database
            $sql = "INSERT INTO orders (image, order_name, quantity, price) 
                    VALUES ('$image_name', '$order_name', $quantity, $price)";

            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
                exit;
            } else {
                echo "Error inserting data: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Image file is required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Order</title>
</head>
<body>
    <h2>Create Order</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Image:</label><br>
        <input type="file" name="image" required><br><br>

        <label>Order Name:</label><br>
        <input type="text" name="order_name" required><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" required><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <button type="submit" name="submit">Create</button>
    </form>
    <a href="index.php">Back</a>
</body>
</html>
