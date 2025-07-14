<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

//echo "<pre>Session on index.php:\n";
//print_r($_SESSION);
//echo "</pre>";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bangladesh Railways</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
        margin: 0;
        padding: 0;
        background-image: url('bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        font-family: Arial, sans-serif;
        color: white;
    }

    .btn {
        padding: 8px 12px;
        background-color:rgb(10, 10, 10); /* or your theme color */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 5px;
    }

    .btn:hover {
        background-color:rgb(8, 8, 8); /* Darker green on hover */
    }
    </style>
</head>

<body>

<header style="position: relative; text-align: center; padding: 10px;">
    <h1 style="margin: 0; color: white;">Bangladesh Railways</h1>
    <div class="auth-buttons" style="position: absolute; top: 10px; right: 10px;">
        <?php if (isset($_SESSION['user_id'])): ?>
            <button class="btn" onclick="window.location.href='logout.php'">Logout</button>
        <?php else: ?>
            <button class="btn" onclick="window.location.href='login.php'">Login</button>
            <button class="btn" onclick="window.location.href='signup.php'">Signup</button>
        <?php endif; ?>
    </div>
</header>


<div class="navbar-container">
    <nav class="navbar">
        <a href="#" id="homeBtn">HOME</a>
        <a href="find_train.php" id="findTrainBtn">FIND TRAIN</a>
        <a href="reservation.php" id="reservationBtn">RESERVATION</a>
       <?php if (isset($_SESSION['user_id'])): ?>
    <a href="logout.php" class="btn">Logout</a>
<?php endif; ?>


     <?php if (isset($_SESSION['user_id'])): ?>
    <a href="profile.php" class="btn">Profile</a>
<?php else: ?>
    <a href="login.php" class="btn">Profile</a>
<?php endif; ?>


        <a href="#" id="historyBtn">BOOKING HISTORY</a>
    </nav>
</div>

<div id="defaultMessage" style="text-align:center; padding:2rem; color:white;">
    <h2>Please select a section from the navigation above.</h2>
</div>

<section id="homeSection">
    <div class="welcome-banner">
        <h2>Welcome to Bangladesh Railways</h2>
        <p>Your platform for booking train tickets and managing your journey with ease.</p>
    </div>
</section>

<section id="reservationSection" style="display: none;">
    <div class="reservation-center">
        <div class="reservation-box">
            <form action="booking.php" method="POST">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="fromStation">From:</label>
                <input type="text" id="fromStation" name="fromStation" required>

                <label for="toStation">To:</label>
                <input type="text" id="toStation" name="toStation" required>

                <label for="date">Date of Journey:</label>
                <input type="date" id="date" name="date" required>

                <label for="class">Class:</label>
                <select id="class" name="class" required>
                    <option value="">Select Class</option>
                    <option value="AC">AC</option>
                    <option value="Non-AC">Non-AC</option>
                    <option value="Shovon">Shovon</option>
                    <option value="First Class">First Class</option>
                </select>

                <label for="tickets">Tickets:</label>
                <input type="number" id="tickets" name="tickets" min="1" required>

                <button type="submit" class="btn">Reserve</button>
            </form>
        </div>
    </div>
</section>



<section id="historySection" style="display: none;">
    <div class="welcome-banner" style="margin-top: 20px;">
        <h2>Booking History</h2>
        <p>Here you can view your past reservations and booking details for Bangladesh Railways.</p>
        <div id="historyContent" style="margin-top: 1rem;">
            <!-- You can dynamically load user booking history here using PHP or AJAX -->
            <p>No booking history available. (Integrate with your database to display history here.)</p>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const sections = {
        home: document.getElementById("homeSection"),
        reservation: document.getElementById("reservationSection"),
        profile: document.getElementById("profileSection"), // might be null if missing
        history: document.getElementById("historySection"),
        default: document.getElementById("defaultMessage")
    };

    function hideAll() {
        Object.values(sections).forEach(s => {
            if (s) s.style.display = "none";
        });
    }

    function showSection(section) {
        hideAll();
        section.style.display = "block";
    }

    // On initial load, show only default message
    hideAll();
    sections.default.style.display = "block";

    // Nav button handlers:
    document.getElementById("homeBtn").onclick = () => {
        showSection(sections.home);
    };
    document.getElementById("reservationBtn").onclick = () => {
        showSection(sections.reservation);
    };
    
    document.getElementById("historyBtn").onclick = () => {
    fetch("get_bookings.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("historyContent").innerHTML = data;
            showSection(sections.history);
        })
        .catch(error => {
            document.getElementById("historyContent").innerHTML = "<p>Error loading booking history.</p>";
            showSection(sections.history);
        });
};

});

</script>
<?php include 'footer.php'; ?>

</body>
</html>
