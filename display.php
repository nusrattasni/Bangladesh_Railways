<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db_connection.php";

$id = $_SESSION['user_id'];

$query = "SELECT name, email, phone, address FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Bangladesh Railways</title>
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
            font-family: Arial, sans-serif;
            color: white;
        }
        .profile-display {
            background-color: rgba(0,0,0,0.7);
            padding: 2rem;
            border-radius: 10px;
            width: 300px;
            margin: 5rem auto;
            text-align: center;
        }
        .profile-display h2 {
            margin-bottom: 1rem;
        }
        .profile-display p {
            margin: 0.5rem 0;
        }
        .profile-display a {
            display: inline-block;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="profile-display">
        <h2>Profile</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        <a href="index.php" class="btn">Back to Home</a>
    </div>
    <?php include 'footer.php'; ?>

</body>
</html>
