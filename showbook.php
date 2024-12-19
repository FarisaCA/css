<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "airline");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the cancel action
if (isset($_POST['cancel'])) {

    $booking_id = $_POST['book_id'];

    // Update the booking status to cancelled (set the cancel flag to 1)
    $sql = "UPDATE booking SET cancel = 1 WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $booking_id); 
    
    if ($stmt->execute()) {
        // Redirect to the same page after successful cancellation
        header("Location: showbook.php?message=Booking%20cancelled%20successfully");
        exit();
    } else {
        // Handle error if the query fails
        $error_message = "Error cancelling booking: " . $stmt->error;
    }
}

// Get the email from session
$email = $_SESSION['email'];

$sql = "
    SELECT 
        booking.name, 
        booking.email, 
        booking.seat, 
        booking.class, 
        flight.price, 
        flight.d_datetime, 
        flight.flight_no, 
        flight.f_status,
        booking.flight_id,
        booking.cancel,
        booking.book_id
    FROM 
        booking
    JOIN 
        flight ON booking.flight_id = flight.flight_id
    WHERE
        booking.email = ?  -- Filter by logged-in user's email
";

// Prepare and execute the SQL query with the email
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email); 
$stmt->execute();
$result = $stmt->get_result();
$bookings = [];

if ($result && $result->num_rows > 0) {
    // Fetch the booking details
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
} else {
    $message = "No bookings found for the logged-in user.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="showbook.css">
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
        .cancel-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .cancel-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
<header>
        <nav>
            <a href="dashboard_user.php">Back to Dashboard</a>
        </nav>
    </header>


    <main class="container">
        <h1>BOOKING DETAILS</h1>

        <!-- Display success or error message -->
        <?php if (isset($_GET['message'])): ?>
            <div class="message"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="message" style="background-color: #ffcccc;"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

         <!-- Displaying a cancellation message that appears for 1 minute -->
        <div id="cancel-message" class="message" style="background-color: #fff3cd; color: #856404;">
             A refund of 30% will be processed after deducting cancellation fees.
        </div>

        <!-- Displaying booking details -->
        <section class="booking-details">
            <?php if (!empty($bookings)): ?>
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Flight No</th>
                            <th>Departure D&T</th>
                            <th>Class</th>
                            <th>Seat</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['name']) ?></td>
                                <td><?= htmlspecialchars($booking['email']) ?></td>
                                <td><?= htmlspecialchars($booking['flight_no']) ?></td>
                                <td><?= htmlspecialchars($booking['d_datetime']) ?></td>
                                <td><?= htmlspecialchars($booking['class']) ?></td>
                                <td><?= htmlspecialchars($booking['seat']) ?></td>
                                <td><?= htmlspecialchars($booking['price']) ?></td>
                                <td><?= htmlspecialchars($booking['f_status']) ?></td>
                                <td>
                                    <?php if ($booking['cancel'] == 0): ?>
                                        <form method="POST" action="showbook.php">
                                            <input type="hidden" name="book_id" value="<?= $booking['book_id'] ?>">
                                            <button type="submit" name="cancel" class="cancel-btn">Cancel Flight</button>
                                        </form>
                                    <?php else: ?>
                                        <span>Cancelled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings available for your account.</p>
            <?php endif; ?>
        </section>
    </main>
            <script>
        setTimeout(function() {
            var message = document.getElementById('cancel-message');
            message.style.display = 'none';  // Hide the message after 1 minute
        }, 8000); // 60000 ms = 1 minute
        </script>
</body>
</html>