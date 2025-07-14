<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation: passwords match
    if ($password !== $confirm_password) {
        $_SESSION['signup_error'] = "Passwords do not match.";
        header("Location: signup.php");
        exit;
    }

    // Check if email already exists
    $checkSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = "Email is already registered. Please login or use another email.";
        header("Location: signup.php");
        exit;
    }
    $stmt->close();

    // Email is unique, insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insertSql = "INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        // Redirect to login or dashboard after signup
        $_SESSION['signup_success'] = "Signup successful! Please login.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['signup_error'] = "Database error: " . $stmt->error;
        header("Location: signup.php");
        exit;
    }
} else {
    // If accessed directly, redirect to signup form
    header("Location: signup.php");
    exit;
}
?>
