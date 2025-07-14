<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Bangladesh Railway</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-box {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 12px;
            color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            max-width: 400px;
            width: 100%;
            margin-top: 80px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-box label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
        }

        .login-box input[type="email"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: none;
            box-sizing: border-box;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #0056b3;
        }

        .login-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 100px);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }

        .login-links {
            margin-top: 15px;
            text-align: center;
        }

        .login-links a {
            color: #00bfff;
            text-decoration: none;
            font-size: 14px;
        }

        .login-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-center">
        <div class="login-box">
            <h2>Login</h2>

            <?php
            if (isset($_SESSION['login_error'])) {
                echo "<p class='error-message'>" . $_SESSION['login_error'] . "</p>";
                unset($_SESSION['login_error']);
            }
            ?>

            <form method="POST" action="login_process.php">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Login</button>
            </form>

            <div class="login-links">
                <a href="index.php">← Back to Home</a> |
                <a href="signup.php">Create Account</a>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>

</body>
</html>
