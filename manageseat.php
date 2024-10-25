<?php
session_start();

// Initialize seat data
if (!isset($_SESSION['seats'])) {
    $_SESSION['seats'] = [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $row_no = $_POST['row_no'];
        $seat_type = $_POST['seat_type'];
        $rate = $_POST['rate'];

        $_SESSION['seats'][] = [
            'row_no' => $row_no,
            'seat_type' => $seat_type,
            'rate' => $rate
        ];
    } elseif (isset($_POST['delete'])) {
        $index = $_POST['index'];
        unset($_SESSION['seats'][$index]);
        $_SESSION['seats'] = array_values($_SESSION['seats']); // Reindex the array
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manageseat.css">
    <title>Seat Management</title>
    <style>
        table { width: 50%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h2>Manage Flight Seats</h2>
<li><a href="#bookings">Manage Bookings</a></li>
<form method="POST">
    <label for="row_no">Row No:</label>
    <input type="text" name="row_no" required>
    <label for="seat_type">Seat Type:</label>
    <input type="text" name="seat_type" required>
    <label for="rate">Rate:</label>
    <input type="number" name="rate" required>
    <button type="submit" name="add">Add Seat</button>
</form>

<h3>Seat List</h3>
<table>
    <tr>
        <th>Row No</th>
        <th>Seat Type</th>
        <th>Rate</th>
        <th>Action</th>
    </tr>
    <?php if (!empty($_SESSION['seats'])): ?>
        <?php foreach ($_SESSION['seats'] as $index => $seat): ?>
            <tr>
                <td><?php echo htmlspecialchars($seat['row_no']); ?></td>
                <td><?php echo htmlspecialchars($seat['seat_type']); ?></td>
                <td><?php echo htmlspecialchars($seat['rate']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No seats added yet.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
