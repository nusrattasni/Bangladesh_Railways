<?php
session_start();
include 'db_connection.php'; // make sure $conn is defined here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect user input
    $name        = trim($_POST['name'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $fromStation = trim($_POST['fromStation'] ?? '');
    $toStation   = trim($_POST['toStation'] ?? '');
    $journeyDate = $_POST['date'] ?? '';
    $class       = $_POST['class'] ?? '';
    $tickets     = intval($_POST['tickets'] ?? 0);

    $train_id    = intval($_POST['train_id'] ?? 0);

    // Validate required fields
    if (
        empty($name) || empty($email) ||
        empty($fromStation) || empty($toStation) ||
        empty($journeyDate) || empty($class) ||
        $tickets < 1 || $train_id < 1
    ) {
        die("Please fill in all fields correctly.");
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        die("User not logged in.");
    }

    // Prepare insert statement
    $sql = "INSERT INTO booking (user_id, train_id, journey_date, seats, class, booked_at, is_viewed) VALUES (?, ?, ?, ?, ?, NOW(), FALSE)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters matching the SQL placeholders:
    // user_id (int), train_id (int), journey_date (string), seats (int), class (string)
    $stmt->bind_param("iisis", $user_id, $train_id, $journeyDate, $tickets, $class);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<h2 style='color:green; text-align:center;'>Reservation successful!</h2>";
        echo "<p style='text-align:center;'><a href='index.php'>← Return to Home</a></p>";
    } else {
        echo "<h2 style='color:red; text-align:center;'>Reservation failed: " . htmlspecialchars($stmt->error) . "</h2>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: reservation.php");
    exit;
}
?>
