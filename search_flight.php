<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Flight</title>
    <link rel="stylesheet" href="search_flight.css">
</head>
<body>
    <header>
        <h1>Search Your Flights</h1>
        <a href="dashboard_user.php">Back to Dashboard</a>
    </header>
    <main>
        <form method="POST">
            <label for="from">From:</label>
            <select id="from" name="from" required>
            <option value="Delhi">Delhi,Indiragandhi International Airport </option>
            <option value="Agra civil Airport,kheria">Agra,Agra Civil Airport,kheria</option>
            <option value="kochi">Kochi,kochi International Airport</option>
            <option value="pune">Pune,pune International Airport</option>
            <option value="bhubaneswar">Bhubaneswar,Biju Patnaik Airport</option>
            <option value="Agra civil Airport,kheria">Ahmedabad,Sardar vallabhbhai patel International Airport</option>
            <option value="chennai">Chennai,Chennai International Airport</option>
            <option value="Kozhikode">Kozhikode,Calicut International Airport</option>
                <!-- Add more airports -->
            </select>
            <br>
            <label for="to">To:</label>
            <select id="to" name="to" required>
            <option value="bhubaneswar">Bhubaneswar,Biju Patnaik Airport</option>
            <option value="Agra civil Airport,kheria">Ahmedabad,Sardar vallabhbhai patel International Airport</option>
            <option value="chennai">Chennai,Chennai International Airport</option>
            <option value="Kozhikode">Kozhikode,Calicut International Airport</option>
            <option value="Delhi">Delhi,Indiragandhi International Airport</option>
            <option value="Agra civil Airport,kheria">Agra,Agra Civil Airport,kheria</option>
            <option value="kochi">kochi,kochi International Airport</option>
            <option value="pune">Pune,Pune International Airport</option>
                <!-- Add more airports -->
            </select>
            <br>
            <label for="departure">Departure Date:</label>
            <input type="date" id="departure" name="departure" required>
            <br>
            <button>Search</button>
        </form>
    </main>
</body>
</html>
<!--?php
// Start the session and connect to the database


//require_once('connect.php');


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = isset($_POST['from']) ? htmlspecialchars($_POST['from']) : '';
    $to = isset($_POST['to']) ? htmlspecialchars($_POST['to']) : '';
    $departureDate = isset($_POST['departure']) ? htmlspecialchars($_POST['departure']) : '';
    
   
    // Validate the inputs
    if (empty($from) || empty($to) || empty($departureDate)) {
        echo "Please fill in all required fields.";
    } else {
        $sql = "SELECT flight_no, departure, d_datetime, arrival, r_datetime, baggage, price
        FROM `flight`
        WHERE departure LIKE ? AND arrival LIKE ? AND d_datetime LIKE ?";
          $from = "%$from%";
          $to = "%$to%";
          $departureDate="%$departureDate%";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sss", $from, $to,$departureDate);
          $stmt->execute();
         $result = $stmt->get_result();

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit;
        }
      
        // Check if there are any results
        if ($result->num_rows > 0) {
            echo "<h4>Available Flights :</h4>";
            echo "<style>
            table {
                
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-family: Arial, sans-serif;
                font-size: 16px;
            }

            table, th, td {
                border: 1px solid #ddd;
            }

            th, td {
                padding: 12px;
                text-align: left;
            }

            th {
                background-color:#005bac ;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:hover {
                background-color: #ddd;
            }

            button {
                padding: 6px 12px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
                font-size: 14px;
                border-radius: 4px;
            }

            button:hover {
                background-color: #45a049;
            }
          </style>";
            echo "<table border='1'>
            <tr>
               <th>Flight No</th>
               <th>Departure</th>
               <th>Departure (Date & Time)</th>
               <th>Destination</th>
               <th>Arrival (Date & Time)</th>
               <th>Baggage Details</th>
               <th>Price</th>
               <th></th>
           </tr>";
            // Fetch rows and output the details
            while ($row = $result->fetch_assoc()) {
            
                echo "<tr>
                        <td>" . $row["flight_no"] . "</td>
                        <td>" . $row["departure"] . "</td>
                        <td>" . $row["d_datetime"] . "</td>
                        <td>" . $row["arrival"] . "</td>
                        <td>" . $row["r_datetime"] . "</td>
                        <td>" . $row["baggage"] . "</td>
                        <td>" . $row["price"] . "</td>
                        <td><a href='booking.php?flight_no=" . urlencode($row["flight_no"]) . "&price=" . urlencode($row["price"]) . "'>BOOK</a></td>
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
    
    echo "Search & Book Flights !";
}
?-->
<?php
// Start the session and connect to the database


require_once('connect.php');


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = isset($_POST['from']) ? htmlspecialchars($_POST['from']) : '';
    $to = isset($_POST['to']) ? htmlspecialchars($_POST['to']) : '';
    $departureDate = isset($_POST['departure']) ? htmlspecialchars($_POST['departure']) : '';
    
   
    // Validate the inputs
    if (empty($from) || empty($to) || empty($departureDate)) {
        echo "Please fill in all required fields.";
    } else {
        $sql = "SELECT flight_id,flight_no, departure, d_datetime, arrival, r_datetime, baggage, price
        FROM flight
        WHERE departure LIKE ? AND arrival LIKE ? AND d_datetime LIKE ?";
          $from = "%$from%";
          $to = "%$to%";
          $departureDate="%$departureDate%";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sss", $from, $to,$departureDate);
          $stmt->execute();
         $result = $stmt->get_result();

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit;
        }
      
        // Check if there are any results
        if ($result->num_rows > 0) {
            echo "<h4>Available Flights :</h4>";
            echo "<style>
            table {
                
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-family: Arial, sans-serif;
                font-size: 16px;
            }

            table, th, td {
                border: 1px solid #ddd;
            }

            th, td {
                padding: 12px;
                text-align: left;
            }

            th {
                background-color:#005bac ;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:hover {
                background-color: #ddd;
            }

            button {
                padding: 6px 12px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
                font-size: 14px;
                border-radius: 4px;
            }

            button:hover {
                background-color: #45a049;
            }
          </style>";
            echo "<table border='1'>
            <tr>
               <th>Flight No</th>
               <th>Departure</th>
               <th>Departure (Date & Time)</th>
               <th>Destination</th>
               <th>Arrival (Date & Time)</th>
               <th>Baggage Details</th>
               <th>Price</th>
               <th></th>
           </tr>";
            // Fetch rows and output the details
            while ($row = $result->fetch_assoc()) {
            
                echo "<tr>
                        <td>" . $row["flight_no"] . "</td>
                        <td>" . $row["departure"] . "</td>
                        <td>" . $row["d_datetime"] . "</td>
                        <td>" . $row["arrival"] . "</td>
                        <td>" . $row["r_datetime"] . "</td>
                        <td>" . $row["baggage"] . "</td>
                        <td>" . $row["price"] . "</td>
                        <td><a href='booking.php?flight_id=".urlencode($row["flight_id"]) ."&flight_no=" .urlencode($row["flight_no"]) . "&price=₹" . urlencode($row["price"]) . "'>BOOK</a></td>
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
    
    echo "Search & Book Flights !";
}
?>