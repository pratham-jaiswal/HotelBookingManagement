<?php
    require_once "config.php";
    session_start();
    if (!isset($_SESSION['username'])){
        header("location: login.php");
        exit();
    }
    if (isset($_GET['booking_id'])){
        $booking_id = $_GET['booking_id'];
    }
    else{
        if($_SESSION["admin"]=='NO'){
            header("location: home.php");
            exit();
        }
    }
    if($_SESSION["admin"]=="NO"){
        $sql = "SELECT * from services";
        $results = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($results)){
            $sPrice[] = $row['price'];
            $sDPrice[] = $row['discountedPrice'];
        }
        $psl = $sPrice[0];
        $pld = $sPrice[1];
        $pfd = $sPrice[2];
        $prc = $sPrice[3];
        $pdsl = $sDPrice[0];
        $pdld = $sDPrice[1];
        $pdfd = $sDPrice[2];
        $pdrc = $sDPrice[3];
    }
    $_SESSION['payCart'] = "Cart";
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $sl = $_POST['sl'];
        $ld = $_POST['ld'];
        $fd = $_POST['fd'];
        $rc = $_POST['rc'];
        $sql = "INSERT INTO serviceform(name, username, checkInDate, checkOutDate) values(??????)"
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
                    <a class="nav-link active" aria-current="page" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container mt-4" style="width: 1500px;">
        <h2>Services</h2>
        <hr style="color: black; height: 1.5px;">
        
        <form action="" method="post">
            <h5 style="font-size: 23px">Booking ID: <?php echo $booking_id; ?></h5>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/e3ffpQy.jpg" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Self Laundry</h3>
                    <table style="width: 100%;">
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Price</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; font-weight: bold;">
                            <?php 
                                    if($pdsl>0){
                                        echo "<s style='color: darkred;'>&#8377;".$psl."</s>&nbsp;&#8377;".$pdsl;
                                    }
                                    else{
                                        echo "&#8377;".$psl;
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Tokens</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                                <input type="number" name="sl" id="sl" min="0" max="5" value="0" style="width: 60%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Guidelines:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <div style="font-weight: bold;">1 Token:</div>
                        <ul>
                        <li>Laundry has to be done yourself</li>
                        <li>1 Machine</li>
                        <li>1 Hour</li>
                        <li>Maximum 10 clothes per Machine</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/80KWX1d.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Laundry</h3>
                    <table style="width: 100%;">
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Price</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; font-weight: bold;">
                            <?php 
                                    if($pdld>0){
                                        echo "<s style='color: darkred;'>&#8377;".$pld."</s>&nbsp;&#8377;".$pdld;
                                    }
                                    else{
                                        echo "&#8377;".$pld;
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Tokens</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                                <input type="number" name="ld" id="ld" min="0" max="5" value="0" style="width: 60%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Guidelines:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <div style="font-weight: bold;">1 Token:</div>
                        <ul>
                        <li>1 Staff</li>
                        <li>Staff Does The Laundry</li>
                        <li>Maximum 15 clothes</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/4h87bcD.jpg" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Food</h3>
                    <table style="width: 100%;">
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Price</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; font-weight: bold;">
                            <?php 
                                    if($pdfd>0){
                                        echo "<s style='color: darkred;'>&#8377;".$pfd."</s>&nbsp;&#8377;".$pdfd;
                                    }
                                    else{
                                        echo "&#8377;".$pfd;
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Tokens</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                                <input type="number" name="fd" id="fd" min="0" max="5" value="0" style="width: 60%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Guidelines:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <div style="font-weight: bold;">1 Token:</div>
                        <ul>
                        <li>Buffet</li>
                        <li>1 Person</li>
                        <li>1 Hour</li>
                        <li>Unlimited Food</li>
                        <li>Food Packaging not allowed</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/jEjhOqi.jpg" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Room Cleaning</h3>
                    <table style="width: 100%;">
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Price</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; font-weight: bold;">
                            <?php 
                                    if($pdrc>0){
                                        echo "<s style='color: darkred;'>&#8377;".$prc."</s>&nbsp;&#8377;".$pdrc;
                                    }
                                    else{
                                        echo "&#8377;".$prc;
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Tokens</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                                <input type="number" name="rc" id="rc" min="0" max="5" value="0" style="width: 60%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Guidelines:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <div style="font-weight: bold;">1 Token:</div>
                        <ul>
                        <li>1 Staff cleans the Room</li>
                        <li>1 Room</li>
                        <li>1 Hour</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" name="serviceCart" class="btn btn-primary" onmouseover="this.style.backgroundColor='rgb(170, 0, 0)';return true;" onmouseout="this.style.backgroundColor='red';return true;" style="background: red; border: red; float: right;">Proceed to Pay</button>
            </div>
            <br><br><br>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>