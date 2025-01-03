<?php
@include './connect.php';
session_start();

$name = $gender = $dob = $email = $class = $letters = $numbers = '';
$error_message = ''; 

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure database connection is successful
// if ($conn) {
//     echo"connected";
// }

if (isset($_POST['submit'])) {
   
    $name = $_POST['name'];
    $flight_id = $_POST['flight_id'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $letters = $_POST['letters'];
    $numbers = $_POST['numbers'];
    $seat = $letters . $numbers;

    $sql_check_seat = "SELECT * FROM booking WHERE seat = '$seat' AND class='$class' AND flight_id = '$flight_id'";
    $result = mysqli_query($conn, $sql_check_seat);
    
    if (mysqli_num_rows($result) > 0) {
        //  error message without using exit() to keep the page open
        $error_message = "The seat $seat is already booked for flight $flight_id. Please choose another seat.";
    } 
    else {
        $insertQuery = "INSERT INTO booking (flight_id, name, gender, dob, email, class, seat) 
                        VALUES ('$flight_id', '$name', '$gender', '$dob', '$email', '$class', '$seat')";

        if ($conn->query($insertQuery) === TRUE) {

            $sql = "SELECT * FROM booking WHERE flight_id = $flight_id ORDER BY book_id DESC LIMIT 1";
            $data = mysqli_query($conn, $sql);
            
            if ($data) {
                $row = mysqli_fetch_array($data);
                $book_id = $row['book_id'];
                $_SESSION['book_id'] = $book_id; 
            } else {
                echo "Error retrieving booking: " . mysqli_error($conn);
            }

            $_SESSION['success_message'] = "Congratulations! Your flight booking is complete. Please proceed to the payment page to finalize your reservation.";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}

$conn->close();
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


    <?php if ($error_message): ?>
        <div class="error-message">
            <script>
                alert("<?php echo $error_message; ?>");
            </script>
        </div>
    <?php endif; ?>

   
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message">
            <script>
                alert("<?php echo $_SESSION['success_message']; ?>");
                setTimeout(function() {
                    window.location.href = "payment.php";  // Redirect to payment page after 2 seconds
                }, 2000);
            </script>
        </div>
        <?php unset($_SESSION['success_message']);?>
    <?php endif; ?>

    <form method="POST">
    <?php 
        $flight_id = isset($_GET['flight_id']) ? htmlspecialchars($_GET['flight_id']) : ''; 
        $flight_no = isset($_GET['flight_no']) ? htmlspecialchars($_GET['flight_no']) : '';
        $price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '';
    ?>
      <div class="input">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
      </div>
      <input type="hidden" name="flight_id" value="<?= $flight_id ?>">
      <div class="radio-group">
        <label class="radio-container">Male
            <input type="radio" name="gender" value="male" <?= $gender === 'male' ? 'checked' : '' ?> required>
        </label>
        <label class="radio-container">Female
            <input type="radio" name="gender" value="female" <?= $gender === 'female' ? 'checked' : '' ?> required>
        </label>
        <label class="radio-container">Other
            <input type="radio" name="gender" value="other" <?= $gender === 'other' ? 'checked' : '' ?> required>
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
        <input type="text" name="flight_no" value="<?= $flight_no ?>" readonly>
      </div>

      <div class="input">
        <label for="price">Price:</label>
        <input type="text" id="price" class="disabled-input" value="<?= $price ?>" readonly>
      </div>

      <div class="input">
        <label for="class">Class:</label>
        <select name="class" class="select" required>
            <option value="economy" <?= $class === 'economy' ? 'selected' : '' ?>>Economy</option>
            <option value="business" <?= $class === 'business' ? 'selected' : '' ?>>Business</option>
        </select>
      </div>  

      <div class="input">
        <label for="letters">Seat:</label>
        <select name="letters" required>
            <option value="A" <?= $letters === 'A' ? 'selected' : '' ?>>A</option>
            <option value="B" <?= $letters === 'B' ? 'selected' : '' ?>>B</option>
            <option value="C" <?= $letters === 'C' ? 'selected' : '' ?>>C</option>
            <option value="D" <?= $letters === 'D' ? 'selected' : '' ?>>D</option>
            <option value="E" <?= $letters === 'E' ? 'selected' : '' ?>>E</option>
            <option value="F" <?= $letters === 'F' ? 'selected' : '' ?>>F</option>
            <option value="P" <?= $letters === 'P' ? 'selected' : '' ?>>P</option>
            <option value="Q" <?= $letters === 'Q' ? 'selected' : '' ?>>Q</option>
            <option value="R" <?= $letters === 'R' ? 'selected' : '' ?>>R</option>
            <option value="S" <?= $letters === 'S' ? 'selected' : '' ?>>S</option>
        </select>
        <select name="numbers" required>
            <?php for ($i = 1; $i <= 20; $i++): ?>
                <option value="<?= $i ?>" <?= (int)$numbers === $i ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
      </div>
       
      <button type="submit" name="submit">Book</button>
    </form>
  </div>
  <img src="seat-new.png" class="seat_image" alt="This is seat image">
</body>
</html>
