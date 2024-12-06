<!DOCTYPE html>
<html>
<head>  
    <link rel="stylesheet" href="manageflight.css">
    <title>Manage Flight</title>
    <style>
        h1{
            color:white;
            font-size:190%;
        }
        li{
            align-items:right;
        }
    </style>
</head>
<body>

    <nav class="navbar">
            <h1>FIFA AIRLINES</h1>
            <a href="fmanager_dashboard.php">Home</a>
    </nav>
    
    <div class="div1">
        <h2>Add Flight</h2>
        <form class="form1" action="" method="post">
            <input class="input1" type="text" name="fno" placeholder="Flight No" required>
            <div class="input1">
                        <label for="from">From</label>
                        <select id="input1" name="from"required>
                            <option value="Delhi,Indiragandhi International Airport">Delhi,Indiragandhi International Airport </option>
                            <option value="Agra civil Airport,kheria">Agra,Agra Civil Airport,kheria</option>
                            <option value="Kochi,kochi International Airport">Kochi,kochi International Airport</option>
                            <option value="Pune,pune International Airport">Pune,pune International Airport</option>
                            <option value="Bhubaneswar,Biju Patnaik Airport">Bhubaneswar,Biju Patnaik Airport</option>
                            <option value="Ahmedabad,Sardar vallabhbhai patel International Airport">Ahmedabad,Sardar vallabhbhai patel International Airport</option>
                            <option value="Chennai,Chennai International Airport">Chennai,Chennai International Airport</option>
                            <option value="Kozhikode,Calicut International Airport">Kozhikode,Calicut International Airport</option>
                            <!-- Add other departure options -->
                        </select>
                </div>

            <input class="input1" type="datetime-local" name="d_datetime" placeholder="departure(date&time)" required>
            <div class="input1">
                        <label for="to">To</label><br>
                        <select id="to" name="to" required>
                            <option value="Bhubaneswar,Biju Patnaik Airport">Bhubaneswar,Biju Patnaik Airport</option>
                            <option value="Ahmedabad,Sardar vallabhbhai patel International Airport">Ahmedabad,Sardar vallabhbhai patel International Airport</option>
                            <option value="Chennai,Chennai International Airport">Chennai,Chennai International Airport</option>
                            <option value="Kozhikode,Calicut International Airport">Kozhikode,Calicut International Airport</option>
                            <option value="Delhi,Indiragandhi International Airport">Delhi,Indiragandhi International Airport</option>
                            <option value="Agra civil Airport,kheria">Agra,Agra Civil Airport,kheria</option>
                            <option value="kochi,kochi International Airport">kochi,kochi International Airport</option>
                            <option value="Pune,Pune International Airport">Pune,Pune International Airport</option>
                            <!-- Add other arrival options -->
                        </select>
                    </div>
            <input class="input1" type="datetime-local" name="r_datetime" placeholder="arrival(date&time)" required>
            <textarea class="input1" name="baggage" placeholder="Enter baggage details (e.g., Cabin: 7kg, Check-in: 20kg)" rows="3"></textarea>
            <input class="input1" type="number" name="price" placeholder="Price" required>
            <input class="sub2" type="submit" name="submit" value="Submit">
        </form>

    <?php
   
   session_start();
   require_once('connect.php');
        
        // Handle form submission for adding a new flight
    if (isset($_POST['submit'])) 
    {
        $f_no = $_POST['fno'];
        $from = $_POST['from'];
        $d_datetime = $_POST['d_datetime'];
        $to = $_POST['to'];
        $r_datetime = $_POST['r_datetime'];
        $baggage = $_POST['baggage'];
        $price = $_POST['price'];
    
        // Insert new flight record
        $sql = "INSERT INTO `flight` (`flight_no`, `departure`,  `d_datetime`, `arrival`, `r_datetime`, `baggage`, `price`, `status`) 
                VALUES ('$f_no', '$from', '$d_datetime', '$to', '$r_datetime', '$baggage', '$price', true)";
        
        if ($conn->query($sql) === FALSE) {
                die("Error inserting new flight: " . $conn->error);
            } else {
                echo "<script>alert('New flight added successfully');</script>";
            }
        // Redirect to the same page to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle form submission
    if (isset($_POST['update'])) { 
        // Get values from POST
        $flight_id = $_POST['flight_id'];  
        $f_no = $_POST['fno'];
        $from = $_POST['from'];
        $d_datetime = $_POST['d_datetime'];
        $to = $_POST['to'];
        $r_datetime = $_POST['r_datetime'];
        $baggage = $_POST['baggage'];
        $price = $_POST['price'];
        
        // Prepare SQL statement (using prepared statements for security)
        $sql = "UPDATE `flight` SET 
                    `flight_no` = ?, 
                    `departure` = ?, 
                    `d_datetime` = ?, 
                    `arrival` = ?, 
                    `r_datetime` = ?, 
                    `baggage` = ?, 
                    `price` = ? 
                WHERE `flight_id` = ?";
        
        // Prepare the query
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param('ssssssss', $f_no, $from, $d_datetime, $to, $r_datetime, $baggage, $price, $flight_id);
    
            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('Record updated successfully');</script>";
            } else {
                echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
            }
    
            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
        }
    
        // Redirect to the same page after updating
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    

        // Fetch and display books
        $sql = "SELECT * FROM flight where `status`=true ";
        $data = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($data) > 0) {  
            echo "<table border='5'>";
            echo "<tr>";
            echo "<th>Flight No</th>";
            echo "<th>Departure</th>";
            echo "<th>Departure Date & Time</th>";
            echo "<th>Arrival</th>";
            echo "<th>Arrival Date & Time</th>";
            echo "<th>Baggage Details</th>";
            echo "<th>Price</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($data)) {
                echo "<form action='' method='post'>";
                echo"<input type='hidden'name='flight_id' value=" . $row['flight_id'] .">";
                echo "<tr>";
                echo "<td><input class='input2' type='text' name='fno' value=" . htmlspecialchars($row['flight_no'], ENT_QUOTES) ." required></td>";
                echo "<td style='width: 15%;'><input class='input2' type='textarea' name='from' value='" . htmlspecialchars($row['departure'], ENT_QUOTES) . "' required></td>";
                
                //change th format in table to th:i format
                $d_datetime = new DateTime($row['d_datetime']);
                $d_datetime_formatted = $d_datetime->format('Y-m-d\TH:i');

                echo "<td><input class='input2' type='datetime-local' name='d_datetime' value='$d_datetime_formatted' required></td>";
                echo "<td style='width: 15%;'><input class='input2' type='textarea' name='to' value='" . htmlspecialchars($row['arrival'], ENT_QUOTES) . "' required></td>";
                 
                //change th format in table to th:i format
                $r_datetime = new DateTime($row['r_datetime']);
                $r_datetime_formatted = $r_datetime->format('Y-m-d\TH:i');

                echo "<td><input class='input2' type='datetime-local' name='r_datetime' value='$r_datetime_formatted' required></td>";
                echo "<td><input class='input2' type='textarea' name='baggage'value=". htmlspecialchars($row['baggage'], ENT_QUOTES) ." required></td>";
                echo "<td><input class='input2' type='number' name='price'  value=". htmlspecialchars($row['price'], ENT_QUOTES) ." required></td>";
                echo "<td><button type='submit' name='update'>UPDATE</button></td>"; 
                echo "<td><button type='submit' name='delete'>DELETE</button></td>"; 
                echo "</tr>";
                echo"</form>";
            }
            echo "</table>";
        }
        
    if (isset($_POST['delete']))
    {
        $f_no = $_POST['fno'];
        $sql="UPDATE `flight` SET `status`=false WHERE `flight_no`='$f_no'";
        if($conn->query($sql)==FALSE){
            die("error updating value:".$conn->error);
          }else{
            echo "<script>alert('flight details removed successfully')</script>";
          }
          header("Location: " . $_SERVER['PHP_SELF']);
    exit();
    }
 ?>
    </div>
</body>
</html>