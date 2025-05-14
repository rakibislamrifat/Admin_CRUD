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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input[type="file"],
        input[type="text"],
        input[type="number"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="file"] {
            border: none;
            padding: 5px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            font-size: 16px;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Order</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="image">Image:</label>
            <input type="file" name="image" required>

            <label for="order_name">Order Name:</label>
            <input type="text" name="order_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required>

            <button type="submit" name="submit">Create</button>
        </form>
        <a href="index.php" class="back-link">Back to Orders</a>
    </div>
</body>
</html>
