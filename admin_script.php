<?php
require_once("connect.php");
// Function to load flights
function loadFlights() {
    global $conn;
    $sql = "SELECT * FROM flight";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['flight_no']}</td>
                    <td>{$row['departure']}</td>
                    <td>{$row['destination']}</td>
                    <td>{$row['depar_date']}</td>
                    <td><button onclick=\"deleteFlight('{$row['flight_no']}')\">Delete</button></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No flights found</td></tr>";
    }
}

// Function to load users
require_once("connect.php");
function loadUsers() {
    global $conn;
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['uname']}</td>
                    <td>{$row['uemail']}</td>
                    <td><button onclick=\"deleteUser('{$row['user_id']}')\">Delete</button></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No users found</td></tr>";
    }
}
header('Location:home.php');
// Function to load bookings
/*
require_once('connect.php');
function loadBookings() {
    global $conn;
    $sql = "SELECT * FROM bookings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['booking_id']}</td>
                    <td>{$row['user_id']}</td>
                    <td>{$row['flight_number']}</td>
                    <td>{$row['date']}</td>
                    <td><button onclick=\"deleteBooking('{$row['booking_id']}')\">Delete</button></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No bookings found</td></tr>";
    }
}
*/
// Close the database connection
/*$conn->close();*/
?>
