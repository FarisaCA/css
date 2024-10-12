<!DOCTYPE html>
<html>
<head>  
    <link rel="stylesheet" href="manageflight.css">
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
            <input class="input1" type="d_date" name="d_date" placeholder="Departure Date" required>
            <input class="input1" type="d_time" name="d_time" placeholder="Departure time" required>
            <input class="input1" type="text" name="to" placeholder="To" required>
            <input class="input1" type="a_date" name="a_date" placeholder="Arrival Date"required>
            <input class="input1" type="a_time" name="a_time" placeholder="Arrival Time" required>
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
        $sql = "SELECT * FROM flight";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {  
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Flight No</th>";
            echo "<th>Departure</th>";
            echo "<th>Date</th>";
            echo "<th>Time</th>";
            echo "<th>Arrival</th>";
            echo "<th>Date</th>";
            echo "<th>Time</th>";
            echo "<th>Price</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($data)) {
                /*$id = $row['flight_no'];*/
                echo "<tr>";
                echo "<td>" . $row['flight_no'] . "</td>";
                echo "<td>" . $row['departure'] . "</td>";
                echo "<td>" . $row['d_date'] . "</td>";
                echo "<td>" . $row['d_time'] . "</td>";
                echo "<td>" . $row['arrival'] . "</td>";
                echo "<td>" . $row['a_date'] . "</td>";
                echo "<td>" .$row['a_time'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td> <form method='POST' style='display:inline;'>
                        <button value='' name='fno' type='submit'>Delete</button>
                    </form>
               <form method='post' action='editflight.php'>
    <button name='edit' value='' class='deluser' type='submit'>EDIT</button>
</form>
</td>";
                
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>

        <div class="ViewCandidatesBodyContainer">
            <?php
            
            if (isset($_POST['userdel'])) {
                $f_no = $_POST['userdel'];
                if (!empty($book_id)) {
                    $sql = "DELETE FROM flight WHERE flight_no = $f_no";
                    $data = mysqli_query($conn, $sql);
                    echo "<script>window.location.replace('./managebooks.php');</script>";
                }
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>