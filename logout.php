<?php
session_start();

// Check if user_id is set before using it
if (isset($_SESSION['user_id'])) {
    // For debugging: echo user id before logout (optional)
    echo "Login successful! User ID: " . $_SESSION['user_id'];
} else {
    // User not logged in or session expired
    echo "No user logged in.";
}

// Clear all session variables
$_SESSION = [];

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to login page after logout
header("Location: login.php");
exit;
?>
