<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to make a booking.");
}

$user_id = $_SESSION['user_id'];
$train_id = $_POST['train_id'] ?? 1; // replace with actual train id from form or selection
$journey_date = $_POST['date'] ?? '';
$seats = $_POST['tickets'] ?? 1;
$class = $_POST['class'] ?? '';

// Validate inputs here...

$conn = new mysqli("localhost", "root", "", "railway");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO booking (user_id, train_id, journey_date, seats, class, booked_at) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("iisis", $user_id, $train_id, $journey_date, $seats, $class);

if ($stmt->execute()) {
    echo "Booking saved successfully.";
} else {
    echo "Booking failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Booking Confirmation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      margin: 0;
      padding: 2rem;
      background-color: #f0f8ff;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      background: white;
      margin: auto;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }
    h2 {
      color: #007bff;
      text-align: center;
    }
    .info p {
      font-size: 1.1rem;
      margin: 0.6rem 0;
    }
    .btn {
      display: inline-block;
      padding: 0.7rem 1.5rem;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      margin-top: 2rem;
      text-align: center;
      transition: background-color 0.3s ease;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    .center {
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Reservation Confirmed</h2>

  <div class="info">
    <p><strong>Full Name:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>From:</strong> <?= htmlspecialchars($fromStation) ?></p>
    <p><strong>To:</strong> <?= htmlspecialchars($toStation) ?></p>
    <p><strong>Date of Journey:</strong> <?= htmlspecialchars($date) ?></p>
    <p><strong>Class:</strong> <?= htmlspecialchars($class) ?></p>
    <p><strong>Number of Tickets:</strong> <?= htmlspecialchars($tickets) ?></p>
  </div>

  <div class="center">
    <a href="index.php" class="btn">← Back to Home</a>
  </div>
</div>
<?php include 'footer.php'; ?>

</body>
</html>
