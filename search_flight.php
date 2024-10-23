<!--DOCTYPE html>
<html>
<head>
	<title>Flight Search</title>
</head>
<body>
	<form action="search_flights.php" method="post">
		<label>Departure:</label>
		<select name="departure">
			<option value="">Select Departure</option>
			<option value="New York">New York</option>
			<option value="Los Angeles">Los Angeles</option>
			<option value="Chicago">Chicago</option>
		</select>
		<br><br>
		<label>Arrival:</label>
		<select name="arrival">
			<option value="">Select Arrival</option>
			<option value="New York">New York</option>
			<option value="Los Angeles">Los Angeles</option>
			<option value="Chicago">Chicago</option>
		</select>
		<br><br>
		<label>Date:</label>
		<input type="date" name="date">
		<br><br>
		<label>Time:</label>
		<input type="time" name="time">
		<br><br>
		<input type="submit" name="search_flight" value="Search Flight">
	</form>
</body>
</html-->

<?php
require_once('connect.php');

// Get user input
$departure = $_POST['departure'];
$arrival = $_POST['arrival'];
$date = $_POST['date'];
$time = $_POST['time'];

// SQL query to fetch flights
$sql = "SELECT * FROM flight 
        WHERE departure = '$departure' 
        AND arrival = '$arrival' 
        AND date = '$date' 
        AND time = '$time'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Flight ID</th><th>Departure</th><th>Arrival</th><th>Date</th><th>Time</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['flight_id'] . "</td>";
        echo "<td>" . $row['departure'] . "</td>";
        echo "<td>" . $row['arrival'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['time'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No flights found";
}

$conn->close();
?>