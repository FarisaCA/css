
<?php
 
 session_start();
 
 if(isset($_SESSION['manager_name'])){
    header('location:./login.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLIGHT MANAGER Dashboard - Airline Reservation System</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <header>
        <h1>Flight Manager Dashboard</h1>
        <nav>
            <ul>
                <li><a href="manage_flight.php">Manage Flights</a></li>
                <!-- <li><a href="#users">Manage Users</a></li> -->
                <li><a href="#bookings">Manage Booking</a></li>
                <!--li><a href="#bookings">Manage Seat</a></li-->
                <li><a href="logout.php" class="logout-button">Logout</a></li>
                
            </ul>
        </nav>
    </header>

    <main>
        <!--section id="flights">
            <h2>Manage Flights</h2>
            <button onclick="addFlight()">Add New Flight</button>
            <table>
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead-->
                <tbody>
                    <!-- ?php
                    // Include database connection
                    include 'admin_script.php';
                    loadFlights();
                    ? -->
                </tbody>
            </table>
        </section>

        <section id="users">
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php loadUsers(); ?>
                </tbody>
            </table>
        </section>

        <section id="bookings">
            <h2>Manage Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User ID</th>
                        <th>Flight Number</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!--?php loadBookings(); ?-->
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
