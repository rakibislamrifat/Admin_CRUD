<?php
require '../config/db.php';

$id = $_GET['id'];

// Use MySQLi query to get the order details
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id); 
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {  
    $order_name = $_POST['order_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "../uploads/$image_name");
    } else {
        $image_name = $order['image'];
    }

    // Update the database with the new data
    $query = "UPDATE orders SET image = ?, order_name = ?, quantity = ?, price = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssddi', $image_name, $order_name, $quantity, $price, $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input[type="file"],
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
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

        .image-preview {
            display: block;
            margin: 10px auto;
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Order</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Current Image:</label><br>
            <img src="../uploads/<?= $order['image'] ?>" class="image-preview"><br>

            <label>Change Image (optional):</label><br>
            <input type="file" name="image"><br>

            <label>Order Name:</label><br>
            <input type="text" name="order_name" value="<?= htmlspecialchars($order['order_name']) ?>" required><br>

            <label>Quantity:</label><br>
            <input type="number" name="quantity" value="<?= $order['quantity'] ?>" required><br>

            <label>Price:</label><br>
            <input type="number" step="0.01" name="price" value="<?= $order['price'] ?>" required><br>

            <button type="submit" name="submit">Update Order</button>
        </form>
        <a href="index.php" class="back-link">Back to Orders</a>
    </div>
</body>
</html>
