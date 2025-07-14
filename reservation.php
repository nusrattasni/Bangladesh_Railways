<?php
session_start();
//echo "<pre>POST data received:\n";
//print_r($_POST);
//echo "</pre>";
//exit;
// Database connection (adjust credentials as needed)
$servername = "localhost";
$username = "root";
$password = "";
$database = "railway";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Classes array for the dropdown
$classes = ['Economy', 'Business', 'First Class'];

$error = '';
$success = '';

// Initialize variables to avoid undefined notices
$train_id = $train_no = $train_name = $from = $to = $date = $class = '';
$name = $email = '';
$tickets = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if passenger details are submitted (final reservation submission)
    if (isset($_POST['name'], $_POST['email'], $_POST['tickets'])) {
        // Retrieve and sanitize inputs
        $train_id   = $_POST['train_id'] ?? '';
        $train_no   = $_POST['train_no'] ?? '';
        $train_name = $_POST['train_name'] ?? '';
        $from       = $_POST['fromStation'] ?? '';
        $to         = $_POST['toStation'] ?? '';
        $date       = $_POST['date'] ?? '';
        $class      = $_POST['class'] ?? '';

        $name       = trim($_POST['name']);
        $email      = trim($_POST['email']);
        $tickets    = intval($_POST['tickets']);

        // Validate train details & passenger info
        if (empty($train_id) || empty($train_no) || empty($train_name) || empty($from) || empty($to) || empty($date) || empty($class)) {
            $error = "Train details missing. Please start your reservation from the train search page.";
        } elseif (!$name || !$email || $tickets < 1) {
            $error = "Please fill in all passenger details correctly.";
        } else {
            // Prepare insert statement
            $stmt = $conn->prepare("INSERT INTO reservations (name, email, from_station, to_station, journey_date, class, tickets, train_id, train_no, train_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssisss", $name, $email, $from, $to, $date, $class, $tickets, $train_id, $train_no, $train_name);

            if ($stmt->execute()) {
                $success = "Reservation successful! Thank you, $name.";
                // Clear form data after success
                $train_id = $train_no = $train_name = $from = $to = $date = $class = $name = $email = '';
                $tickets = 1;
            } else {
                $error = "Reservation failed: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        }
    } else {
        // First time loading form after clicking 'Book' (no passenger details yet)
        $train_id   = $_POST['train_id'] ?? '';
        $train_no   = $_POST['train_no'] ?? '';
        $train_name = $_POST['train_name'] ?? '';
        $from       = $_POST['fromStation'] ?? '';
        $to         = $_POST['toStation'] ?? '';
        $date       = $_POST['date'] ?? '';
        // Set default class to 'Economy' if missing
        $class      = $_POST['class'] ?? 'Economy';

        $name = '';
        $email = '';
        $tickets = 1;

        if (!$train_id || !$train_name || !$from || !$to || !$date) {
            header("Location: find_train.php");
            exit;
        }
    }
} else {
    // Not a POST request, redirect to search page
    header("Location: find_train.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Make a Reservation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url('bg.jpg');
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    padding: 2rem;
    max-width: 600px;
    margin: auto;
    color: black;
}

h2 {
    text-align: center;
    color: black;
    text-shadow: none;
}

form, .train-summary {
    background: rgba(255, 255, 255, 0.2); /* semi-transparent white */
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    margin-bottom: 2rem;
    color: black;
    border: 1px solid rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-top: 1rem;
    font-weight: 600;
    color: black;
}

input[type="text"],
input[type="email"],
input[type="number"] {
    width: 100%;
    padding: 0.6rem;
    margin-top: 0.3rem;
    border: none;
    border-radius: 8px;
    box-sizing: border-box;
    background: rgba(255,255,255,0.5);
    color: black;
    font-size: 1rem;
}

input::placeholder {
    color: #555;
}

input:focus {
    outline: none;
    background: rgba(255,255,255,0.7);
}

button {
    margin-top: 1.5rem;
    width: 100%;
    padding: 0.7rem;
    font-size: 1rem;
    background-color: rgba(0, 123, 255, 0.8);
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: rgba(0, 86, 179, 0.9);
}


        .train-summary {
            background: #f1f3f5;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        .heading-box {
    background: rgba(255, 255, 255, 0.2); /* glass effect */
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 1rem 2rem;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 2rem;
    color: black;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    border: 1px solid rgba(0,0,0,0.1);
}
.heading-box h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

    </style>
</head>

<body>
   <div class="heading-box">
  <h2>Make a Reservation</h2>
</div>


    <div class="train-summary">
        <strong>Train:</strong> <?= htmlspecialchars($train_name) ?> (<?= htmlspecialchars($train_no) ?>)<br>
        <strong>From:</strong> <?= htmlspecialchars($from) ?> →
        <strong>To:</strong> <?= htmlspecialchars($to) ?><br>
        <strong>Date:</strong> <?= htmlspecialchars($date) ?><br>
        <strong>Class:</strong> <?= htmlspecialchars($class) ?>
    </div>

   <form action="reserve_train.php" method="POST">

        <!-- Hidden fields -->
        <input type="hidden" name="train_id" value="<?= htmlspecialchars($train_id) ?>">
        <input type="hidden" name="train_no" value="<?= htmlspecialchars($train_no) ?>">
        <input type="hidden" name="train_name" value="<?= htmlspecialchars($train_name) ?>">
        <input type="hidden" name="fromStation" value="<?= htmlspecialchars($from) ?>">
        <input type="hidden" name="toStation" value="<?= htmlspecialchars($to) ?>">
        <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
        <input type="hidden" name="class" value="<?= htmlspecialchars($class) ?>">

        <!-- Passenger input fields -->
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="tickets">Number of Tickets:</label>
        <input type="number" id="tickets" name="tickets" min="1" value="1" required>

        <button type="submit">Confirm Reservation</button>
    </form>
    <?php include 'footer.php'; ?>

</body>
</html>
