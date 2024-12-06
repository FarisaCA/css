<?php
// Database connection
@include './connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read POST data
    $input = json_decode(file_get_contents('php://input'), true);
    $flightNumber = $input['flight_no'];
    $status = $input['f_status'];

    // Update flight status
    $sql = "UPDATE flight SET f_status = ? WHERE flight_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $status, $flightNumber);
    $stmt->execute();

    // Update booking status
    $updateBookings = "UPDATE booking SET status = ? WHERE flight_no = ?";
    $stmt2 = $conn->prepare($updateBookings);
    $stmt2->bind_param('ss', $status, $flightNumber);
    $stmt2->execute();

    echo json_encode(['success' => true]);
    exit;
}

// Fetch flights for display
$sql = "SELECT flight_no, d_datetime, r_datetime, f_status FROM flight";
$result = $conn->query($sql);
$flights = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights</title>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const flights = <?php echo json_encode($flights); ?>; // Embed PHP array into JavaScript
            const table = document.getElementById('flightsTable');
            
            flights.forEach(flight => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${flight.flight_no}</td>
                    <td>${flight.d_datetime}</td>
                    <td>${flight.r_datetime}</td>
                    <td id="status-${flight.flight_no}">${flight.f_status}</td>
                    <td>
                        <button onclick="updateStatus('${flight.flight_no}', 'Departed')">Mark as Departed</button>
                        <button onclick="updateStatus('${flight.flight_no}', 'Delayed')">Mark as Delayed</button>
                    </td>
                `;
                table.appendChild(row);
            });
        });

        async function updateStatus(flightNumber, status) {
            const response = await fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ flight_number: flightNumber, status })
            });
            const result = await response.json();
            if (result.success) {
                document.getElementById(`status-${flightNumber}`).textContent = status;
            } else {
                alert('Failed to update status.');
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
