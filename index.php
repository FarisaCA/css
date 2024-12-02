<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Reservation System</title>
    <link rel="stylesheet" href="helo-style.css"> 
    <style>
        .options-container{
            border: 2px solid #005eb8;
            background-color: rgba(0, 0, 0, 0.07);
        }
        h1{
            color:white;
        }
        </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>FIFA AIRLINES</h1>
            <nav>
                <ul>
                    <!-- <li><a href="">Flights</a></li> -->
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
               <!-- <div class="option">
                    <label for="trip-type">Round Trip</label>
                    <select id="trip-type">
                        <option value="one-way">One Way</option>
                        <option value="round-trip">Round Trip</option>
                    </select>
                </div> -->

                <!-- <div class="option">
                    <label for="class-type">Class</label>
                    <select id="class-type" name="class-type">
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                    </select>
                </div>

                <div class="option">
                    <label for="travelers">Traveller</label>
                    <select id="travelers" name="travelers">
                        <option value="1">1 Traveller</option>
                        <option value="2">2 Travellers</option>
                        <option value="3">3 Travellers</option>
                    </select>
                </div> -->

                <div class="option1-container">
                    <div class="option1">
                        <label for="from">From</label>
                        <select id="from" name="from" required>
                            <option value="Delhi">Delhi,Indiragandhi International Airport </option>
                            <option value="Agra civil Airport,kheria">Agra,Agra Civil Airport,kheria</option>
                            <option value="kochi">Kochi,kochi International Airport</option>
                            <option value="pune">Pune,pune International Airport</option>
                            <option value="bhubaneswar">Bhubaneswar,Biju Patnaik Airport</option>
                            <option value="Agra civil Airport,kheria">Ahmedabad,Sardar vallabhbhai patel International Airport</option>
                            <option value="chennai">Chennai,Chennai International Airport</option>
                            <option value="Kozhikode">Kozhikode,Calicut International Airport</option>
                            <!-- Add other departure options -->
                        </select>
                    </div>

                    <div class="option1">
                        <label for="to">To</label>
                        <select id="to" name="to" required>
                            <option value="bhubaneswar">Bhubaneswar,Biju Patnaik Airport</option>
                            <option value="Agra civil Airport,kheria">Ahmedabad,Sardar vallabhbhai patel International Airport</option>
                            <option value="chennai">Chennai,Chennai International Airport</option>
                            <option value="Kozhikode">Kozhikode,Calicut International Airport</option>
                            <option value="Delhi">Delhi,Indiragandhi International Airport</option>
                            <option value="Agra civil Airport,kheria">Agra,Agra Civil Airport,kheria</option>
                            <option value="kochi">kochi,kochi International Airport</option>
                            <option value="pune">Pune,Pune International Airport</option>
                            <!-- Add other arrival options -->
                        </select>
                    </div>

                    <div class="option1">
                        <label for="departure">Departure</label>
                        <input type="date" id="departure" name="departure" required>
                    </div>

                    <!--<div class="option1">
                        <label for="return">Return</label>
                        <input type="date" id="arrival" name="return" >
                    </div> -->
                </div>
                <button>Search Flight</button>
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
   
    // $tripType = isset($_POST['trip-type']) ? htmlspecialchars($_POST['trip-type']) : '';
    // $classType = isset($_POST['class-type']) ? htmlspecialchars($_POST['class-type']) : '';
    // $travelers = isset($_POST['travelers']) ? (int)$_POST['travelers'] : 1;
    $from = isset($_POST['from']) ? htmlspecialchars($_POST['from']) : '';
    $to = isset($_POST['to']) ? htmlspecialchars($_POST['to']) : '';
    $departureDate = isset($_POST['departure']) ? htmlspecialchars($_POST['departure']) : '';
    // $arrivalDate = isset($_POST['arrival']) ? htmlspecialchars($_POST['arrival']) : '';
    
   
    // Validate the inputs
    if (empty($from) || empty($to) || empty($departureDate)) {
        echo "Please fill in all required fields.";
    } else {
        $sql = "SELECT flight_no, departure, d_datetime, arrival, baggage, price
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

    //   if ($result === false) {
    //     echo "Error executing query: " . $stmt->error;
    //   exit;
    //   } else {
    //    echo "Query executed successfully. Rows found: " . $result->num_rows;
    //   }

      
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
                        <td>" . $row["baggage"] . "</td>
                        <td>" . $row["price"] . "</td>
                        <td><a href='login.php'>Login to continue</a></td>
                        <tr>";
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