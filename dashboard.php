<?php
    require_once "config.php";
    session_start();
    if(isset($_SESSION['username'])){
        if($_SESSION["admin"]=='NO'){
            header("location: home.php");
            exit();
        }
    }
    else{
        header("location: login.php");
        exit();
    }

    $name = [];
    $email = [];
    $checkInDate = [];
    $checkOutDate = [];
    $room_no = [];
    $reserved_on = [];
    $username = [];
    $booking_id = [];
    $price = [];
    date_default_timezone_set("Asia/Calcutta");
    $dt = date('Y-m-d');
    $sql = "SELECT * FROM bookings WHERE checkInDate='$dt'";
    $results = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($results)) {
        $name[] = $row['name'];
        $email[] = $row['email'];
        $checkInDate[] = $row['checkInDate'];
        $checkOutDate[] = $row['checkOutDate'];
        $room_no[] = $row['room_no'];
        $reserved_on[] = $row['reserved_on'];
        $username[] = $row['username'];
        $booking_id[] = $row['booking_id'];
        $price[] = $row['price'];
    }
    $html = "<h2>Today</h2><hr style='color: black; height: 1.5px;'>";
    if(empty($room_no)){
        $html .= "<h4 style='color: grey;'>No Check-Ins Today</h4><br><br><br>";
    }
    else{
        $html .= "<table width='100%'>";
        $html .= '<tr>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-Out Date</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>';
        $html .= '</tr>';
        for($i=0; $i<count($checkInDate); $i++){
            $html .= '<tr>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$name[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$email[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$username[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$checkInDate[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$checkOutDate[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$room_no[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$reserved_on[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$booking_id[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$price[$i].'</td>';
            $html .= '</tr>';
        }
        $html .= '</table><br><br><br>';
    }


    $name = [];
    $email = [];
    $message = [];
    $recieved_at = [];
    $room_no = [];
    $reserved_on = [];
    $username = [];
    $booking_id = [];
    $price = [];
    date_default_timezone_set("Asia/Calcutta");
    $dt = date('Y-m-d');
    $sql = "SELECT * FROM bookings WHERE checkInDate>'$dt'";
    $results = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($results)) {
        $name[] = $row['name'];
        $email[] = $row['email'];
        $checkInDate[] = $row['checkInDate'];
        $checkOutDate[] = $row['checkOutDate'];
        $room_no[] = $row['room_no'];
        $reserved_on[] = $row['reserved_on'];
        $username[] = $row['username'];
        $booking_id[] = $row['booking_id'];
        $price[] = $row['price'];
    }
    $html .= "<h2>Upcoming</h2><hr style='color: black; height: 1.5px;'>";
    if(empty($room_no)){
        $html .= "<h4 style='color: grey;'>No Upcoming Check-Ins</h4><br><br><br>";
    }
    else{
        $html .= "<table width='100%'>";
        $html .= '<tr>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-Out Date</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>';
        $html .= '</tr>';
        for($i=0; $i<count($checkInDate); $i++){
            $html .= '<tr>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$name[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$email[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$username[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$checkInDate[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$checkOutDate[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$room_no[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$reserved_on[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$booking_id[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$price[$i].'</td>';
            $html .= '</tr>';
        }
        $html .= '</table><br><br><br>';
    }


    $name = [];
    $email = [];
    $checkInDate = [];
    $checkOutDate = [];
    $room_no = [];
    $reserved_on = [];
    $username = [];
    $booking_id = [];
    $price = [];
    date_default_timezone_set("Asia/Calcutta");
    $dt = date('Y-m-d');
    $sql = "SELECT * FROM bookings WHERE checkInDate<'$dt'";
    $results = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($results)) {
        $name[] = $row['name'];
        $email[] = $row['email'];
        $checkInDate[] = $row['checkInDate'];
        $checkOutDate[] = $row['checkOutDate'];
        $room_no[] = $row['room_no'];
        $reserved_on[] = $row['reserved_on'];
        $username[] = $row['username'];
        $booking_id[] = $row['booking_id'];
        $price[] = $row['price'];
    }
    $html .= "<h2>Past</h2><hr style='color: black; height: 1.5px;'>";
    if(empty($room_no)){
        $html .= "<h4 style='color: grey;'>No Past Check-Ins</h4><br><br><br>";
    }
    else{
        $html .= "<table width='100%'>";
        $html .= '<tr>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-Out Date</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>';
        $html .= '</tr>';
        for($i=0; $i<count($checkInDate); $i++){
            $html .= '<tr>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$name[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$email[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$username[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$checkInDate[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$checkOutDate[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$room_no[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$reserved_on[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$booking_id[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$price[$i].'</td>';
            $html .= '</tr>';
        }
        $html .= '</table><br><br><br>';
    }


    $name = [];
    $email = [];
    $message = [];
    $recieved_at = [];
    date_default_timezone_set("Asia/Calcutta");
    $dt = date('Y-m-d');
    $sql = "SELECT * FROM contactform";
    $results = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($results)) {
        $name[] = $row['name'];
        $email[] = $row['email'];
        $message[] = $row['message'];
        $recieved_at[] = $row['recieved_at'];
    }
    $html .= "<h2>Contact</h2><hr style='color: black; height: 1.5px;'>";
    if(empty($room_no)){
        $html .= "<h4 style='color: grey;'>Nothing here yet!</h4><br><br><br>";
    }
    else{
        $html .= "<table width='100%'>";
        $html .= '<tr>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Mesage</th>';
        $html .= '<th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Recieved At</th>';
        $html .= '</tr>';
        for($i=0; $i<count($name); $i++){
            $html .= '<tr>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$name[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$email[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$message[$i].'</td>';
            $html .= '<td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$recieved_at[$i].'</td>';
            $html .= '</tr>';
        }
        $html .= '</table><br><br><br>';
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Hotel Booking Management</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hotel Booking Management</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="accountInfo.php"><?php echo $_SESSION['fname']?> <i class="fa fa-user" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</i></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rooms.php">Rooms</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container mt-4" style="width: 100%;">
    <h1 style="font-size: 60px; font-family: Georgia; margin-top: 30px; text-align: center; text-decoration: underline;">Dashboard</h1>
        <br>
        <form action="" method="post">
            <?php echo $html; ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>