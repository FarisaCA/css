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
        $sql = "SELECT * FROM flights WHERE 
                departure = ? AND 
                arrival = ? "; 
                

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $from, $to, $departureDate, $classType);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<h2>Available Flights:</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<p>Flight ID: " . $row["id"] . " - From: " . $row["from_location"] .
                     " To: " . $row["to_location"] . " Departure: " . $row["departure_date"] .
                     " Arrival: " . $row["arrival_date"] . " Class: " . $row["class"] .
                     " Price: $" . $row["price"] . "</p>";
            }
        } else {
            echo "No flights found.";
        }

        // Close statement and connection
        $stmt->close();
    }
} else {
    // Redirect back to the search form if accessed directly
   // header("Location: index.php"); // Change index.php to your HTML file name
   // exit();
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
             <!-- Traveler Selection -->
        </div>

    <div class="options-container">
       <form class="flight-options-form">

            <!-- Round Trip Selection -->
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
    </form>
    </div>
     <div class="option1-container">

        <form class="option1-form">

        <div class="option1">
        <label for="from">From</label>
        <select id="from" name="from">
            <option value="agra">Agra civil Airport ,IAF Arjun Nagar Gate,kheria</option>
            <option value="Ahmedabad">Ahmedabad ,Sardar vallabhai patel International Airport</option>
            <option value="bahrain" >Bahrain Airport</option>
            <option value="mumbai">Mumbai chhatrapati shivaji Maharaj International Airport</option>
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
              <input type="date" name="date">
            </div>

            <div class="option1">
              <label for="arrival">Arrival</label>
              <input type="date" name="date">
            </div>
        </div>
       
    </div>
    <Button>Search Flight</Button> 
    </main>

    

   
</body>
</html>
