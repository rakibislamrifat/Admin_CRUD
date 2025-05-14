<?php
require '../config/db.php';

// Query to get all orders
$query = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

$orders = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td img {
            width: 50px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
        .home-button-container {
            text-align: center; 
            margin-top: 20px;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            margin: 0 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Orders List</h1>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Order Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><img src="../uploads/<?= htmlspecialchars($order['image']) ?>" alt="<?= htmlspecialchars($order['order_name']) ?>"></td>
                    <td><?= htmlspecialchars($order['order_name']) ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td>$<?= number_format($order['price'], 2) ?></td>
                    <td><?= date('Y-m-d H:i:s', strtotime($order['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="home-button-container">
            <a href="../index.php" class="home-button">Go To Home</a>
        </div>
</body>
</html>
