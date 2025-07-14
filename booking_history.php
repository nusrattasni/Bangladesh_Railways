<?php
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view booking history.");
}

$user_id = $_SESSION['user_id'];

// Connect to DB with charset
$conn = new mysqli("localhost", "root", "", "railway");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Prepare statement with error check
$sql = "SELECT b.*, t.train_name, t.from_station, t.to_station 
        FROM booking b 
        JOIN train_list t ON b.train_id = t.id 
        WHERE b.user_id = ? AND b.is_viewed = FALSE 
        ORDER BY b.booked_at DESC";


$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Booking History</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 1rem; background: #f7f7f7; }
    h2 { color: #007bff; }
    table { border-collapse: collapse; width: 100%; max-width: 700px; margin: auto; background: white; }
    th, td { padding: 0.75rem 1rem; border: 1px solid #ccc; text-align: left; }
    th { background: #007bff; color: white; }
    tr:nth-child(even) { background: #f2f2f2; }
  </style>
</head>


<body>

<h2>Your Booking History</h2>

<?php
if ($result && $result->num_rows > 0) {
    echo "<table>";
 echo "<tr><th>Train</th><th>From</th><th>To</th><th>Date</th><th>Class</th><th>Seats</th><th>Booked At</th></tr>";

    while ($row = $result->fetch_assoc()) {
        // After displaying, mark as viewed:
$update_sql = "UPDATE booking SET is_viewed = TRUE WHERE user_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $user_id);
$update_stmt->execute();
$update_stmt->close();

        echo "<tr>";
       echo "<td>" . htmlspecialchars($row['train_name']) . "</td>";
echo "<td>" . htmlspecialchars($row['from_station']) . "</td>";
echo "<td>" . htmlspecialchars($row['to_station']) . "</td>";

        echo "<td>" . htmlspecialchars($row['journey_date']) . "</td>";
       echo "<td>" . htmlspecialchars($row['class'] ?? '') . "</td>";
echo "<td>" . htmlspecialchars($row['seats']) . "</td>";

        echo "<td>" . htmlspecialchars($row['booked_at']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}

$stmt->close();
$conn->close();
?>
<?php include 'footer.php'; ?>

</body>
</html>
