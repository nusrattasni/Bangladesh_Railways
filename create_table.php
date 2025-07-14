<?php
$servername = "localhost";        // Usually "localhost" if running locally
$username = "root";
$password = "mysecretpass";
$dbname = "bd_railways";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    from_station VARCHAR(100) NOT NULL,
    to_station VARCHAR(100) NOT NULL,
    journey_date DATE NOT NULL,
    class VARCHAR(50) NOT NULL,
    tickets INT NOT NULL,
    booked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "Table 'bookings' created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
