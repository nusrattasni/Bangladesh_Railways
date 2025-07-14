<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'] ?? '';
    $to = $_POST['to'] ?? '';
    $date = $_POST['date'] ?? '';

    // DB connection
    $conn = new mysqli("localhost", "root", "", "railway");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM train_list WHERE from_station = ? AND to_station = ?");
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();
    $trains = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();
} else {
    echo "Please search for trains first.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Train Search Results</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('bg.jpg'); /* place your image here */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 2rem;
            color: white;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }

        .train-card {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .train-info {
            max-width: 75%;
        }

        .train-info h3 {
            margin: 0;
            font-size: 1.4rem;
            color: #ffc107;
        }

        .train-info p {
            margin: 5px 0;
            font-size: 0.95rem;
        }

        .book-form {
            flex-shrink: 0;
        }

        .book-form button {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 0.6rem 1.4rem;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .book-form button:hover {
            background-color: #218838;
        }

        @media (max-width: 600px) {
            .train-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .book-form {
                width: 100%;
                margin-top: 1rem;
                text-align: right;
            }
        }
    </style>
</head>


<body>

<h2>Available Trains from <?=htmlspecialchars($from)?> to <?=htmlspecialchars($to)?> on <?=htmlspecialchars($date)?></h2>

<?php if (!empty($trains)) : ?>
    <?php foreach ($trains as $row): ?>
        <div class="train-card">
            <div class="train-info">
                <h3><?=htmlspecialchars($row['train_name'])?></h3>
                <p><strong>Train No:</strong> <?=htmlspecialchars($row['train_no'])?></p>
                <p><strong>Departure:</strong> <?=htmlspecialchars($row['departure_time'])?></p>
                <p><strong>Arrival:</strong> <?=htmlspecialchars($row['arrival_time'])?></p>
            </div>

            <div class="book-form">
                <form action="reservation.php" method="POST">
                    <input type="hidden" name="train_id" value="<?=htmlspecialchars($row['id'])?>">
                    <input type="hidden" name="train_no" value="<?=htmlspecialchars($row['train_no'])?>">
                    <input type="hidden" name="train_name" value="<?=htmlspecialchars($row['train_name'])?>">
                    <input type="hidden" name="fromStation" value="<?=htmlspecialchars($from)?>">
                    <input type="hidden" name="toStation" value="<?=htmlspecialchars($to)?>">
                    <input type="hidden" name="date" value="<?=htmlspecialchars($date)?>">
                    <input type="hidden" name="class" value="Economy">
                    <button type="submit">Book</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No trains found for your search.</p>
<?php endif; ?>
<?php include 'footer.php'; ?>

</body>
</html>
