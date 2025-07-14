<?php
session_start();

// First, check if user_id is set before using it
if (!isset($_SESSION['user_id'])) {
    echo "<p>You must be logged in to view booking history.</p>";
    exit();
}

// Now it's safe to echo
echo "<p>Session user ID: " . htmlspecialchars($_SESSION['user_id']) . "</p>";

$conn = new mysqli("localhost", "root", "", "railway");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Use LEFT JOIN in case some bookings have missing train info
$sql = "SELECT b.journey_date, b.class, b.seats, b.booked_at,
               t.train_name, t.from_station, t.to_station
        FROM booking b
        LEFT JOIN trains t ON b.train_id = t.id
        WHERE b.user_id = ?
        ORDER BY b.booked_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1' style='width:100%; color:white; background-color: rgba(0,0,0,0.6);'>";
    echo "<tr>
            <th>Train</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
            <th>Class</th>
            <th>Seats</th>
            <th>Booked At</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['train_name'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['from_station'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['to_station'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['journey_date']) . "</td>
                <td>" . htmlspecialchars($row['class']) . "</td>
                <td>" . htmlspecialchars($row['seats']) . "</td>
                <td>" . htmlspecialchars($row['booked_at']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}

$stmt->close();
$conn->close();
?>
