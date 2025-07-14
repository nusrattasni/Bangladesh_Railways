<?php
session_start();

// Optional: Check if user is logged in and has user_id in session
// if (!isset($_SESSION['user_id'])) {
//     die("Please login to view your reservations.");
// }

// Database connection
$conn = new mysqli("localhost", "root", "", "railway");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// If you have user-specific reservations, filter by user_id here.
// For now, fetch all reservations.
$sql = "SELECT * FROM reservations ORDER BY booked_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>My Reservations - Bangladesh Railways</title>
<style>
  body {
    font-family: Arial, sans-serif;
    padding: 1rem;
    background: #f7f7f7;
  }
  h2 {
    color: #007bff;
    text-align: center;
  }
  table {
    border-collapse: collapse;
    width: 90%;
    max-width: 1000px;
    margin: 1rem auto;
    background: white;
  }
  th, td {
    padding: 0.75rem 1rem;
    border: 1px solid #ccc;
    text-align: left;
  }
  th {
    background: #007bff;
    color: white;
  }
  tr:nth-child(even) {
    background: #f2f2f2;
  }
  .no-data {
    text-align: center;
    margin-top: 2rem;
    font-size: 1.2rem;
    color: #666;
  }
</style>
</head>


<body>

<h2>My Reservation History</h2>

<?php if ($result && $result->num_rows > 0): ?>
<table>
  <thead>
    <tr>
      <th>Reservation ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>From</th>
      <th>To</th>
      <th>Date</th>
      <th>Class</th>
      <th>Tickets</th>
      <th>Train ID</th>
      <th>Train No</th>
      <th>Train Name</th>
      <th>Booked At</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['from_station']) ?></td>
        <td><?= htmlspecialchars($row['to_station']) ?></td>
        <td><?= htmlspecialchars($row['journey_date']) ?></td>
        <td><?= htmlspecialchars($row['class']) ?></td>
        <td><?= htmlspecialchars($row['tickets']) ?></td>
        <td><?= htmlspecialchars($row['train_id']) ?></td>
        <td><?= htmlspecialchars($row['train_no']) ?></td>
        <td><?= htmlspecialchars($row['train_name']) ?></td>
        <td><?= htmlspecialchars($row['booked_at']) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php else: ?>
  <p class="no-data">No reservations found.</p>
<?php endif; ?>

<?php
$conn->close();
?>
<?php include 'footer.php'; ?>

</body>
</html>
