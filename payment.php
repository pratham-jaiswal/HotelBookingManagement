<?php
session_start();
if(isset($_SESSION['payDone'])){
    $_SESSION['payDone'] = $_SESSION['revRooms'] = $_SESSION["cInD"] = $_SESSION["cOutD"] = NULL;
    header("location: home.php");
    exit();
}
if(!isset($_SESSION['username'])){
    header("location: login.php");
    exit();
}
require_once "config.php";
date_default_timezone_set("Asia/Kolkata");
$avRNo = $_SESSION['avRoomNo'];
$totDays = $_SESSION["totDays"];
$nSS = $_SESSION["nSS"];
$nSD = $_SESSION["nSD"];
$nDS = $_SESSION["nDS"];
$nDD = $_SESSION["nDD"];
$nDSt = $_SESSION["nDSt"];
$cInD = $_SESSION["cInD"];
$cOutD = $_SESSION["cOutD"];
$username = $_SESSION["username"];
$cartItemN = $_SESSION["cartItemN"];
$cartItemQ = $_SESSION["cartItemQ"];
$cartItemP = $_SESSION["cartItemP"];
$revRNo = [];
$revRt = "";
$cname = $ccno = $emonth = $name = $email = $eyear = $cvv = "";
$cname_err = $ccno_err = $emy_err = $name_err = $email_err = $cvv_err = "";
if($_SERVER['REQUEST_METHOD']=="POST"){

    if(empty(trim($_POST['cname']))){
        $cname_err = "Name on Card cannot be blank";
    }
    else{
        $cname = trim($_POST['cname']);
    }
    if(empty(trim($_POST['ccno']))){
        $ccno_err = "Card Number cannot be blank";
    }
    else{
        if(strlen(trim($_POST['ccno'])) == 16){
            $ccno = trim($_POST['ccno']);
        }
        else{
            $ccno_err = "Invalid Card Number";
        }
    }
    if(empty(trim($_POST['emonth'])) || empty(trim($_POST['eyear']))){
        $emy_err = "Expiry month/year cannot be blank";
    }
    else{
        if(trim($_POST['eyear']) > date('Y')){
            if((trim($_POST['emonth'])<=12) && (trim($_POST['emonth'])>=1)){
                $emonth = trim($_POST['emonth']);
                $eyear = trim($_POST['eyear']);
            }
            else{
                $emy_err = "Invalid month number";
            }
        }
        elseif(trim($_POST['eyear']) == date('Y')){
            if(trim($_POST['emonth']) > date('m')){
                $emonth = trim($_POST['emonth']);
                $eyear = trim($_POST['eyear']);
            }
            else{
                $emy_err = "Card Expired!!";
            }
        }
        else{
            $emy_err = "Card Expired!!";
        }
    }
    if(empty(trim($_POST['cvv']))){
        $cvv_err = "CVV cannot be blank";
    }
    else{
        if(strlen(trim($_POST['cvv'])) == 3){
            $cvv = trim($_POST['cvv']);
        }
        else{
            $cvv_err = "Invalid CVV";
        }
    }

    if(empty(trim($_POST['name']))){
        $name_err = "Name on Card cannot be blank";
    }
    else{
        $sql = "SELECT id FROM bookings WHERE name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            //Set the value of param name
            $param_name = trim($_POST['name']);
            //Try to execute the statement
            if(mysqli_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                $name = trim($_POST['name']);
            }
            else{
                echo "<script>alert('Something went wrong');</script>";
            }
        }
    }


    if(empty(trim($_POST['email']))){
        $email_err = "Email cannot be blank";
    }
    else{
        $sql = "SELECT id FROM bookings WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            //Set the value of param email
            $param_email = trim($_POST['email']);
            //Try to execute the statement
            if(mysqli_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                $email = trim($_POST['email']);
            }
            else{
                echo "<script>alert('Something went wrong');</script>";
            }
        }
    }


    if(empty($cname_err) && empty($ccno_err) && empty($emy_err) && empty($name_err) && empty($email_err) && empty($cvv_err)){
        $revRNo = $_SESSION['revRooms'];
        foreach($revRNo as $b){
            $f=0;
            $sql = "INSERT INTO bookings (name, email, checkInDate, checkOutDate, room_no, room_type, username, booking_id, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                mysqli_stmt_bind_param($stmt, "sssssssss", $param_name, $param_email, $param_checkInDate, $param_checkOutDate, $param_room_no, $param_room_type, $param_username, $param_booking_id, $param_price);
                $param_name = $name;
                $param_email = $email;
                $param_checkInDate = $cInD;
                $param_checkOutDate = $cOutD;
                $param_room_no = $b;
                $param_username = $username;
                $param_booking_id = date('dmYhis');
                if(($b>100) && ($b<=105)){
                    $revRt = "Standard (Single)";
                    if($_SESSION['dpSS']>0){
                        $param_price = $_SESSION['dpSS'];
                    }
                    else{
                        $param_price = $_SESSION['pSS'];
                    }
                }
                elseif(($b>200) && ($b<=205)){
                    $revRt = "Standard (Double)";
                    if($_SESSION['dpSD']>0){
                        $param_price = $_SESSION['dpSD'];
                    }
                    else{
                        $param_price = $_SESSION['pSD'];
                    }
                }
                elseif(($b>300) && ($b<=305)){
                    $revRt = "Deluxe (Single)";
                    if($_SESSION['dpDS']>0){
                        $param_price = $_SESSION['dpDS'];
                    }
                    else{
                        $param_price = $_SESSION['pDS'];
                    }
                }
                elseif(($b>400) && ($b<=405)){
                    $revRt = "Deluxe (Double)";
                    if($_SESSION['dpDD']>0){
                        $param_price = $_SESSION['dpDD'];
                    }
                    else{
                        $param_price = $_SESSION['pDD'];
                    }
                }
                elseif(($b>500) && ($b<=505)){
                    $revRt = "Deluxe Suite";
                    if($_SESSION['dpDSt']>0){
                        $param_price = $_SESSION['dpDSt'];
                    }
                    else{
                        $param_price = $_SESSION['pDSt'];
                    }
                }
                $param_room_type = $revRt;

                //Try to execute the query
                if(mysqli_stmt_execute($stmt)){
                    $_SESSION['payDone'] = $f=1;
                }
                else{
                    echo "<script>alert('Something went wrong.. Cannot Redirect');</script>";
                }
            }
            if($f==1){
                echo "<script>alert('Rooms Successfully Reserved')</script>";
                echo "<script>window.location.replace('home.php')</script>";
            }
            mysqli_stmt_close($stmt);
        }        
    }
    else{
        if(!empty($cname_err)){
            echo "<script>alert('$cname_err')</script>";
        }
        elseif(!empty($ccno_err)){
            echo "<script>alert('$ccno_err')</script>";
        }
        elseif(!empty($emy_err)){
            echo "<script>alert('$emy_err')</script>";
        }
        elseif(!empty($cvv_err)){
            echo "<script>alert('$cvv_err')</script>";
        }
        elseif(!empty($email_err)){
            echo "<script>alert('$email_err')</script>";
        }
        elseif(!empty($name_err)){
            echo "<script>alert('$name_err')</script>";
        }
    }
    mysqli_close($conn);
}
foreach($avRNo as $a){
    if(($a>100) && ($a<=105) && ($nSS>0)){
        $nSS--;
        $revRNo[] = $a;
    }
    elseif(($a>200) && ($a<=205) && ($nSD>0)){
        $nSD--;
        $revRNo[] = $a;
    }
    elseif(($a>300) && ($a<=305) && ($nDS>0)){
        $nDS--;
        $revRNo[] = $a;
    }
    elseif(($a>400) && ($a<=405) && ($nDD>0)){
        $nDD--;
        $revRNo[] = $a;
    }
    elseif(($a>500) && ($a<=505) && ($nDSt>0)){
        $nDSt--;
        $revRNo[] = $a;    
    }
}
$_SESSION["revRooms"] = $revRNo;
if(empty($revRNo)){
    $revRNo = $_SESSION["revRooms"];
}

