<?php
require '../config/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $stmt = $pdo->prepare("UPDATE orders SET image = ?, order_name = ?, quantity = ?, price = ? WHERE id = ?");
    $stmt->execute([$image_name, $order_name, $quantity, $price, $id]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
</head>
<body>
    <h2>Edit Order</h2>
    <form method="POST" enctype="multipart/form-data">
        <p>Current Image:</p>
        <img src="../uploads/<?= $order['image'] ?>" width="100"><br><br>

        <label>Change Image (optional):</label><br>
        <input type="file" name="image"><br><br>

        <label>Order Name:</label><br>
        <input type="text" name="order_name" value="<?= htmlspecialchars($order['order_name']) ?>" required><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" value="<?= $order['quantity'] ?>" required><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="<?= $order['price'] ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
    <a href="index.php">Back</a>
</body>
</html>
