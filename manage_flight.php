<!DOCTYPE html>
<html>
<head>  
    <link rel="stylesheet" href="./manageflight.css">
    <title>Manage Flight</title>
    
</head>
<body>
    <nav class="navbar">
        <div class="navbar">
            <a href="#">AIRLINE RESERVATION SYSTEM</a>
            <div class="link">
                <a href="admin_dashboard.php">Home</a>
            </div>
        </div>
    </nav>
    
    <div class="div1">
        <h1>Add Flight</h1>
        <form class="form1" action="" method="post" enctype="multipart/form-data">
            <input class="input1" type="text" name="fno" placeholder="Flight No" required>
            <input class="input1" type="text" name="from" placeholder="From" required>
            <input class="input1" type="date" name="d_date" placeholder="Departure Date" required>
            <input class="input1" type="time" name="d_time" placeholder="Departure time" required>
            <input class="input1" type="text" name="to" placeholder="To" required>
            <input class="input1" type="date" name="a_date" placeholder="Arrival Date"required>
            <input class="input1" type="time" name="a_time" placeholder="Arrival Time" required>
            <input class="input1" type="number" name="price" placeholder="Price" required>
            <input class="sub2" type="submit" name="submit" value="Submit">
        </form>

        <?php
        require_once('connect.php');
        // Handle form submission
        if (isset($_POST['submit'])) { 
            $f_no = $_POST['fno'];
            $from = $_POST['from'];
            $d_date = $_POST['d_date'];
            $d_time = $_POST['d_time'];
            $to = $_POST['to'];
            $a_date=$_POST['a_date'];
            $a_time=$_POST['a_time'];
            $price=$_POST['price'];

                $sql = "INSERT INTO `flight` (`flight_no`, `departure`, `d_date`, `d_time`, `arrival`, `a_date`, `a_time`, `price`) 
                VALUES ('$f_no', '$from', '$d_date', '$d_time', '$to', '$a_date', '$a_time', '$price')";        
                $data = mysqli_query($conn, $sql);
                if ($data) {
                    echo "<script>alert('Record added');</script>";
                } else {
                    echo "<script>alert('Record invalid');</script>";
                }
            }

        // Fetch and display books
        $sql = "SELECT * FROM flight where `status`=true ";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {  
            echo "<table border='5'>";
            echo "<tr>";
            echo "<th>Flight No</th>";
            echo "<th>Departure</th>";
            echo "<th>Departure Date</th>";
            echo "<th>Departure Time</th>";
            echo "<th>Arrival</th>";
            echo "<th>Arrival Date</th>";
            echo "<th>Arrival Time</th>";
            echo "<th>Price</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($data)) {
                echo "<form action='' method='post'>";
                echo "<tr>";
                echo "<td><input class='input2' type='text' name='fno' value=" . $row['flight_no'] ." required></td>";
                echo "<td><input class='input2' type='text' name='from'value=". $row['departure'] ." required></td>";
                echo "<td><input class='input2' type='date' name='d_date' value=" . $row['d_date'] . " required></td>";
                echo "<td><input class='input2' type='time' name='d_time' value=".$row['d_time'] ." required></td>";
                echo "<td><input class='input2' type='text' name='to' value=". $row['arrival'] . " required></td>";
                echo "<td><input class='input2' type='date' name='a_date' value=" . $row['a_date'] . " required></td>";
                echo "<td><input class='input2' type='time' name='a_time' value=" .$row['a_time'] ." required></td>";
                echo "<td><input class='input2' type='number' name='price'  value=". $row['price'] ." required></td>";
                echo "<td><button type=submit name=update>UPDATE</button></td>"; 
                echo "<td><button type=submit name=delete>DELETE</button></td>"; 
                echo "</tr>";
                echo"</form>";
            }
            echo "</table>";
        }
        if (isset($_POST['update'])) 
        { 
            $f_no = $_POST['fno'];
            $from = $_POST['from'];
            $d_date = $_POST['d_date'];
            $d_time = $_POST['d_time'];
            $to = $_POST['to'];
            $a_date=$_POST['a_date'];
            $a_time=$_POST['a_time'];
            $price=$_POST['price'];
            $sql="UPDATE `flight` SET `departure`='$from',
            `d_date`='$d_date',`d_time`='$d_time',`arrival`='$to',`a_date`='$a_date'
            ,`a_time`='$a_time',`price`='$price' WHERE  `flight_no`='$f_no'";
            
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
    }

        ?>
    </div>
</body>
</html>