// start table
$html = '<table>';
// header row
$html .= '<tr>';
$html .= '<th style="font-size: 16.5px; padding-right: 30px; padding-bottom: 5px; padding-top: 5px; border-top: 1px solid black; border-bottom: 1px solid black;">Room Type</th>';
$html .= '<th style="font-size: 16.5px; padding-left: 30px; padding-right: 0px; padding-bottom: 5px; padding-top: 5px; border-top: 1px solid black; border-bottom: 1px solid black;">No. of Rooms</th>';
$html .= '<th style="font-size: 16.5px; padding-left: 30px; padding-bottom: 5px; padding-top: 5px; border-top: 1px solid black; border-bottom: 1px solid black;">Net Price</th>';
$html .= '</tr>';

$i=0;
foreach($cartItemN as $cn){
    $html .= '<tr>';
    $html .= '<td style="font-size: 16.5px; padding-right: 30px; padding-bottom: 10px; padding-top: 10px;">' . $cn . '</td>';
    $html .= '<td style="font-size: 16.5px; padding-left: 30px; padding-bottom: 10px; padding-top: 10px;">' . $cartItemQ[$i] . '</td>';
    $html .= '<td style="font-size: 16.5px; padding-left: 30px; padding-bottom: 10px; padding-top: 10px;">&#8377;' . $cartItemP[$i]*$_SESSION["totDays"] . '</td>';
    $html .= '</tr>';
    $i++;
}

