<?php
// Start the session
session_start();
require_once('connect.php');

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
                FROM flights 
                WHERE departure = ? AND arrival = ? AND d_date = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $from, $to, $departureDate);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data in a table format
            echo "<h2>Available Flights:</h2>";
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
    // Redirect back to the search form if accessed directly
  
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Reservation System</title>
    <link rel="stylesheet" href="./helo-style.css"> 
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
            <form class="flight-options-form" method="POST" action="search_flights.php">
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
                        <select id="from" name="from">
                            <option value="agra">Agra Civil Airport</option>
                            <option value="Ahmedabad">Ahmedabad Airport</option>
                            <option value="bahrain">Bahrain Airport</option>
                            <option value="mumbai">Mumbai Airport</option>
                        </select>
                    </div>

                    <div class="option1">
                        <label for="to">To</label>
                        <select id="to" name="to">
                            <option value="cochin">Cochin International Airport</option>
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
