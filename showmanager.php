<?php
// Include your database connection file
@include './connect.php';

// Fetch all managers with status = 1 (active)
$query = "SELECT * FROM manager_reg WHERE status = 1";
$result = mysqli_query($conn, $query);

// Handle delete action (based on email as primary key)
if (isset($_GET['delete_id'])) {
    $email = $_GET['delete_id'];  // Now using email
    $updateQuery = "UPDATE manager_reg SET status = 0 WHERE email = '$email'";  // Update where email matches
    mysqli_query($conn, $updateQuery);
    header('Location: showmanager.php'); // Reload the page after delete
}

// Handle edit action (based on email as primary key)
if (isset($_GET['edit_id'])) {
    $email = $_GET['edit_id'];  // Now using email
    $editQuery = "SELECT * FROM manager_reg WHERE email = '$email'";  // Select manager by email
    $editResult = mysqli_query($conn, $editQuery);
    $editData = mysqli_fetch_assoc($editResult);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];  // Email stays unchanged
        $number = $_POST['number'];
        $address = $_POST['address'];
        $updateQuery = "UPDATE manager_reg SET name='$name', email='$email', number='$number', address='$address' WHERE email = '$email'";
        mysqli_query($conn, $updateQuery);
        header('Location: showmanager.php'); // Reload page after update
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIFA AIRLINES - Manage Managers</title>
    <link rel="stylesheet" href="showmanager.css"> <!-- Include your CSS file -->
</head>
<body>
    <header>
        <h1>FIFA AIRLINES</h1>
        <nav>
            <a href="admin.php">Back to Dashboard</a>
            <a href="index.php?logout=true">Log out</a> <!-- Logout button -->
        </nav>
    </header>

    <h2 style="color:070955c4;">MANAGERS LIST</h2>

    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['number']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                        <!-- Edit form, using email as a unique identifier -->
                        <form method="GET" style="display:inline;">
                            <input type="hidden" name="edit_id" value="<?php echo $row['email']; ?>">
                            <button type="submit">Edit</button>
                        </form> 
                        
                        <!-- Delete form, using email as a unique identifier -->
                        <form method="GET" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this manager?')">
                            <input type="hidden" name="delete_id" value="<?php echo $row['email']; ?>">
                            <button type="submit" class="dlt-button">Delete</button>
                        </form> 
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['edit_id'])): ?>
        <h3 class="manager">Edit Manager</h3>
        <form method="POST" class="form-man">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $editData['name']; ?>" required><br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $editData['email']; ?>" required><br>
            <label>Phone Number:</label>
            <input type="text" name="number" value="<?php echo $editData['number']; ?>" required><br>
            <label>Address:</label>
            <textarea name="address" required><?php echo $editData['address']; ?></textarea><br>
            <input type="submit" value="Update">
        </form>
    <?php endif; ?>
</body>
</html>
