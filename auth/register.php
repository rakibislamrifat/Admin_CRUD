<?php
include '../config/db.php';
session_start();

$username = '';
$email = '';
$error = '';

// Create the users table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

$conn->query($createTableSQL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if email already exists
        $check_sql = "SELECT id FROM users WHERE email = '$email'";
        $result = $conn->query($check_sql);

        if ($result && $result->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            $sql = "INSERT INTO users (username, email, password) 
                    VALUES ('$username', '$email', '$password')";

            if ($conn->query($sql)) {
                $_SESSION['user'] = $username;
                header("Location: ../index.php");
                exit;
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    } else {
        $error = "Please fill out all fields.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .container {
            background-color: #fff;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        .container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
            font-weight: 600;
        }

        .auth-form input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .auth-form input:focus {
            border-color: #2575fc;
            outline: none;
        }

        .auth-form input[type="email"],
        .auth-form input[type="password"] {
            background-color: #f9f9f9;
        }

        .auth-form button {
            padding: 14px;
            width: 100%;
            background-color: #2575fc;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .auth-form button:hover {
            background-color: #1d63d7;
        }

        .auth-form button:focus {
            outline: none;
        }

        .error {
            color: #e74c3c;
            margin-bottom: 20px;
            font-size: 14px;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 6px;
        }

        a {
            color: #2575fc;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            font-size: 14px;
            margin-top: 20px;
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #fff;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px;
                max-width: 90%;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>
    
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" class="auth-form">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username); ?>" required />
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email); ?>" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Register</button>
    </form>
    
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<footer>
    <p>&copy; <?= date("Y"); ?> Your Website. All rights reserved.</p>
</footer>

</body>
</html>