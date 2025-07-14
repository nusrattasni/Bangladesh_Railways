<?php
session_start();
// You can add authentication check here if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Find Train - Bangladesh Railways</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
      background-image: url('bg.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      min-height: 100vh;
    }
    .train-search-box {
  background: rgba(0,0,0,0.75);
  padding: 2rem;
  border-radius: 12px;
  max-width: 450px;
  margin: auto;
  margin-top: 80px;  /* Added this line */
}

    label, input, button {
      display: block;
      width: 100%;
      margin-bottom: 1 rem;
    }
    input, select {
      padding: 0.5rem;
      border-radius: 5px;
      border: none;
      font-size: 1rem;
    }
    button {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      border: none;
      padding: 0.75rem;
      font-size: 1.1rem;
    }
    button:hover {
      background-color: #0056b3;
    }
 .back-link {
  display: inline-block;
  background-color: #007bff;  /* blue background */
  color: white;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: bold;
  text-decoration: none;
  position: absolute;
  top: 20px;
  right: 20px;               /* move to right side */
  transition: background-color 0.3s ease;
}

.back-link:hover {
  background-color: #0056b3; /* darker blue on hover */
}

  </style>
</head>


<body>
  <a href="index.php" class="back-link">← Back to Home</a>

  <div class="train-search-box">
    <h2>Find Train</h2>
    <form action="find_train_results.php" method="POST">
      <label for="from">From:</label>
      <input type="text" id="from" name="from" required>

      <label for="to">To:</label>
      <input type="text" id="to" name="to" required>

      <label for="date">Date of Journey:</label>
      <input type="date" id="date" name="date" required>

      <button type="submit">Search Train</button>
    </form>
  </div>
  <?php include 'footer.php'; ?>

</body>
</html>
