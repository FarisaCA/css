<?php

@include './connect.php';

session_start();

// Retrieve data from query parameters (Optional PHP fallback for debugging purposes)
if (isset($_GET['flight_no']) && isset($_GET['price'])) {
  $flight_no = htmlspecialchars($_GET['flight_no']);
  $price = htmlspecialchars($_GET['price']);
} else {
  $flight_no = $price = '';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Booking</title>
  <link rel="stylesheet" href="./booking.css">
  <style>
   
  </style>
</head>
<body>

  <div class="navbar">

    <h1 class="brand_logo">FIFA Airlines</h1>
    <a class="home_btn" href="dashboard_user.php">Home</a>
  </div>

  <div class="form-container">
    <h2>Book Your Flight</h2>
    <form>
      <div class="input">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      </div>

      <div class="radio-group">
                 <label class="radio-container">Male
                     <input type="radio" name="gender" value="male" checked>
                     <span class="checkmark"></span>
                 </label>
                 <label class="radio-container">Female
                    <input type="radio" name="gender" value="female">
                    <span class="checkmark"></span>
                </label>
                <label class="radio-container">Other
                     <input type="radio" name="gender" value="other" >
                     <span class="checkmark"></span>
                 </label>
            </div>

      <div class="input">
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" required>
      </div>
       
      <div class="input">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
      </div>

      <div class="input">
        <label for="flight">Flight:</label>
        <input type="text" id="flight"  class="disabled-input" disabled>
    </div>

    <div class="input">
        <label for="price">Price:</label>
        <input type="text" id="price"  class="disabled-input" disabled>
    </div>
      
      <div class="input">
          <label for="class">Class:</label>
          <select class="select">
              <option value="economy">Economy</option>
              <option value="business">Business</option>
          </select>
      </div>  

      <div class="input">
        <label for="letters">Seat:</label>
        <!-- Dropdown for alphabets -->
        <select  name="letters">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
        </select>

        <!-- Dropdown for numbers -->
        <select  name="numbers">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
        </select>
      </div>


      <button type="submit">Book</button>
    </form>
  </div>

  <div><img src="airplane-flight.png" alt="A beautiful landscape" class="seat_img"></div>
  
  <script>
    // Function to extract query parameters from the URL
    function getQueryParams() {
        const params = new URLSearchParams(window.location.search);
        return {
            flightNo: params.get('flight_no'),
            price: params.get('price'),
        };
    }

    // Populate the input fields with the flight and price details
    document.addEventListener("DOMContentLoaded", () => {
        const { flightNo, price } = getQueryParams();
        
        // Set values in the input fields
        if (flightNo) {
            document.getElementById('flight').value = flightNo;
        }
        if (price) {
            document.getElementById('price').value = `₹${price}`;
        }
    });
  </script>
</body>
</html>
