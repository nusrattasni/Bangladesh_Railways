<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Signup - Bangladesh Railways</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <link rel="stylesheet" href="style.css" />

  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('bg.jpg');
      background-size: cover;
      background-position: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .signup-container {
      background: rgba(0, 0, 0, 0.75);
      padding: 2.5rem;
      border-radius: 12px;
      max-width: 450px;
      width: 100%;
      color: white;
      box-shadow: 0 0 20px rgba(0,0,0,0.6);
    }

    .signup-container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .signup-container label {
      display: block;
      margin-top: 1rem;
      margin-bottom: 0.4rem;
      font-size: 0.95rem;
    }

    .signup-container input {
      width: 100%;
      padding: 0.2rem;
      border-radius: 5px;
      border: none;
      font-size: 1rem;
    }

    .signup-container button {
      margin-top: 1.5rem;
      width: 100%;
      padding: 0.75rem;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .signup-container button:hover {
      background-color: #0056b3;
    }

    .signup-container p {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.9rem;
    }

    .signup-container a {
      color: #00cfff;
      text-decoration: none;
    }

    .signup-container a:hover {
      text-decoration: underline;
    }

    .back-button {
      position: absolute;
      top: 20px;
      right: 20px;
      font-size: 1rem;
      text-decoration: none;
      background-color: blue;
      padding: 8px 16px;
      border-radius: 8px;
      color: white;
      font-weight: bold;
      transition: background-color 0.3s ease;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .back-button:hover {
      background-color:rgb(13, 73, 112);
    }

    .error-message {
      background:#ff4d4d; 
      padding:0.7rem; 
      border-radius:5px; 
      margin-bottom:1rem; 
      text-align:center;
    }

    .success-message {
      background:#4CAF50; 
      padding:0.7rem; 
      border-radius:5px; 
      margin-bottom:1rem; 
      text-align:center;
    }
  </style>
</head>


<body>
  <a href="index.php" class="back-button">← Back</a>

  <div class="signup-container">
    <h2>Sign Up</h2>

    <?php if (isset($_SESSION['signup_error'])): ?>
      <div class="error-message">
        <?php 
          echo $_SESSION['signup_error']; 
          unset($_SESSION['signup_error']); 
        ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['signup_success'])): ?>
      <div class="success-message">
        <?php 
          echo $_SESSION['signup_success']; 
          unset($_SESSION['signup_success']); 
        ?>
      </div>
    <?php endif; ?>

    <form action="signup_process.php" method="POST">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="phone">Phone</label>
      <input type="tel" id="phone" name="phone" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required />

      <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
  <?php include 'footer.php'; ?>

</body>
</html>
