<?php
include 'db_connection.php';

$train_id     = $_GET['train_id'];
$journey_date = $_GET['journey_date'];

$sql = "SELECT available_seats, class FROM seats_availability WHERE train_id=? AND journey_date=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $train_id, $journey_date);
$stmt->execute();
$result = $stmt->get_result();

echo "<h3>Seat Availability</h3>";
while ($row = $result->fetch_assoc()) {
    echo "Class: " . $row['class'] . " - Seats Available: " . $row['available_seats'] . "<br>";
}
?>
