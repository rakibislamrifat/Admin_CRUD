<?php
include '../config/db.php';
session_start();

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['password'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            header("Location: ../admin/index.php");
            
            exit;
        } else {
            $login_error = "Invalid email or password.";
        }
    } else {
        $login_error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            color: white;
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
            border-color: #764ba2;
            outline: none;
        }

        .auth-form input[type="email"],
        .auth-form input[type="password"] {
            background-color: #f9f9f9;
        }

        .auth-form button {
            padding: 14px;
            width: 100%;
            background-color: #667eea;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .auth-form button:hover {
            background-color: #764ba2;
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
            color: #667eea;
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
    <h2>Login</h2>
    
    <?php if ($login_error): ?>
        <div class="error"><?= htmlspecialchars($login_error); ?></div>
    <?php endif; ?>

    <form method="POST" class="auth-form">
        <input type="email" name="email" placeholder="Email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<footer>
    <p>&copy; <?= date("Y"); ?> Your Website. All rights reserved.</p>
</footer>

</body>
</html>