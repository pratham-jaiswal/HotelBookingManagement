<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("location: login.php");
        exit();
    }
    require_once "config.php";

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        header('location: login.php');
    }

    $username = $_SESSION['username'];
?>

<!doctype html>
<html lang="en">
  <head>
    <script type = "text/javascript"> 
        function printArea(areaID){
            var printContent = document.getElementById(areaID);
            var WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            //WinPrint.close();
        }
    </script>  
        
    <!-- Required meta tags -->
    <meta charset="utf-8">
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
                    <a class="nav-link active" aria-current="page" href="accountInfo.php"><?php echo $_SESSION['fname']?> <i class="fa fa-user" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</i></a>
                </li>
                <?php
                if($_SESSION["admin"]=='YES'){
                    echo '<li class="nav-item"><a class="nav-link" href="dashboard.php">Admin</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>

<div class="container mt-4" style="width: 1000px;">
    <div class="row">
        <div class="col-md-6">
            <img src="https://i.imgur.com/H2EpCV0.png" title="source: imgur.com" style="width:50%"/>
        </div>
        <div class="col-md-6">
            <h1 style="font-size: 75px; font-family: Brush Script MT; margin-top: 30px; margin-left: -200px; text-align: center;">Hotel Booking Management</h1>
            <h1 style="font-size: 40px; font-family: Lucida Handwriting; margin-left: -200px; text-align: center;">
                <?php
                    if($_SESSION["admin"]=='YES'){
                        echo "Admin";
                    }
                    else{
                        echo "Client";
                    }
                    echo " Account Details";
            ?>
            </h1>
        </div>
    </div>
    <br><br>
    <table style="font-size: 20px;">
        <tr>
            <th style="border: 1px solid black; border-right: none; padding-top: 15px; padding-bottom: 15px; padding-left: 20px; width: 100%">Name:</th>
            <td style="border: 1px solid black; border-left: none; padding-top: 15px; padding-bottom: 15px; padding-right: 20px; width: 100%; text-align: right"><?php echo $_SESSION['fname']?> <?php echo $_SESSION['lname']?></td>
        </tr>
        <tr>
            <th style="border: 1px solid black; border-right: none; padding-top: 15px; padding-bottom: 15px; padding-left: 20px; width: 100%">Username:</th>
            <td style="border: 1px solid black; border-left: none; padding-top: 15px; padding-bottom: 15px; padding-right: 20px; width: 100%; text-align: right"><?php echo $_SESSION['username']?></td>
        </tr>
        <tr>
            <th style="border: 1px solid black; border-right: none; padding-top: 15px; padding-bottom: 15px; padding-left: 20px; width: 100%">Email:</th>
            <td style="border: 1px solid black; border-left: none; padding-top: 15px; padding-bottom: 15px; padding-right: 20px; width: 100%; text-align: right"><?php echo $_SESSION['email']?></td>
        </tr>
        <tr>
            <th style="border: 1px solid black; border-right: none; padding-top: 15px; padding-bottom: 15px; padding-left: 20px; width: 100%">Created On:</th>
            <td style="border: 1px solid black; border-left: none; padding-top: 15px; padding-bottom: 15px; padding-right: 20px; width: 100%; text-align: right"><?php echo $_SESSION["created_at"]?></td>
        </tr>
    </table>
</div>
    <br><br>
<?php if($_SESSION["admin"]=='NO'): ?>
    <form action="" method="post">
        <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE username='".$_SESSION['username']."' AND checkInDate<='$dt' AND checkOutDate>='$dt'";
            $results = mysqli_query($conn, $sql);
            ?>
            <div class="container mt-4" style="width: 1200px;">
            <h2>On-going Reservations</h2>
            <hr style='color: black; height: 1.5px;'>
            <?php
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No On-going Reservations!</h4>
            <?php else: ?>
            <?php $bkd = ''; $f=0;
            while($bk = mysqli_fetch_assoc($results)): 
                if($bkd!=$bk['booking_id']): 
                    if($f==1): $f=0;?>
                        </table>
                        </div><br>
                    <?php endif; ?>
                    <?php $bkd=$bk['booking_id']; $f=1;
                ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Booking ID: <?= $bkd?></h4>
                        </div>
                        <?php if($bk['checked_in']=='YES'): ?>
                        <div class="col-md-4">
                            <h5 style='color: teal;'>Checked In</h5>
                        </div>
                        <div class="col-md-1">
                        <?php else: ?>
                        <div class="col-md-5">
                        <?php endif; ?>
                            <button type="submit" name="print" onclick="printArea(<?php echo $bkd; ?>)" class="btn btn-primary" style="float: right;">View</button>
                        </div>
                        <?php if($bk['checked_in']=='NO'): ?>
                        <div class="col-md-1">
                            <a href="delete.php?booking_id=<?=$bk['booking_id']?>" class="cancel" onmouseover="this.style.color='rgb(170, 0, 0)';return true;" onmouseout="this.style.color='red';return true;" style="color: red; font-size: 16.5px;">Cancel</a>
                        </div>
                        <?php else: ?>
                        <div class="col-md-1">
                            <a href="#services.php?booking_id=<?=$bk['booking_id']?>" class="services" onmouseover="this.style.color='blueviolet';return true;" onmouseout="this.style.color='purple';return true;" style="color: purple; font-size: 16.5px;">Services</a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class='container mt-4' id='<?=$bkd?>' style='width: 800px; display: none;'>
                        <h1 style="font-family: Brush Script MT; font-size: 50px; text-align: center;">Hotel Booking Management System</h1>
                        <hr style="color: black; height: 1.5px; opacity: 1;">
                        <br>
                        <div class='row'>
                            <div class='col-md-6'>
                                Booking ID: <?= $bk['booking_id']?>
                            </div>
                            <div class='col-md-6'>
                                Reserved On: <?= $bk['reserved_on']?>
                            </div>
                            <div class='col-md-6'>
                                Name: <?= $bk['name']?>
                            </div>
                            <div class='col-md-6'>
                                Email: <?= $bk['email']?>
                            </div>
                            <div class='col-md-6'>
                                Check-In Date: <?= $bk['checkInDate']?>
                            </div>
                            <div class='col-md-6'>
                                Check-Out Date: <?= $bk['checkOutDate']?>
                            </div>
                        </div>
                        <br>
                        <table style="width: 100%; border: 1px solid black">
                            <tr>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room Type</th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Rooms No.</th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                            </tr>
                <?php endif; ?>
                            <tr>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['room_type'] ?></th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['room_no'] ?></th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['price'] ?></th>
                            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </table>
        </div></div><br>

        <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE username='".$_SESSION['username']."' AND checkInDate>'$dt'";
            $results = mysqli_query($conn, $sql);
            ?>
            <div class="container mt-4" style="width: 1200px;">
            <h2>Upcoming Reservations</h2>
            <hr style='color: black; height: 1.5px;'>
            <?php
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Upcoming Reservations!</h4>
            <?php else: ?>
            <?php $bkd = ''; $f=0;
            while($bk = mysqli_fetch_assoc($results)): 
                if($bkd!=$bk['booking_id']): 
                    if($f==1): $f=0;?>
                        </table>
                        </div><br>
                    <?php endif; ?>
                    <?php $bkd=$bk['booking_id']; $f=1;
                ?>
                    <div class="row">
                        <div class="col-md-10">
                            <h4>Booking ID: <?= $bkd?></h4>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" name="print" onclick="printArea(<?php echo $bkd; ?>)" class="btn btn-primary" style="float: right;">View</button>
                        </div>
                        <div class="col-md-1">
                            <a href="delete.php?booking_id=<?=$bk['booking_id']?>" class="cancel" onmouseover="this.style.color='rgb(170, 0, 0)';return true;" onmouseout="this.style.color='red';return true;" style="color: red; font-size: 16.5px;">Cancel</a>
                        </div>
                    </div>
                    <div class='container mt-4' id='<?=$bkd?>' style='width: 800px; display: none;'>
                        <h1 style="font-family: Brush Script MT; font-size: 50px; text-align: center;">Hotel Booking Management System</h1>
                        <hr style="color: black; height: 1.5px; opacity: 1;">
                        <br>
                        <div class='row'>
                            <div class='col-md-6'>
                                Booking ID: <?= $bk['booking_id']?>
                            </div>
                            <div class='col-md-6'>
                                Reserved On: <?= $bk['reserved_on']?>
                            </div>
                            <div class='col-md-6'>
                                Name: <?= $bk['name']?>
                            </div>
                            <div class='col-md-6'>
                                Email: <?= $bk['email']?>
                            </div>
                            <div class='col-md-6'>
                                Check-In Date: <?= $bk['checkInDate']?>
                            </div>
                            <div class='col-md-6'>
                                Check-Out Date: <?= $bk['checkOutDate']?>
                            </div>
                        </div>
                        <br>
                        <table style="width: 100%; border: 1px solid black">
                            <tr>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room Type</th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Rooms No.</th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                            </tr>
                <?php endif; ?>
                            <tr>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['room_type'] ?></th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['room_no'] ?></th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['price'] ?></th>
                            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </table>
        </div></div><br>


        <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $sql = "SELECT * FROM bookings WHERE username='".$_SESSION['username']."' AND checkOutDate<'$dt'";
            $results = mysqli_query($conn, $sql);
            ?>
            <div class="container mt-4" style="width: 1200px;">
            <h2>Past Reservations</h2>
            <hr style='color: black; height: 1.5px;'>
            <?php
            if(mysqli_num_rows($results)==0): ?>
                <h4 style='color: grey;'>No Past Reservations!</h4>
            <?php else: ?>
            <?php $bkd = ''; $f=0;
            while($bk = mysqli_fetch_assoc($results)): 
                if($bkd!=$bk['booking_id']): 
                    if($f==1): $f=0;?>
                        </table>
                        </div><br>
                    <?php endif; ?>
                    <?php $bkd=$bk['booking_id']; $f=1;
                ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Booking ID: <?= $bkd?></h4>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="print" onclick="printArea(<?php echo $bkd; ?>)" class="btn btn-primary" style="float: right; margin-right: 20px;">View</button>
                        </div>
                    </div>
                    <div class='container mt-4' id='<?=$bkd?>' style='width: 800px; display: none;'>
                        <h1 style="font-family: Brush Script MT; font-size: 50px; text-align: center;">Hotel Booking Management System</h1>
                        <hr style="color: black; height: 1.5px; opacity: 1;">
                        <br>
                        <div class='row'>
                            <div class='col-md-6'>
                                Booking ID: <?= $bk['booking_id']?>
                            </div>
                            <div class='col-md-6'>
                                Reserved On: <?= $bk['reserved_on']?>
                            </div>
                            <div class='col-md-6'>
                                Name: <?= $bk['name']?>
                            </div>
                            <div class='col-md-6'>
                                Email: <?= $bk['email']?>
                            </div>
                            <div class='col-md-6'>
                                Check-In Date: <?= $bk['checkInDate']?>
                            </div>
                            <div class='col-md-6'>
                                Check-Out Date: <?= $bk['checkOutDate']?>
                            </div>
                        </div>
                        <br>
                        <table style="width: 100%; border: 1px solid black">
                            <tr>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room Type</th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Rooms No.</th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Nightly Price</th>
                            </tr>
                <?php endif; ?>
                            <tr>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['room_type'] ?></th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['room_no'] ?></th>
                                <th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"><?= $bk['price'] ?></th>
                            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </table>
        </div></div><br>

    </form>
<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>