<?php

@include './connect.php';

session_start();

// Initialize variables
$name = '';
$gender = '';
$dob = '';
$email = '';
$flight_no = '';
$price = '';
$type = '';
$seat = '';
$error = [];
$success = [];

// Retrieve flight details from session
if (isset($_SESSION['flight_no']) && isset($_SESSION['price'])) {
    $flight_no = $_SESSION['flight_no'];
    $price = $_SESSION['price'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $gender = htmlspecialchars($_POST['gender']);
    $dob = htmlspecialchars($_POST['dob']);
    $email = htmlspecialchars($_POST['email']);
    $type = htmlspecialchars($_POST['class']);
    $seat_letter = htmlspecialchars($_POST['letters']);
    $seat_number = htmlspecialchars($_POST['numbers']);
    $seat = $seat_letter . $seat_number;

    // Validate inputs
    if (empty($name) || empty($gender) || empty($dob) || empty($email) || empty($type) || empty($seat)) {
        $error[] = 'Please fill in all the required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Invalid email format.';
    }

    // Check for seat availability
    if (empty($error)) {
        $seat_check_query = $conn->prepare("SELECT * FROM booking WHERE flight = ? AND seat = ?");
        $seat_check_query->bind_param("ss", $flight_no, $seat);
        $seat_check_query->execute();
        $seat_check_result = $seat_check_query->get_result();
        if ($seat_check_result->num_rows > 0) {
            $error[] = 'The selected seat is already booked. Please choose a different seat.';
        }
    }

    // Insert booking into the database
    if (empty($error)) {
        $insert_query = $conn->prepare("INSERT INTO booking (name, gender, dob, email, flight_no, price, type,date) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_query->bind_param("ssssss", $name, $gender, $dob, $email, $flight_no, $price, $type, $date);
        if ($insert_query->execute()) {
            $success[] = 'Booking successful!';
        } else {
            $error[] = 'Booking failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Booking</title>
  <link rel="stylesheet" href="./booking.css">
</head>
<body>

  <div class="navbar">
    <h1 class="brand_logo">FIFA Airlines</h1>
    <a class="home_btn" href="dashboard_user.php">Home</a>
  </div>

  <div class="form-container">
    <h2>Book Your Flight</h2>

    <!-- Display error messages -->
    <?php if (!empty($error)): ?>
        <div class="error">
            <?php foreach ($error as $err) echo "<p>$err</p>"; ?>
        </div>
    <?php endif; ?>

    <!-- Display success messages -->
    <?php if (!empty($success)): ?>
        <div class="success">
            <?php foreach ($success as $msg) echo "<p>$msg</p>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
      <div class="input">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
      </div>

      <div class="radio-group">
        <label class="radio-container">Male
            <input type="radio" name="gender" value="male" <?= $gender === 'male' ? 'checked' : '' ?>>
        </label>
        <label class="radio-container">Female
            <input type="radio" name="gender" value="female" <?= $gender === 'female' ? 'checked' : '' ?>>
        </label>
        <label class="radio-container">Other
            <input type="radio" name="gender" value="other" <?= $gender === 'other' ? 'checked' : '' ?>>
        </label>
      </div>

      <div class="input">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($dob) ?>" required>
      </div>

      <div class="input">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
      </div>

      <div class="input">
        <label for="flight">Flight:</label>
        <input type="text" id="flight" class="disabled-input" value="<?= htmlspecialchars($flight_no) ?>" disabled>
      </div>

      <div class="input">
        <label for="price">Price:</label>
        <input type="text" id="price" class="disabled-input" value="₹<?= htmlspecialchars($price) ?>" disabled>
      </div>

      <div class="input">
        <label for="class">Class:</label>
        <select name="class" class="select">
            <option value="economy" <?= $type === 'economy' ? 'selected' : '' ?>>Economy</option>
            <option value="business" <?= $type === 'business' ? 'selected' : '' ?>>Business</option>
        </select>
      </div>  

      <div class="input">
        <label for="letters">Seat:</label>
        <select name="letters">
            <option value="A" <?= substr($seat, 0, 1) === 'A' ? 'selected' : '' ?>>A</option>
            <option value="B" <?= substr($seat, 0, 1) === 'B' ? 'selected' : '' ?>>B</option>
            <option value="C" <?= substr($seat, 0, 1) === 'C' ? 'selected' : '' ?>>C</option>
            <option value="D" <?= substr($seat, 0, 1) === 'D' ? 'selected' : '' ?>>D</option>
            <option value="E" <?= substr($seat, 0, 1) === 'E' ? 'selected' : '' ?>>E</option>
            <option value="F" <?= substr($seat, 0, 1) === 'F' ? 'selected' : '' ?>>F</option>
        </select>
        <select name="numbers">
            <option value="1" <?= substr($seat, 1) === '1' ? 'selected' : '' ?>>1</option>
            <option value="2" <?= substr($seat, 1) === '2' ? 'selected' : '' ?>>2</option>
            <option value="3" <?= substr($seat, 1) === '3' ? 'selected' : '' ?>>3</option>
            <option value="3" <?= substr($seat, 1) === '4' ? 'selected' : '' ?>>4</option>
            <option value="3" <?= substr($seat, 1) === '5' ? 'selected' : '' ?>>5</option>
            <option value="3" <?= substr($seat, 1) === '6' ? 'selected' : '' ?>>6</option>
            <option value="3" <?= substr($seat, 1) === '7' ? 'selected' : '' ?>>7</option>
            <option value="3" <?= substr($seat, 1) === '8' ? 'selected' : '' ?>>8</option>
            <option value="3" <?= substr($seat, 1) === '9' ? 'selected' : '' ?>>9</option>
            <option value="3" <?= substr($seat, 1) === '10' ? 'selected' : '' ?>>10</option>
            <option value="3" <?= substr($seat, 1) === '11' ? 'selected' : '' ?>>11</option>
            <option value="3" <?= substr($seat, 1) === '12' ? 'selected' : '' ?>>12</option>
            <option value="3" <?= substr($seat, 1) === '13' ? 'selected' : '' ?>>13</option>
            <option value="3" <?= substr($seat, 1) === '14' ? 'selected' : '' ?>>14</option>
            <option value="3" <?= substr($seat, 1) === '15' ? 'selected' : '' ?>>15</option>
            <option value="3" <?= substr($seat, 1) === '16' ? 'selected' : '' ?>>16</option>
            <option value="3" <?= substr($seat, 1) === '17' ? 'selected' : '' ?>>17</option>
            <option value="3" <?= substr($seat, 1) === '18' ? 'selected' : '' ?>>18</option>
            <option value="3" <?= substr($seat, 1) === '19' ? 'selected' : '' ?>>19</option>
            <option value="3" <?= substr($seat, 1) === '20' ? 'selected' : '' ?>>20</option>
            <!-- Add more options as needed -->
        </select>
      </div>

      <button type="submit">Book</button>
    </form>
  </div>

  <div>
    <img src="airplane-flight.png" alt="A beautiful landscape" class="seat_img">
  </div>

</body>
</html>
