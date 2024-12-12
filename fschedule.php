<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "airline");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle 'Delay' action
if (isset($_POST['delay_flight'])) {
    $flight_id = $_POST['flight_id'];

    // Update flight status to 'Delayed'
    $updateFlightQuery = "UPDATE flight SET f_status = 'Delayed' WHERE flight_id = ?";
    $stmt = $conn->prepare($updateFlightQuery);
    $stmt->bind_param('i', $flight_id);
    if ($stmt->execute()) {
        $message = "Flight marked as delayed successfully.";
    } else {
        $message = "Error: " . $stmt->error;
        error_log("Error: " . $stmt->error); // Log the error to your server's error log
    }
}

// Handle 'Departed' action
if (isset($_POST['depart_flight'])) {
    $flight_id = $_POST['flight_id'];

    // Update flight status to 'Departed'
    $updateFlightQuery = "UPDATE flight SET f_status = 'Departed' WHERE flight_id = ?";
    $stmt = $conn->prepare($updateFlightQuery);
    $stmt->bind_param('i', $flight_id);
    if ($stmt->execute()) {
        $message = "Flight marked as departed successfully.";
    } else {
        $message = "Error: " . $stmt->error;
        error_log("Error: " . $stmt->error); // Log the error to your server's error log
    }
}

// Fetch all flights
$sql = "SELECT flight_id, flight_no, d_datetime, r_datetime, f_status FROM flight";
$result = $conn->query($sql);
$flights = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flight Scheduling</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            margin: 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Manage Flight Scheduling</h1>

        <!-- Display success or error message -->
        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Displaying all flights -->
        <section class="booking-details">
            <?php if (!empty($flights)): ?>
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Flight ID</th>
                            <th>Flight No</th>
                            <th>Departure Time</th>
                            <th>Arrival Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($flights as $flight): ?>
                            <tr>
                                <td><?= htmlspecialchars($flight['flight_id']) ?></td>
                                <td><?= htmlspecialchars($flight['flight_no']) ?></td>
                                <td><?= htmlspecialchars($flight['d_datetime']) ?></td>
                                <td><?= htmlspecialchars($flight['r_datetime']) ?></td>
                                <td><?= htmlspecialchars($flight['f_status']) ?></td>
                                <td>
                                    <!-- Show the buttons for all flights, but disable them if the status is 'Departed' or 'Delayed' -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="flight_id" value="<?= $flight['flight_id'] ?>">
                                        <button type="submit" name="depart_flight" <?= $flight['f_status'] == 'Departed' ? 'disabled' : '' ?>>Depart</button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="flight_id" value="<?= $flight['flight_id'] ?>">
                                        <button type="submit" name="delay_flight" <?= $flight['f_status'] == 'Delayed' ? 'disabled' : '' ?>>Delay</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No flights available.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
