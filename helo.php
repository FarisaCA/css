<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Reservation System</title>
    <link rel="stylesheet" href="helo-style.css"> 
</head>
<body>
    <header>
        <div class="header-container">
            <h1>FIFA AIRLINES</h1>
            <nav>
                <ul>
                    <li><a href="#">Flights</a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="search-container">
            <h1>Search, Compare Flights & Save</h1>
        </div>

        <div class="options-container">
            <form class="flight-options-form" method="POST">
                <div class="option">
                    <label for="trip-type">Round Trip</label>
                    <select id="trip-type" name="trip-type">
                        <option value="round-trip">Round Trip</option>
                        <option value="one-way">One Way</option>
                    </select>
                </div>

                <div class="option">
                    <label for="class-type">Class</label>
                    <select id="class-type" name="class-type">
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                        <option value="first-class">First Class</option>
                    </select>
                </div>

                <div class="option">
                    <label for="travelers">Traveler</label>
                    <select id="travelers" name="travelers">
                        <option value="1">1 Traveler</option>
                        <option value="2">2 Travelers</option>
                        <option value="3">3 Travelers</option>
                        <option value="4">4 Travelers</option>
                    </select>
                </div>

                <div class="option1-container">
                    <div class="option1">
                        <label for="from">From</label>
                        <select id="from" name="from" required>
                            <option value="Delhi">Delhi</option>
                            <option value="Agra civil Airport,kheria">Agra Civil Airport</option>
                            <!-- Add other departure options -->
                        </select>
                    </div>

                    <div class="option1">
                        <label for="to">To</label>
                        <select id="to" name="to" required>
                            <option value="Kozhikode">Kozhikode</option>
                            <option value="Cochin International Airport">Cochin International Airport</option>
                            <!-- Add other arrival options -->
                        </select>
                    </div>

                    <div class="option1">
                        <label for="departure">Departure</label>
                        <input type="date" id="departure" name="departure" required>
                    </div>

                    <div class="option1">
                        <label for="arrival">Arrival</label>
                        <input type="date" id="arrival" name="arrival" required>
                    </div>
                </div>
                <button type="submit">Search Flight</button>
            </form>
        </div>
    </main>
</body>
</html>

<?php
// Start the session and connect to the database
require_once('connect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $tripType = isset($_POST['trip-type']) ? htmlspecialchars($_POST['trip-type']) : '';
    $classType = isset($_POST['class-type']) ? htmlspecialchars($_POST['class-type']) : '';
    $travelers = isset($_POST['travelers']) ? (int)$_POST['travelers'] : 1;
    $from = isset($_POST['from']) ? htmlspecialchars($_POST['from']) : '';
    $to = isset($_POST['to']) ? htmlspecialchars($_POST['to']) : '';
    $departureDate = isset($_POST['departure']) ? htmlspecialchars($_POST['departure']) : '';
    $arrivalDate = isset($_POST['arrival']) ? htmlspecialchars($_POST['arrival']) : '';

    // Validate the inputs
    if (empty($from) || empty($to) || empty($departureDate) || empty($travelers)) {
        echo "Please fill in all required fields.";
    } else {
        // Prepare SQL query
        $sql = "SELECT flight_no, departure, d_date, d_time, arrival, a_date, a_time, price 
                FROM `flight`
                WHERE departure = ? AND arrival = ? ";
        
        // Prepare the statement and bind parameters
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit;
        }

        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any results
        if ($result->num_rows > 0) {
            echo "<h4>Available Flights:</h4>";
            echo "<table border='1'>
                    <tr>
                        <th>Flight No</th>
                        <th>Departure</th>
                        <th>Departure Date</th>
                        <th>Departure Time</th>
                        <th>Arrival</th>
                        <th>Arrival Date</th>
                        <th>Arrival Time</th>
                        <th>Price</th>
                    </tr>";
            // Fetch rows and output the details
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["flight_no"] . "</td>
                        <td>" . $row["departure"] . "</td>
                        <td>" . $row["d_date"] . "</td>
                        <td>" . $row["d_time"] . "</td>
                        <td>" . $row["arrival"] . "</td>
                        <td>" . $row["a_date"] . "</td>
                        <td>" . $row["a_time"] . "</td>
                        <td>$" . $row["price"] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No flights found.";
        }

        // Close statement
        $stmt->close();
    }
} else {
    // If accessed directly, prompt for form submission
    echo "Please submit the form to search for flights.";
}

// Close the connection
$conn->close();
?>

