<?php
session_start();
// load user from database
$user = $_SESSION['user'] ?? null;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CRUD Operation</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            margin-top: 50px;
        }

        p {
            font-size: 18px;
            color: #333;
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .links {
            margin-top: 30px;
            display: flex;
            gap: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome to the Order Management System</h1>
    <div class="links">
        <p><a <?php if($user) { ?> href="admin/index.php" <?php } else { ?> href="auth/login.php" <?php } ?>>Go to Admin Panel</a></p>
        <p><a href="user/index.php">View Orders as User</a></p>
    </div>
</div>
</body>
</html>
