<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id     = $_SESSION['user_id'];
    $train_id    = $_POST['train_id'];
    $journey_date = $_POST['journey_date'];
    $seats       = $_POST['seats'];
    $class       = $_POST['class'];

   $sql = "INSERT INTO booking (user_id, train_id, journey_date, seats, class, booked_at, is_viewed)
        VALUES (?, ?, ?, ?, ?, NOW(), FALSE)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisis", $user_id, $train_id, $journey_date, $seats, $class);

    if ($stmt->execute()) {
        echo "Ticket booked successfully!";
    } else {
        echo "Booking failed: " . $stmt->error;
    }
}
?>
