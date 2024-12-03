<!--?php
@include './connect.php';  // Include your database connection

//session_start();

// Initialize form values
$name = $gender = $dob = $email = $class = $letters = $numbers = '';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure database connection is successful
if ($conn) {
    echo"connected";
}

if (isset($_POST['submit'])) {
  

    // Collect form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $letters = $_POST['letters'];
    $numbers = $_POST['numbers'];
   // $flight_id = $_SESSION['flight_id'];


    //Check if flight_id is set in session
  // if (!isset($_SESSION['flight_id'])) {
      //echo "Flight ID is not set.";
     // exit;
    
  // }
   
    // Insert query
    $insertQuery = "INSERT INTO `booking`(  `name`, `gender`, `dob`, `email`, `class`, `letters`, `numbers`) 
    VALUES ( '$name', '$gender', '$dob', '$email', '$class', '$letters', '$numbers')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "One row inserted";

        // Get the most recent booking to retrieve the booking ID
        //$sql = "SELECT * FROM `booking` WHERE flight_id = $flight_id ORDER BY book_id DESC LIMIT 1";
        $data = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($data);

        $book_id = $row['book_id'];
        $_SESSION['book_id'] = $book_id; // Save the booking ID in session

        // Optionally redirect after successful booking
        // header("Location: decor.php");
        exit;
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

// Close the database connection
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

    <!- Display error messages -->
    <!-- ?php if (!empty($error)): ?->
        <div class="error">
            <!?php foreach ($error as $err): ?>
                <p><!?= htmlspecialchars($err) ?></p>
            <!?php endforeach; ?>
        </div>
    <!?php endif; ?>

    <!- Display success messages 
    <!?php if (!empty($success)): ?>
        <div class="success">
            <!?php foreach ($success as $msg): ?>
                <p><!?= htmlspecialchars($msg) ?></p>
            <!?php endforeach; ?>
        </div>
    <!?php endif; ?>

    <form method="POST">
      <div class="input">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<!?= htmlspecialchars($name) ?>" required>
      </div>

      <div class="radio-group">
        <label class="radio-container">Male
            <input type="radio" name="gender" value="male" <!?= $gender === 'male' ? 'checked' : '' ?> required>
        </label>
        <label class="radio-container">Female
            <input type="radio" name="gender" value="female" <!?= $gender === 'female' ? 'checked' : '' ?> required>
        </label>
        <label class="radio-container">Other
            <input type="radio" name="gender" value="other" <!?= $gender === 'other' ? 'checked' : '' ?> required>
        </label>
      </div>

      <div class="input">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<!?= htmlspecialchars($dob) ?>" required>
      </div>

      <div class="input">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<!?= htmlspecialchars($email) ?>" required>
      </div>

      <div class="input">
        <label for="flight">Flight:</label>
        <input type="text" id="flight" class="disabled-input" disabled>
      </div>

      <div class="input">
        <label for="price">Price:</label>
        <input type="text" id="price" class="disabled-input" disabled>
      </div>

      <div class="input">
        <label for="class">Class:</label>
        <select name="class" class="select" required>
            <option value="economy" <!?= $class === 'economy' ? 'selected' : '' ?>>Economy</option>
            <option value="business" <!?= $class === 'business' ? 'selected' : '' ?>>Business</option>
        </select>
      </div>  

      <div class="input">
        <label for="letters">Seat:</label>
        <select name="letters" required>
            <option value="A" <!?= $letters === 'A' ? 'selected' : '' ?>>A</option>
            <option value="B" <!?= $letters === 'B' ? 'selected' : '' ?>>B</option>
            <option value="C" <!?= $letters === 'C' ? 'selected' : '' ?>>C</option>
            <option value="D" <!?= $letters === 'D' ? 'selected' : '' ?>>D</option>
            <option value="E" <!?= $letters === 'E' ? 'selected' : '' ?>>E</option>
            <option value="F" <!?= $letters === 'F ' ? 'selected' : '' ?>>F</option>
        </select>
        <select name="numbers" required>
            <!-?php for ($i = 1; $i <= 20; $i++): ?>
                <option value="<!-?= $i ?->" <!-?= (int)$numbers === $i ? 'selected' : '' ?->><!-?= $i ?-></option>
            <!-?php endfor; ?->
        </select>
      </div>

      <button type="submit" name="submit">Book</button>
    </form>
  </div>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('flight').value = urlParams.get('flight_no') || '';
    document.getElementById('price').value = urlParams.get('price') || '';
  </script>

</body>
</html><-->
 <!-- Retrieve flight details from session
if (isset($_SESSION['flight_no']) && isset($_SESSION['price'])) {
    $flight_no = $_SESSION['flight_no'];
    $price = $_SESSION['price'];
} -->
<?php
@include './connect.php';  // Include your database connection

session_start();

// Initialize form values
$name = $gender = $dob = $email = $class = $letters = $numbers = '';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure database connection is successful
if ($conn) {
    echo"connected";
}

if (isset($_POST['submit'])) {
  

    // Collect form data
    $name = $_POST['name'];
    $flight_id=$_POST['flight_id'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $letters = $_POST['letters'];
    $numbers = $_POST['numbers'];
   // $flight_id = $_SESSION['flight_id'];


    //Check if flight_id is set in session
  // if (!isset($_SESSION['flight_id'])) {
      //echo "Flight ID is not set.";
     // exit;
    
  // }
   
    // Insert query
    $insertQuery = "INSERT INTO booking(  name,flight_id, gender, dob, email, class, letters, numbers) 
    VALUES ( '$name','$flight_id','$gender', '$dob', '$email', '$class', '$letters', '$numbers')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "One row inserted";

        // Get the most recent booking to retrieve the booking ID
        $sql = "SELECT * FROM booking WHERE flight_id = $flight_id ORDER BY book_id DESC LIMIT 1";
        $data = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($data);

        $book_id = $row['book_id'];
        $_SESSION['book_id'] = $book_id; // Save the booking ID in session

        // Optionally redirect after successful booking
        // header("Location: decor.php");
        exit;
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

// Close the database connection
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

    <!-- Display error messages -->
    <?php if (!empty($error)): ?>
        <div class="error">
            <?php foreach ($error as $err): ?>
                <p><?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Display success messages -->
    <?php if (!empty($success)): ?>
        <div class="success">
            <?php foreach ($success as $msg): ?>
                <p><?= htmlspecialchars($msg) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
    <?php $flight_id = isset($_GET['flight_id']) ? htmlspecialchars($_GET['flight_id']) : '';?>
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
        <input type="text" id="flight" class="disabled-input" disabled>
      </div>

      <div class="input">
        <label for="price">Price:</label>
        <input type="text" id="price" class="disabled-input" disabled>
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
            <option value="F" <?= $letters === 'F ' ? 'selected' : '' ?>>F</option>
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

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('flight').value = urlParams.get('flight_no') || '';
    document.getElementById('price').value = urlParams.get('price') || '';
  </script>

</body>
</html>
 <!-- Retrieve flight details from session
if (isset($_SESSION['flight_no']) && isset($_SESSION['price'])) {
    $flight_no = $_SESSION['flight_no'];
    $price = $_SESSION['price'];
} -->