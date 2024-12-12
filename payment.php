<!--?php
$activeForm = isset($_POST['toggle_form']) ? $_POST['toggle_form'] : 'card';

$message = ''; // To store success or error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Card Payment Validation
    if (isset($_POST['pay_with_card'])) {
        $cardNumber = $_POST['card_number'];
        $expiryMonth = $_POST['expiry_month'];
        $expiryYear = $_POST['expiry_year'];
        $cvv = $_POST['cvv'];

        // Validate card details
        if (strlen($cardNumber) !== 16 || !ctype_digit($cardNumber)) {
            $message = "Invalid card number. Please enter a 16-digit card number.";
        } elseif (!ctype_digit($cvv) || strlen($cvv) !== 3) {
            $message = "Invalid CVV. Please enter a 3-digit CVV.";
        } else {
            // Simulate processing card payment
            $message = "Card payment successful!<br>Card Number: " . htmlspecialchars($cardNumber) . 
                       "<br>Expiry Date: " . htmlspecialchars($expiryMonth) . "/" . htmlspecialchars($expiryYear);
        }
    }

    // UPI Payment Validation
    if (isset($_POST['pay_with_upi'])) {
        $upiId = $_POST['upi_id'];

        // Validate UPI ID
        if (!strpos($upiId, '@')) {
            $message = "Invalid UPI ID. Please enter a valid UPI ID (e.g., username@bank).";
        } else {
            // Simulate processing UPI payment
            $message = "UPI payment successful!<br>UPI ID: " . htmlspecialchars($upiId);
        }
    }
}
?-->

