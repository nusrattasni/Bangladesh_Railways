<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
    $userId = $_SESSION['user_id'];
    $reservationId = intval($_POST['reservation_id']);

    // Make sure the booking belongs to the logged-in user
    $sql = "DELETE FROM reservations WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $reservationId, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['cancel_success'] = "Booking cancelled successfully.";
    } else {
        $_SESSION['cancel_error'] = "Unable to cancel booking or booking not found.";
    }

    $stmt->close();
    $conn->close();

    header("Location: view_reservations.php");
    exit;
} else {
    header("Location: view_reservations.php");
    exit;
}
?>
