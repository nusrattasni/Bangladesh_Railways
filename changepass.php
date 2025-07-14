<?php
session_start();
// you can check if user is logged in, for example:
// if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password - Bangladesh Railways</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            font-family: Arial, sans-serif;
            color: white;
        }
        .changepass-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .changepass-box {
            background-color: rgba(0,0,0,0.7);
            padding: 2rem;
            border-radius: 10px;
            width: 300px;
        }
        .changepass-box h2 {
            text-align: center;
        }
        .changepass-box input {
            width: 100%;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 5px;
            border: none;
        }
        .changepass-box button {
            width: 100%;
        }
    </style>
    

</head>
<body>
    <div class="changepass-center">
        <div class="changepass-box">
            <h2>Change Password</h2>
            <form action="changepass_process.php" method="POST">
                <label for="currentPassword">Current Password:</label>
                <input type="password" name="currentPassword" id="currentPassword" required>

                <label for="newPassword">New Password:</label>
                <input type="password" name="newPassword" id="newPassword" required>

                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required>

                <button type="submit" class="btn">Change Password</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>

</body>
</html>
