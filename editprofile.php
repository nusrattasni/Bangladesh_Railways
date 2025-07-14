<?php
session_start();
include "db_connection.php";

// check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $_SESSION['profile_error'] = "Please fill in all fields.";
        header("Location: index.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // check if email already exists for another user
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $checkStmt->bind_param("si", $email, $user_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $_SESSION['profile_error'] = "This email is already in use by another account.";
        header("Location: index.php");
        exit;
    }

    // if not in use, proceed to update
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

    if ($stmt->execute()) {
        $_SESSION['profile_success'] = "Profile updated successfully.";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['profile_error'] = "Something went wrong. Please try again.";
        header("Location: index.php");
        exit;
    }
}
?>