$html .= '<tr>';
$html .= '<td style="font-size: 16.5px; font-weight: bold;padding-right: 30px; border-top: 1px solid black; padding-bottom: 10px; padding-top: 10px;">Total</td>';
$html .= '<td style="font-size: 16.5px; font-weight: bold;padding-left: 30px; border-top: 1px solid black; padding-bottom: 10px; padding-top: 10px;">'.$_SESSION["nSS"]+$_SESSION["nSD"]+$_SESSION["nDS"]+$_SESSION["nDD"]+$_SESSION["nDSt"].'</td>';
$html .= '<td style="font-size: 16.5px; font-weight: bold;padding-left: 30px; border-top: 1px solid black; padding-bottom: 10px; padding-top: 10px;">&#8377;'.$_SESSION["totExclTax"].'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td style="font-size: 16.5px; padding-right: 30px; padding-bottom: 10px;">Tax ('.$_SESSION["taxp"].'%)</td>';
$html .= '<td style="font-size: 16.5px; padding-left: 30px; padding-bottom: 10px;"> </td>';
$html .= '<td style="font-size: 16.5px; padding-left: 30px; padding-bottom: 10px;">&#8377;'.$_SESSION["tax"].'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td style="font-weight: bold; padding-right: 30px; border-top: 1px solid black; padding-top: 10px; font-size: 16.5px;">Net Total</td>';
$html .= '<td style="font-weight: bold; padding-left: 30px; border-top: 1px solid black; padding-top: 10px; font-size: 16.5px;">'.$_SESSION["nSS"]+$_SESSION["nSD"]+$_SESSION["nDS"]+$_SESSION["nDD"]+$_SESSION["nDSt"].'</td>';
$html .= '<td style="font-size: 16.5px; font-weight: bold; padding-left: 30px; border-top: 1px solid black; padding-top: 10px;">&#8377;'.$_SESSION["totPrice"].'</td>';
$html .= '</tr>';

$html .= '</table>';
$html .= '<br>';
$_SESSION['cartTable'] = $html;

?>

<!doctype html>
<html lang="en">
  <head>
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
                    <a class="nav-link" href="accountInfo.php"><?php echo $_SESSION['fname']?> <i class="fa fa-user" aria-hidden="true"></i></a>
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
                    <a class="nav-link active" aria-current="page" href="payment.php">Payment</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4" style="width: 1500px; font-size: 20px;">
        <h2>Payment</h2>
        <hr style="color: black; height: 1.5px;">
        <form action="" method="post">
            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cards">Accepted Cards</label>
                            <br>
                            <i class="fa fa-cc-visa fa-2x" aria-hidden="true" style="color:navy;"></i>
                            <i class="fa fa-cc-mastercard fa-2x" aria-hidden="true" style="color:red;"></i>
                            <br><br>
                            <label for="inputCName" class="form-label" style="margin-top: 2%">Name on Card</label>
                            <input type="text" class="form-control" name="cname" id="inputCName" placeholder="Anthony Edward Stark" style="border: 1px solid black;">
                            <br><label for="ccnum" class="form-label">Card Number</label>
                            <input type="text" class="form-control" name="ccno" id="ccnum" placeholder="1111222233334444" style="border: 1px solid black;">
                            <br><label for="expm" class="form-label">Expiry Month</label>
                            <input type="text" class="form-control" name="emonth" id="expm" placeholder="10" style="border: 1px solid black;">
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label" style="margin-top: 1%">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Tony Stark" style="border: 1px solid black;">
                            <br>
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="inputEmail4" placeholder="tstark@gmail.com" style="border: 1px solid black;">
                            <br><label for="expy" class="form-label">Expiry Year</label>
                            <input type="text" class="form-control" name="eyear" id="expy" placeholder="2023" style="border: 1px solid black;">
                            <br><label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" name="cvv" id="cvv" placeholder="231" style="border: 1px solid black;">
                        </div>
                    </div>
                    <br>
                    <div class="col-12">
                        <button type="submit" name="pay" class="btn btn-primary" onmouseover="this.style.backgroundColor='rgb(170, 0, 0)';return true;" onmouseout="this.style.backgroundColor='red';return true;" style="background: red; border: red;">Pay</button>
                    </div>
                </div>
                <div class="col-5" style="padding-left: 5%;">
                <h4>Reservations</h4>
                <hr style="color: black; height: 1.5px;">
                <table>
                    <tr>
                        <th style="font-size: 20px; padding-right: 30px; padding-bottom: 10px; font-size: 16.5px;">Check In Date</th>
                        <td style="font-size: 20px; padding-left: 30px; padding-bottom: 10px; font-size: 16.5px;"><?php echo $_SESSION["cInD"];?></td>
                    </tr>
                    <tr>
                        <th style="font-size: 20px; padding-right: 30px; padding-bottom: 10px; font-size: 16.5px;">Check Out Date</th>
                        <td style="font-size: 20px; padding-left: 30px; padding-bottom: 10px; font-size: 16.5px;"><?php echo $_SESSION["cOutD"];?></td>
                    </tr>
                    <tr>
                        <th style="font-size: 20px; padding-right: 30px; font-size: 16.5px; padding-bottom: 20px;">Total Nights Staying</th>
                        <td style="font-size: 20px; padding-left: 30px; font-size: 16.5px; padding-bottom: 20px;"><?php echo $_SESSION["totDays"];?></td>
                    </tr>
                </table>
                <?php echo $_SESSION['cartTable']?>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>