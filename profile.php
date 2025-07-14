<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "railway");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$query = "SELECT name, email, phone FROM users WHERE id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    $_SESSION['profile_error'] = "User not found.";
    header("Location: intro.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
        background: url('bg.jpg') no-repeat center center fixed;
        background-size: cover;
        color: white;
        font-family: Arial, sans-serif;
    }
    .profile-container {
        width: 400px;
        margin: 100px auto;
        background-color: rgba(0,0,0,0.6);
        padding: 2rem;
        border-radius: 10px;
    }
    .profile-field {
        margin-bottom: 1rem;
    }
    .btn {
        padding: 0.5rem 1rem;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        display: block;
        margin-top: 1rem;
        text-align: center;
        text-decoration: none;
    }
  </style>
</head>


<body>
  <div class="profile-container">
    <h2>Your Profile</h2>
    
    <?php
    if (isset($_SESSION['profile_error'])) {
        echo "<p style='color:red;'>".$_SESSION['profile_error']."</p>";
        unset($_SESSION['profile_error']);
    }
    ?>

    < class="profile-field"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></div>
    <div class="profile-field"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
    <div class="profile-field"><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></div>
  <!--<div class="profile-field"><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></div>

    <a href="edit_profile.php" class="btn">Edit Profile</a>
    <a href="changepass.php" class="btn">Change Password</a>
  </div>
  <?php include 'footer.php'; ?>

</body>
</html>
