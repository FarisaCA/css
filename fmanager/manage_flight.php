<!DOCTYPE html>
<html>
<head>  
    <link rel="stylesheet" href="../css/manageflight.css">
    <title>Manage Flight</title>
    <style>
        h1{
            color:white;
            /* padding:5px; */
            /* margin-left:-1080px; */
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
            <a>Home</a>
    </nav>
    
    <div class="div1">
        <h2>Add Flight</h2>
        <form class="form1" action="" method="post">
            <input class="input1" type="text" name="fno" placeholder="Flight No" required>
            <input class="input1" type="textarea" name="from" placeholder="From" required>
            <input class="input1" type="datetime-local" name="d_datetime" placeholder="departure(date&time)" required>
            <!-- <input class="input1" type="date" name="d_date" placeholder="Departure Date" required>
            <input class="input1" type="time" name="d_time" placeholder="Departure time" required> -->
            <input class="input1" type="textarea" name="to" placeholder="To" required>
            <input class="input1" type="datetime-local" name="r_datetime" placeholder="arrival(date&time)" required>
            <!-- <input class="input1" type="date" name="a_date" placeholder="Return Date" required>
            <input class="input1" type="time" name="a_time" placeholder="Return Time" required> -->
            <textarea class="input1" name="baggage" placeholder="Enter baggage details (e.g., Cabin: 7kg, Check-in: 20kg)" rows="3"></textarea>
            <input class="input1" type="number" name="price" placeholder="Price" required>
            <input class="sub2" type="submit" name="submit" value="Submit">
        </form>
    <?php
        require_once('connect.php');
        // Handle form submission for adding a new flight
       if (isset($_POST['submit'])) {
    $f_no = $_POST['fno'];
    $from = $_POST['from'];
    $d_datetime = $_POST['d_datetime'];
    // $d_date = $_POST['d_date'];
    // $d_time = $_POST['d_time'];
    $to = $_POST['to'];
    $r_datetime = $_POST['r_datetime'];
    // $a_date = $_POST['a_date'];
    // $a_time = $_POST['a_time'];
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
            $flight_id = $_POST['flight_id'];  // Get flight_id from the hidden input field
            $f_no = $_POST['fno'];
            $from = $_POST['from'];
            // $d_date = $_POST['d_date'];
            // $d_time = $_POST['d_time'];
            $d_datetime = $_POST['d_datetime'];
            $to = $_POST['to'];
            $r_datetime = $_POST['r_datetime'];
            // $a_date = $_POST['a_date'];
            // $a_time = $_POST['a_time'];
            $baggage = $_POST['baggage'];
            $price = $_POST['price'];
            
            // Update the flight record with the specified flight_id
            $sql = "UPDATE `flight` SET 
                    `flight_no` = '$f_no',
                    `departure` = '$from',
                    `d_datetime` = '$d_datetime',
                    -- `d_date` = '$d_date',
                    -- `d_time` = '$d_time',
                    `arrival` = '$to',
                    -- `a_date` = '$a_date',
                    -- `a_time` = '$a_time',
                    `r_datetime` = '$r_datetime',
                    `baggage` = '$baggage',
                    `price` = '$price' 
                    WHERE `flight_id` = '$flight_id'";
            
            if ($conn->query($sql) === FALSE) {
                die("Error updating value: " . $conn->error);
            } else {
                echo "<script>alert('Record updated successfully');</script>";
            }
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
                echo "<td style='width: 15%;'><input class='input2' type='textarea' name='from' value=" . htmlspecialchars($row['departure'], ENT_QUOTES) . "' required></td>";

                $d_datetime = new DateTime($row['d_datetime']);
                $d_datetime_formatted = $d_datetime->format('Y-m-d\TH:i');
                echo "<td><input class='input2' type='datetime-local' name='d_datetime' value='$d_datetime_formatted' required></td>";

                // echo "<td><input class='input2' type='date' name='d_date' value=" . $row['d_date'] . " required></td>";
                // echo "<td><input class='input2' type='time' name='d_time' value=".$row['d_time'] ." required></td>";
                echo "<td style='width: 15%;'><input class='input2' type='textarea' name='to' value='" . htmlspecialchars($row['arrival'], ENT_QUOTES) . "' required></td>";

                $r_datetime = new DateTime($row['r_datetime']);
                $r_datetime_formatted = $r_datetime->format('Y-m-d\TH:i');
                echo "<td><input class='input2' type='datetime-local' name='r_datetime' value='$r_datetime_formatted' required></td>";

                // echo "<td><input class='input2' type='date' name='a_date' value=" . $row['a_date'] . " required></td>";
                // echo "<td><input class='input2' type='time' name='a_time' value=" .$row['a_time'] ." required></td>";
                echo "<td><input class='input2' type='textarea' name='baggage'value=". htmlspecialchars($row['baggage'], ENT_QUOTES) ." required></td>";
                echo "<td><input class='input2' type='number' name='price'  value=". htmlspecialchars($row['price'], ENT_QUOTES) ." required></td>";
                echo "<td><button type=submit name=update>UPDATE</button></td>"; 
                echo "<td><button type=submit name=delete>DELETE</button></td>"; 
                echo "</tr>";
                echo"</form>";
            }
            echo "</table>";
        }
        if (isset($_POST['update'])) 
        { 
            //$flight_id=$_POST['filght_id'];
            $f_no = $_POST['fno'];
            $from = $_POST['from'];
            // $d_date = $_POST['d_date'];
            // $d_time = $_POST['d_time'];
            $d_datetime = $_POST['d_datetime'];
            $to = $_POST['to'];
            $r_datetime = $_POST['r_datetime'];
            // $a_date=$_POST['a_date'];
            // $a_time=$_POST['a_time'];
            $baggage = $_POST['baggage'];
            $price=$_POST['price'];
            $sql="UPDATE `flight` SET `flight_no`='$f_no',`departure`='$from',
            `d_datetime`='$d_datetime',`arrival`='$to',`r_datetime`='$r_datetime'
            ,`baggage`='$baggage',`price`='$price' WHERE  `flight_id`='$flight_id'";
            
              if($conn->query($sql)==FALSE){
                die("error updating value:".$conn->error);
              }
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