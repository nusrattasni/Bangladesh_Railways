<?php
$servername = "localhost";
$username = "root";
$password = ""; // your password if any
$database = "railway";  // Use your actual DB name here

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 else {
   // echo "Connected to database 'railway' successfully!";
}

?>
