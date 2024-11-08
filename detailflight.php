<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Details Popup</title>
    <style>
        /* Basic styling */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f8fcff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            width: 300px;
        }
        .popup h2 {
            margin-top: 0;
            font-size: 1.2em;
        }
        .popup .section {
            margin-bottom: 15px;
        }
        .popup .section h3 {
            font-size: 0.9em;
            color: #4a4a4a;
        }
        .popup .section p {
            margin: 5px 0;
            color: #333;
        }
        .close-btn {
            display: block;
            margin: 0 auto;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <table border="1">
        <tr>
            <th>Flight</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Flight 1</td>
            <td><button onclick="showDetails(1)">View Details</button></td>
        </tr>
        <tr>
            <td>Flight 2</td>
            <td><button onclick="showDetails(2)">View Details</button></td>
        </tr>
    </table>

    <!-- Popup for Flight Details -->
    <div id="popup" class="popup">
        <h2>Fare Details</h2>
        <div class="section">
            <h3>Fare</h3>
            <p id="fare"></p>
        </div>
        <div class="section">
            <h3>Baggage</h3>
            <p><span id="baggage-cabin"></span> Cabin bag allowance</p>
            <p><span id="baggage-checkin"></span> Check-in bag allowance</p>
        </div>
        <div class="section">
            <h3>Change/Cancellation</h3>
            <p>Change charges up to <span id="change-fee"></span></p>
            <p>Cancellation charges up to <span id="cancellation-fee"></span></p>
        </div>
        <button class="close-btn" onclick="closePopup()">Close</button>
    </div>

    <script>
        function showDetails(flightId) {
            fetch(`your_script.php?flightId=${flightId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("fare").innerText = `₹${data.fare}`;
                    document.getElementById("baggage-cabin").innerText = `${data.baggage_cabin} kg`;
                    document.getElementById("baggage-checkin").innerText = `${data.baggage_checkin} kg`;
                    document.getElementById("change-fee").innerText = `₹${data.change_fee}`;
                    document.getElementById("cancellation-fee").innerText = `₹${data.cancellation_fee}`;
                    document.getElementById("popup").style.display = "block";
                })
                .catch(error => console.error("Error fetching details:", error));
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
</body>
</html>

<?php
// your_database_config.php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getFlightDetails($flightId) {
    global $conn;
    $sql = "SELECT fare, baggage_cabin, baggage_checkin, change_fee, cancellation_fee FROM flights WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flightId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if (isset($_GET['flightId'])) {
    $flightId = $_GET['flightId'];
    $flightDetails = getFlightDetails($flightId);
    echo json_encode($flightDetails);
    exit;
}
?>