<!--DOCTYPE html-->
<!--html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Process</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; text-align: center; }
        .tabs { display: flex; justify-content: center; margin-top: -4px; }
        .tab { padding: 10px 20px; cursor: pointer; border: 1px solid #ccc; margin: 0 5px; }
        .active-tab { background-color: #ddd; font-weight: bold; }
        .form { display: none; text-align: left; margin: 0 auto; width: 300px; margin-top:30px; }
        .active-form { display: block; }
        .form-group { margin-bottom: 15px; }
        .form-group label { font-size: 14px; }
        .form-group input, .form-group select, .form-group button { width: 100%; padding: 8px; }
        .form-group button { background-color: #6200ea; color: white; border: none; cursor: pointer; }
        h1 { margin: 155px 0 40px 0; color: #6200ea; }
        .notification { margin: 20px auto; width: 80%; max-width: 400px; padding: 10px; border-radius: 5px; font-size: 14px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <h1>P A Y M E N T</h1>

    <!-- Display Notification 
    <!?php if (!empty($message)): ?>
        <div class="notification <!?= strpos($message, 'successful') !== false ? 'success' : 'error' ?>">
            <!?= $message ?>
        </div>
    <!?php endif; ?>

    <div class="tabs">
        <!-- Card Payment Tab 
        <form method="POST" style="display:inline;">
            <input type="hidden" name="toggle_form" value="card">
            <button type="submit" class="tab <!?= $activeForm === 'card' ? 'active-tab' : '' ?>">Card Payment</button>
        </form>
        <!-- UPI Payment Tab 
        <form method="POST" style="display:inline;">
            <input type="hidden" name="toggle_form" value="upi">
            <button type="submit" class="tab <!?= $activeForm === 'upi' ? 'active-tab' : '' ?>">UPI Payment</button>
        </form>
    </div>

    <!-- Credit/Debit Card Form 
    <!?php if ($activeForm === 'card') : ?>
        <div class="form active-form">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Card Number</label>
                    <input type="text" name="card_number" required>
                </div>
                <div class="form-group">
                    <label>Expiry</label>
                    <select name="expiry_month" required>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select name="expiry_year" required>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="password" name="cvv" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="pay_with_card">Pay</button>
                </div>
            </form>
        </div>
    <!?php endif; ?>

    <!-- UPI Payment Form 
    <!?php if ($activeForm === 'upi') : ?>
        <div class="form active-form">
            <form method="POST" action="">
                <div class="form-group">
                    <label>UPI ID</label>
                    <input type="text" name="upi_id" placeholder="username@bank" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="pay_with_upi">Pay</button>
                </div>
            </form>
        </div>
    <!?php endif; ?>
</body>
</html-->
<?php
$activeForm = isset($_POST['toggle_form']) ? $_POST['toggle_form'] : 'card';

$message = ''; 
$showPopup = false; 
$popupMessage = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Card Payment Validation
    if (isset($_POST['pay_with_card'])) {
        $cardNumber = $_POST['card_number'];
        $expiryMonth = $_POST['expiry_month'];
        $expiryYear = $_POST['expiry_year'];
        $cvv = $_POST['cvv'];

        // card no validation
        if (strlen($cardNumber) !== 16 || !ctype_digit($cardNumber)) {
            $message = "Invalid card number. Please enter a 16-digit card number.";
        } elseif (!ctype_digit($cvv) || strlen($cvv) !== 3) {
            $message = "Invalid CVV. Please enter a 3-digit CVV.";
        } else {
            $popupMessage = "Card payment successful!<br>Card Number: " . htmlspecialchars($cardNumber) . 
                             "<br>Expiry Date: " . htmlspecialchars($expiryMonth) . "/" . htmlspecialchars($expiryYear);
            $showPopup = true;
        }
    }

    // UPI Payment Validation
    if (isset($_POST['pay_with_upi'])) {
        $upiId = $_POST['upi_id'];

        // Validate UPI ID
        if (!strpos($upiId, '@')) {
            $message = "Invalid UPI ID. Please enter a valid UPI ID (e.g., username@bank).";
        } else {
            
            $popupMessage = "UPI payment successful!<br>UPI ID: " . htmlspecialchars($upiId);
            $showPopup = true; // Show popup on success
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIFA Airlines-payment process</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; text-align: center; }
        .navbar{ background-color: #6200ea;color: white;padding: 10px;display:flex;font-weight: bold;letter-spacing: 2px;margin:-20px -20px; font-size:20px;}
        .tabs { display: flex; justify-content: center; margin-top: -4px; }
        .tab { padding: 10px 20px; cursor: pointer; border: 1px solid #ccc; margin: 0 5px; }
        .active-tab { background-color: #ddd; font-weight: bold; }
        .form { display: none; text-align: left; margin: 0 auto; width: 300px; margin-top:30px; }
        .active-form { display: block; }
        .form-group { margin-bottom: 15px; }
        .form-group label { font-size: 14px; }
        .form-group input, .form-group select, .form-group button { width: 100%; padding: 8px; }
        .form-group button { background-color: #6200ea; color: white; border: none; cursor: pointer; }
        h1 { margin: 80px 0 40px 0; color: #6200ea; }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup-box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            width: 300px;
        }
        .popup-box .success-icon { font-size: 50px; color: #28a745; }
        .popup-box h2 { margin-top: 10px; font-size: 20px; color: #333; }
        .popup-box p { color: #666; font-size: 14px; margin: 10px 0 20px; }
        .popup-box button { background-color: #6c0072; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .error-message { color: red; font-size: 14px; margin-top: 10px; }
        body.button {
                background-color: white;
                color: black;
                padding: 8px 12px;
                text-align: center;
                margin-left:750px;

            }

    </style>
</head>
<body>
    
    <div class="navbar">
        <h2>FIFA AIRLINES</h2>
        </div>
        <button href="booking.php">Back</button>
    <h1>P A Y M E N T</h1>

    <div class="tabs">
        <form method="POST" style="display:inline;">
            <input type="hidden" name="toggle_form" value="card"required>
            <button type="submit" class="tab <?= $activeForm === 'card' ? 'active-tab' : '' ?>">Card Payment</button>
        </form>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="toggle_form" value="upi" required>
            <button type="submit" class="tab <?= $activeForm === 'upi' ? 'active-tab' : '' ?>">UPI Payment</button>
        </form>
    </div>

    <?php if ($activeForm === 'card') : ?>
        <div class="form active-form">
            <form method="POST" action="" required>
                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number"name="card_number" required>
                </div>
                <div class="form-group">
                    <label>Expiry</label>
                    <select name="expiry_month" required>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select name="expiry_year" required>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="password" id=""name="cvv" required>
                </div>
                <div class="form-group" required>
                    <button type="submit" name="pay_with_card">Pay</button>
                </div>
                <?php if ($message) : ?>
                    <div class="error-message"><?= $message ?></div>
                <?php endif; ?>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($activeForm === 'upi') : ?>
        <div class="form active-form">
            <form method="POST" action="">
                <div class="form-group">
                    <label>UPI ID</label>
                    <input type="text" name="upi_id" placeholder="username@bank" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="pay_with_upi">Pay</button>
                </div>
                <?php if ($message) : ?>
                    <div class="error-message"><?= $message ?></div>
                <?php endif; ?>
            </form>
        </div>
    <?php endif; ?>

    <div id="popupOverlay" class="popup-overlay" <?= $showPopup ? 'style="display: flex;"' : '' ?>>
        <div class="popup-box">
            <div class="success-icon">✔</div>
            <h2>Payment Successful</h2>
            <p><?= $popupMessage ?></p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
        function closePopup() {
            const popupOverlay = document.getElementById('popupOverlay');
            popupOverlay.style.display = 'none';
        }
    </script>
</body>
</html>
