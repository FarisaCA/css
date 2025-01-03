<?php

@include './connect.php';
session_start();

if (isset($_SESSION['manager_name'])) { // Fix: Correct session check
    header('location:login.php');
}

// deletion
if (isset($_POST['delete'])) {
    $book_id = $_POST['book_id'];
    $sql = "UPDATE `booking` SET `status`=false WHERE `book_id`='$book_id'";

    if ($conn->query($sql) === FALSE) {
        die("Error updating value: " . $conn->error);
    } else {
        echo "<script>alert('Booking removed successfully');</script>";
    }

    // Redirect to refresh the table
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLIGHT MANAGER Dashboard - Airline Reservation System</title>
    <link rel="stylesheet" href="fmanager_style.css">
</head>
<body>
    <header>
        <h1>Flight Manager Dashboard</h1>
        <nav>
            <ul>
                <li><a href="manage_flight.php">Manage Flights</a></li>
                <li><a href="#bookings">Manage Booking</a></li>
                <li><a href="fschedule.php">Manage Scheduling</a></li>
                <li><a href="#cancelbook">Cancelled Bookings</a></li>
                <li><a href="logout.php" class="logout-button">Log out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="bookings">
            <h2>Booking Details</h2>
            <table border="2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Email</th>
                        <th>Flight No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Fetch booking details with flight no where cancel value is 0 (not cancelled)
                        $sql = "
                                SELECT 
                                    booking.book_id, 
                                    booking.name, 
                                    booking.dob, 
                                    booking.email, 
                                    flight.flight_no 
                                FROM booking 
                                JOIN flight ON booking.flight_id = flight.flight_id 
                                WHERE booking.status = true AND booking.cancel = 0";  // Only show non-cancelled bookings

                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['name']}</td>
                                        <td>{$row['dob']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['flight_no']}</td> <!-- Display flight number -->
                                        <td>
                                            <form method='post'>
                                                <input type='hidden' name='book_id' value='{$row['book_id']}'>
                                                <button type='submit' name='delete'>DELETE</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No bookings found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <section id="cancelbook">
            <h2>Cancelled Bookings</h2>
            <table border="2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Email</th>
                        <th>Flight No</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Cancelled booking details with flight no
                        $sql = "
                                SELECT 
                                    booking.book_id, 
                                    booking.name, 
                                    booking.dob, 
                                    booking.email, 
                                    flight.flight_no 
                                FROM booking 
                                JOIN flight ON booking.flight_id = flight.flight_id 
                                WHERE booking.cancel = 1";  // Show only cancelled bookings

                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['name']}</td>
                                        <td>{$row['dob']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['flight_no']}</td> <!-- Display flight number -->
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No cancelled bookings found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
