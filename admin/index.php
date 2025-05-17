<?php
session_start();
require '../config/db.php';
// load user from database
$user = $_SESSION['user'];

if (!isset($conn)) {
    die("Database connection failed");
}

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch all orders from the database using MySQLi
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$orders = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
} else {
    die("Query failed: " . mysqli_error($conn));
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Orders</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .logout-button {
        background-color: #e74c3c;
        color: white;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .logout-button:hover {
        background-color: #c0392b;
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

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td img {
            width: 60px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            margin: 0 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .actions a {
            padding: 8px 15px;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
        }

        .actions a:hover {
            background-color: #45a049;
        }

        .add-new {
            text-align: center;
            margin-top: 20px;
        }

        .home-button-container {
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-bar">
            <h1>Admin Dashboard</h1>
            <a href="../auth/logout.php" class="logout-button">Logout</a>
        </div>
        <div class="add-new">
            <a href="create.php" class="actions">+ Add New Order</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><img src="../uploads/<?= $order['image'] ?>"
                                alt="<?= htmlspecialchars($order['order_name']) ?>"></td>
                        <td><?= htmlspecialchars($order['order_name']) ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td>$<?= number_format($order['price'], 2) ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $order['id'] ?>">Edit</a>
                            <a href="delete.php?id=<?= $order['id'] ?>"
                                onclick="return confirm('Delete this order?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="home-button-container">
            <a href="../index.php" class="home-button">Go To Home</a>
        </div>
    </div>
</body>

</html>