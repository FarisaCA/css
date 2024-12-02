<?php
@include './connect.php';
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['email'])) {
    header('location: ./login.php');
    exit();
}

// Get the email from the session
$email = $_SESSION['email'];

// Fetch user details
$sql_pro = mysqli_query($conn, "SELECT * FROM user_reg WHERE email='$email'");
if (!$sql_pro) {
    die("Query failed: " . mysqli_error($conn));
}

$user_details = mysqli_fetch_assoc($sql_pro);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('airdash.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1{
            font-size: 40px;
        }

        .sidebar {
            width: 250px;
            background: #3399ff;
            color: #fff;
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px;
            text-align: center;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
        }

        .sidebar ul li:hover {
            background: #1a73e8;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            background: #fff;
            padding: 10px 20px;
            margin: 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .default-section, .profile-section, .booking-section {
            display: none;
            
        }

        .default-section.show, .profile-section.show, .booking-section.show {
            display: block;
        }

        .title-welcome {
            color: #fff;
            text-shadow: 0px 0px 5px black;
        }

        .profile {
            color: white;
            text-shadow: 0px 0px 7px black;
            font-family: monospace;
            font-size: 20px;
            margin-bottom: 15px;
            margin: 35px;
        
        }
        .head-h2{
            font-size: 30px;
            margin-bottom: 15px;
            text-shadow: 0px 0px 3px white;
        }
            @keyframes circularShadow {
         0% {
         text-shadow: 0px -3px 10px black; /* Top */
         }
         25% {
         text-shadow: 3px 0px 10px black; /* Right */
         }
         50% {
         text-shadow: 0px 3px 10px black; /* Bottom */
        }
         75% {
         text-shadow: -3px 0px 10px black; /* Left */
        }
        100% {
          text-shadow: 0px -3px 10px black; /* Back to Top */
         }
        }

       .name-main {
            font-size: 25px;
            font-weight: bold;
            color: lightskyblue;
            animation: circularShadow 4s infinite linear;
       }

       .booking-table-container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.101);;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3399ff;
            color: #fff;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 16px;
        }

        .table-header {
            text-align: center;
            padding: 20px;
            background-color: #3399ff;
            color: #fff;
            font-size: 24px;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Modal Style */
        .modal {
            display: none; 
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 2px solid #ccc;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            font-family: 'Arial', sans-serif;
        }

        .ticket-modal {
            display: flex;
            flex-direction: column;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            border: 1px solid #ccc;
            width: 100%;
            text-align: center;
        }

        .ticket-header {
            background-color: #3399ff;
            color: white;
            padding: 10px;
            font-size: 24px;
            border-radius: 10px 10px 0 0;
        }

        .ticket-content {
            margin-top: 15px;
            font-size: 18px;
            padding: 10px;
        }

        .ticket-footer {
            margin-top: 15px;
            font-size: 18px;
            color: #555;
        }

        .ticket-footer div {
            padding: 5px 0;
        }

        .ticket-footer .close-btn {
            margin-top: 15px;
            background-color: #ff4444;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .ticket-footer .close-btn:hover {
            background-color: #ff0000;
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="#" class="profile-nav"><i class="fas fa-user"></i> My Profile</a></li>
            <li><a href="#" class="booking-nav"><i class="fas fa-book"></i> My Bookings</a></li>
            <li><a href="search_flight.php"><i class="fas fa-plane"></i> Book Tickets</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1>Airline Reservation System</h1>
        </div>

        <div class="default-section show">
            <h3 class="title-welcome">
                Welcome to FIFA Airlines User Dashboard </h3> <h1 class="name-main"><?php echo htmlspecialchars($user_details['name']); ?></h1>
                <h3 class="title-welcome"> Hope you have a great experience with us.
            </h3>
        </div>

        <div class="profile-section">
            <h2 class="head-h2">User Details</h2>
            <p class="profile"><strong>Name:</strong> <?php echo htmlspecialchars($user_details['name']); ?></p>
            <p class="profile"><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email']); ?></p>
            <p class="profile"><strong>Phone:</strong> <?php echo htmlspecialchars($user_details['number']); ?></p>
            <p class="profile"><strong>Address:</strong> <?php echo htmlspecialchars($user_details['address']); ?></p>
        </div>

        <div class="booking-section">
            <h2 class="head-h2">My Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Flight</th>
                        <th>Seat</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Ticket</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nihal Sidheek</td>
                        <td>nihal@gmail.com</td>
                        <td>Flight 101</td>
                        <td>A12</td>
                        <td>$200</td>
                        <td>Economy</td>
                        <td>2024-12-02</td>
                        <td><button class="ticket-btn" onclick="openModal('Nihal Sidheek', 'nihal@gmail.com', 'Flight 101', 'A12', '$200', 'Economy', '2024-12-02')">click here</button></td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>jane@example.com</td>
                        <td>Flight 202</td>
                        <td>B15</td>
                        <td>$350</td>
                        <td>Business</td>
                        <td>2024-12-05</td>
                        <td><button class="ticket-btn" onclick="openModal('Jane Smith', 'jane@example.com', 'Flight 202', 'B15', '$350', 'Business', '2024-12-05')">click here</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

        <!-- Modal Structure -->
    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <h2>Ticket Details</h2>
            <p><strong>Name:</strong> <span id="modalName"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Flight:</strong> <span id="modalFlight"></span></p>
            <p><strong>Seat:</strong> <span id="modalSeat"></span></p>
            <p><strong>Price:</strong> <span id="modalPrice"></span></p>
            <p><strong>Type:</strong> <span id="modalType"></span></p>
            <p><strong>Date:</strong> <span id="modalDate"></span></p>
        </div>
    </div>
    </div>


    <script>
        const profileNav = document.querySelector('.profile-nav');
        const bookingNav = document.querySelector('.booking-nav');
        const defaultSection = document.querySelector('.default-section');
        const profileSection = document.querySelector('.profile-section');
        const bookingSection = document.querySelector('.booking-section');

        function showSection(sectionToShow) {
            // Hide all sections
            [defaultSection, profileSection, bookingSection].forEach(section => {
                section.classList.remove('show');
            });
            // Show the target section
            sectionToShow.classList.add('show');
        }

        if (profileNav) {
            profileNav.addEventListener('click', () => {
                showSection(profileSection);
            });
        }

        if (bookingNav) {
            bookingNav.addEventListener('click', () => {
                showSection(bookingSection);
            });
        }

         function openModal(name, email, flight, seat, price, type, date) {
            document.getElementById('modalName').innerText = name;
            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalFlight').innerText = flight;
            document.getElementById('modalSeat').innerText = seat;
            document.getElementById('modalPrice').innerText = price;
            document.getElementById('modalType').innerText = type;
            document.getElementById('modalDate').innerText = date;

            document.getElementById('ticketModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('ticketModal').style.display = "none";
        }
    </script>
</body>
</html>
