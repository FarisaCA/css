<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "airline");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query to fetch the necessary data
$sql = "
    SELECT 
        booking.name, 
        booking.email, 
        booking.seat, 
        booking.class, 
        flight.price, 
        flight.d_datetime, 
        flight.flight_no, 
        flight.f_status
    FROM 
        booking
    JOIN 
        flight ON booking.flight_id= flight.flight_id 
";

$result = $conn->query($sql);
$bookings = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
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
        .message {
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Booking Details</h1>

        <!-- Display success or error message -->
        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Displaying booking details -->
        <section class="booking-details">
            <?php if (!empty($bookings)): ?>
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Seat</th>
                            <th>Class</th>
                            <th>Price</th>
                            <th>Departure Time</th>
                            <th>Flight No</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['name']) ?></td>
                                <td><?= htmlspecialchars($booking['email']) ?></td>
                                <td><?= htmlspecialchars($booking['seat']) ?></td>
                                <td><?= htmlspecialchars($booking['class']) ?></td>
                                <td><?= htmlspecialchars($booking['price']) ?></td>
                                <td><?= htmlspecialchars($booking['d_datetime']) ?></td>
                                <td><?= htmlspecialchars($booking['flight_no']) ?></td>
                                <td><?= htmlspecialchars($booking['f_status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings available.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
