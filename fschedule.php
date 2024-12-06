<?php
// db connection
@include './connect.php';

// Fetch flights
$sql = "SELECT flight_number, departure_datetime, arrival_datetime, status FROM flight";
$result = $conn->query($sql);
$flights = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
}
echo json_encode($flights);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights</title>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchFlights();

            async function fetchFlights() {
                const response = await fetch('fetch_flights.php');
                const flights = await response.json();
                const table = document.getElementById('flightsTable');
                
                flights.forEach(flight => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${flight.flight_number}</td>
                        <td>${flight.departure_datetime}</td>
                        <td>${flight.arrival_datetime}</td>
                        <td id="status-${flight.flight_number}">${flight.status}</td>
                        <td>
                            <button onclick="updateStatus('${flight.flight_number}', 'Departed')">Mark as Departed</button>
                        </td>
                    `;
                    table.appendChild(row);
                });
            }
        });

        async function updateStatus(flightNumber, status) {
            const response = await fetch('update_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ flight_number: flightNumber, status })
            });
            const result = await response.json();
            if (result.success) {
                document.getElementById(`status-${flightNumber}`).textContent = status;
            }
        }
    </script>
</head>
<body>
    <h1>Manage Flight Scheduling</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Flight Number</th>
                <th>Departure DateTime</th>
                <th>Arrival DateTime</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="flightsTable"></tbody>
    </table>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flightNumber = $_POST['flight_number'];
    $status = $_POST['status'];

    $sql = "UPDATE flight SET status = ? WHERE flight_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $status, $flightNumber);
    $stmt->execute();

    // Update bookings
    $updateBookings = "UPDATE booking SET status = ? WHERE flight_number = ?";
    $stmt2 = $conn->prepare($updateBookings);
    $stmt2->bind_param('ss', $status, $flightNumber);
    $stmt2->execute();

    echo json_encode(['success' => true]);
}
?>

