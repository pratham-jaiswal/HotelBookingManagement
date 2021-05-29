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
            <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE checkInDate='$dt'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Today</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php 
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Reservations Today!</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Chcek-Out Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                        <th style="padding-left: 30px; padding-right: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Checked In</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resv = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['name']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['username']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkInDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkOutDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['room_no']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['reserved_on']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['booking_id']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['price']?></td>
                            <td style="padding-left: 30px; padding-right: 20px; padding-bottom: 10px; padding-top: 5px; border: 1px solid black;"><?=$resv['checked_in']?>
                            <?php if($resv['checked_in']=='NO'): ?>
                                <a href="update.php?booking_id=<?=$resv['booking_id']?>" class="edit"><i class="fa fa-check fa-2x" aria-hidden="true" style="padding-left: 10px;"></i></a>
                            <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

            <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE checkOutDate>='$dt' AND checkInDate<='$dt' AND checked_in='YES'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Currently Reserved & Checked In</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php 
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Rooms Reserved Currently! or None Checked In!</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Chcek-Out Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resv = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['name']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['username']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkInDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkOutDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['room_no']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['reserved_on']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['booking_id']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['price']?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

            <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE checkOutDate>='$dt' AND checkInDate<='$dt' AND checked_in='NO'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Currently Reserved but Not Checked In</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php 
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Rooms Reserved Currently! or All Checked In!</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Chcek-Out Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resv = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['name']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['username']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkInDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkOutDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['room_no']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['reserved_on']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['booking_id']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['price']?></td>
                            <td  style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px;">
                                <a href="delete.php?id=<?=$resv['id']?>" class="trash"><i class="fa fa-trash-o fa-2x" aria-hidden="true" onmouseover="this.style.color='rgb(170, 0, 0)';return true;" onmouseout="this.style.color='red';return true;" style="color: red; padding: 3px;"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

            <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE checkInDate>'$dt'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Upcoming</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php 
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Upcoming Reservations yet!</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Chcek-Out Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resv = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['name']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['username']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkInDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkOutDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['room_no']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['reserved_on']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['booking_id']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['price']?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>
            
            <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE checkOutDate<'$dt'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Past</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php 
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Past Reservations</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Check-In Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Chcek-Out Date</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room No.</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Reserved On</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Booking ID</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resv = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['name']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['username']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkInDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['checkOutDate']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['room_no']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['reserved_on']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['booking_id']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$resv['price']?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

            <?php
            $sql = "SELECT * FROM contactform WHERE replied = 'NO'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>New Contacts</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>Replied to All Contacts till now!</h4>
            <?php else:?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Message</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Recieved On</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Replied</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($contact = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['name']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['message']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['recieved_at']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 5px; border: 1px solid black;"><?=$contact['replied']?>
                                <a href="update.php?id=<?=$contact['id']?>" class="edit"><i class="fa fa-check fa-2x" aria-hidden="true" style="padding-left: 10px;"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

            <?php
            $sql = "SELECT * FROM contactform WHERE replied = 'YES'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Old Contacts</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>Replied to No Contacts yet!</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Message</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Recieved On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($contact = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['name']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['message']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$contact['recieved_at']?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

            <?php
            $sql = "SELECT * FROM loginform WHERE admin = 'YES'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Admins</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Admins!</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Created On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($lg = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['fname'].' '.$lg['lname']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['username']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['created_at']?></td>
                            <?php if($lg['id']!=1): ?>
                            <td style="padding-right: 5px; padding-bottom: 10px; padding-top: 10px; float: right;">
                                <a href="update.php?usernamec=<?=$lg['username']?>" class="edit">
                                <i class="fa fa-user-times fa-2x" onmouseover="this.style.color='rgb(170, 0, 0)';return true;" onmouseout="this.style.color='red';return true;" style="color: red;" aria-hidden="true"></i></a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

            <?php
            $sql = "SELECT * FROM loginform WHERE admin = 'NO'";
            $results = mysqli_query($conn, $sql);
            ?>
            <h2>Clients</h2>
            <hr style='color: black; height: 1.5px;'>
            <br>
            <?php
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Clients!</h4>
            <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Name</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Email</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Username</th>
                        <th style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Created On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($lg = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['fname'].' '.$lg['lname']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['email']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['username']?></td>
                            <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?=$lg['created_at']?></td>
                            <td style="padding-right: 5px; padding-bottom: 10px; padding-top: 10px; float: right;">
                                <a href="update.php?username=<?=$lg['username']?>" class="edit">
                                <i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br><br><br>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>