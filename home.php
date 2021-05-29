<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("location: login.php");
        exit();
    }
    if(isset($_SESSION['payDone'])){
        $_SESSION['payDone'] = $_SESSION['revRooms'] = $_SESSION["cInD"] = $_SESSION["cOutD"] = NULL;
    }
    require_once "config.php";
    $cInD = $cOutD = "";
    $nSS = $nSD = $nDS = $nDD = $nDSt = 0;
    
    $totPrice = 0;
    $tax = 0;
    $cartItemN = [];
    $cartItemQ = [];
    $cartItemP = [];
    $m = "";
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(!empty($_POST['CheckIn'])&&!empty($_POST['CheckOut'])){
            if(($_POST['CheckIn']<=date('Y-m-d')) || ($_POST['CheckOut']<=date('Y-m-d')) || ($_POST['CheckOut']<=$_POST['CheckIn']))
            {
                echo "<script>alert('Invalid Check-In or/and Check-Out Date(s)');</script>";
            }
            else{
                $_SESSION["cInD"] = $cInD = $_POST['CheckIn'];
                $_SESSION["cOutD"] = $cOutD = $_POST['CheckOut'];
                $_SESSION["totDays"] = $totDays = (strtotime($_SESSION["cOutD"]) - strtotime($_SESSION["cInD"]))/(60 * 60 * 24);
                $_SESSION['payDone'] = NULL;
            }
        }
    }
    if(empty($_SESSION["cInD"]) || empty($_SESSION["cOutD"])){
        $m = "Enter Check In and Check Out Dates to Book Rooms";
    }
    else{
        $m = "Rooms available between ".$_SESSION['cInD']." & ".$_SESSION['cOutD'];
        if(empty($cInD) || empty($cOutD)){
            $cInD = $_SESSION["cInD"];
            $cOutD = $_SESSION["cOutD"];
        }
    }

    $prices = [];
    $dprices = [];
    $sql = "SELECT * FROM rooms";
    $results = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($results)) {
        $totRNo[] = $row['room_no'];
        $totRT[] = $row['room_type'];
        $prices[] = $row['price'];
        $dprices[] = $row['discountedPrice'];
    }
    
    $prices = array_unique($prices);
    $i=0;
    foreach($prices as $pr){
        if($i == 0){
            $pSS = $pr;
        }
        elseif($i == 1){
            $pSD = $pr;
        }
        elseif($i == 2){
            $pDS = $pr;
        }
        elseif($i == 3){
            $pDD = $pr;
        }
        elseif($i == 4){
            $pDSt = $pr;
        }
        $i++;
    }

    $i=0;
    foreach($dprices as $dpr){
        if($i == 0){
            $dpSS = $dpr;
        }
        elseif($i == 5){
            $dpSD = $dpr;
        }
        elseif($i == 10){
            $dpDS = $dpr;
        }
        elseif($i == 15){
            $dpDD = $dpr;
        }
        elseif($i == 20){
            $dpDSt = $dpr;
        }
        
        $i++;
    }

    $noSS = $noSD = $noDS = $noDD = $noDSt = 5;
    if(isset($_POST['reserve'])){
        $nSS = $_POST['nSS'];
        $nSD = $_POST['nSD'];
        $nDS = $_POST['nDS'];
        $nDD = $_POST['nDD'];
        $nDSt = $_POST['nDSt'];
        if($nSS>0){
            $cartItemN[] = "Standard (Single)";
            $cartItemQ[] = $nSS;
            if($dpSS>0){
                $cartItemP[] = $nSS*$dpSS;
            }
            else{
                $cartItemP[] = $nSS*$pSS;
            }
            
        }
        if($nSD>0){
            $cartItemN[] = "Standard (Double)";
            $cartItemQ[] = $nSD;
            if($dpSD>0){
                $cartItemP[] = $nSD*$dpSD;
            }
            else{
                $cartItemP[] = $nSD*$pSD;
            }
        }
        if($nDS>0){
            $cartItemN[] = "Deluxe (Single)";
            $cartItemQ[] = $nDS;
            if($dpDS>0){
                $cartItemP[] = $nDS*$dpDS;
            }
            else{
                $cartItemP[] = $nDS*$pDS;
            }
        }
        if($nDD>0){
            $cartItemN[] = "Deluxe (Double)";
            $cartItemQ[] = $nDD;
            if($dpDD>0){
                $cartItemP[] = $nDD*$dpDD;
            }
            else{
                $cartItemP[] = $nDD*$pDD;
            }
        }
        if($nDSt>0){
            $cartItemN[] = "Deluxe Suite";
            $cartItemQ[] = $nDSt;
            if($dpDSt>0){
                $cartItemP[] = $nDSt*$dpDSt;
            }
            else{
                $cartItemP[] = $nDSt*$pDSt;
            }
        }
        $i=0;
        foreach($cartItemP as $ci){
            $totPrice = $totPrice + $ci;
        }
        if(isset($totPrice) && isset($_SESSION["totDays"])){
            $totPrice = $totPrice*$_SESSION["totDays"];
            if(($totPrice>0)&&($totPrice<=1000)){
                $tax = 0;
                $_SESSION["taxp"] = 0;
            }
            elseif(($totPrice>1000) && ($totPrice<=7500)){
                $tax = $totPrice*(12/100);
                $_SESSION["taxp"] = 12;
            }
            else{
                $tax = $totPrice*(18/100);
                $_SESSION["taxp"] = 18;
            }
            $_SESSION["totExclTax"] = $totPrice;
            $_SESSION['tax'] = $tax;
            $totPrice = $totPrice + $tax;
    }
        if(($m == "Enter Check In and Check Out Dates to Book Rooms")){
            echo "<script>alert('$m')</script>";
        }
        elseif(($nSS==0) && ($nSD==0) && ($nDS==0) && ($nDD==0) && ($nDSt==0)){
            echo "<script>alert('Select atleast one room to proceed')</script>";
        }
        else{
            $_SESSION['payCart'] = "Reservations";
            header("location: payment.php");
        }
    }
    $sql = "SELECT * FROM bookings WHERE '$cInD'<=checkOutDate AND '$cOutD'>=checkInDate";
    $results = mysqli_query($conn, $sql);
    $cInDates = [];
    $cOutDates = [];
    $rNo = [];
    $rT = [];
    while($row = mysqli_fetch_assoc($results)){
        $cInDates[] = $row['checkInDate'];
        $cOutDates[] = $row['checkOutDate'];
        $rNo[] = $row['room_no'];
        $rT[] = $row['room_type'];
    }
    $rNo = array_unique($rNo);
    $noSS = $noSD = $noDS = $noDD = $noDSt = 5;
    foreach($rNo as $a){
        if(($a>=101) && ($a<=105)){
            $noSS--;
        }
        elseif(($a>=201) && ($a<=205)){
            $noSD--;
        }
        elseif(($a>=301) && ($a<=305)){
            $noDS--;
        }
        elseif(($a>=401) && ($a<=405)){
            $noDD--;
        }
        elseif(($a>=501) && ($a<=505)){
            $noDSt--;
        }
    }

    foreach($totRNo as $b){
        $f=0;
        foreach($rNo as $a){
            if($a == $b){
                $f=1;
                break;
            }
        }
        if($f==0){
            $avRNo[] = $b;
        }
    }

    $_SESSION['avRoomNo'] = $avRNo;
    $_SESSION["noSS"] = $noSS;
    $_SESSION["noSD"] = $noSD;
    $_SESSION["noDS"] = $noDS;
    $_SESSION["noDD"] = $noDD;
    $_SESSION["noDSt"] = $noDSt;
    $_SESSION["pSS"] = $pSS;
    $_SESSION["pSD"] = $pSD;
    $_SESSION["pDS"] = $pDS;
    $_SESSION["pDD"] = $pDD;
    $_SESSION["pDSt"] = $pDSt;
    $_SESSION["dpSS"] = $dpSS;
    $_SESSION["dpSD"] = $dpSD;
    $_SESSION["dpDS"] = $dpDS;
    $_SESSION["dpDD"] = $dpDD;
    $_SESSION["dpDSt"] = $dpDSt;
    $_SESSION["nSS"] = $nSS;
    $_SESSION["nSD"] = $nSD;
    $_SESSION["nDS"] = $nDS;
    $_SESSION["nDD"] = $nDD;
    $_SESSION["nDSt"] = $nDSt;
    $_SESSION["totPrice"] = $totPrice;
    $_SESSION["cartItemN"] = $cartItemN;
    $_SESSION["cartItemQ"] = $cartItemQ;
    $_SESSION["cartItemP"] = $cartItemP;
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
                    <a class="nav-link active" aria-current="page" href="home.php">Home</i></a>
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

    <section class="image" id="image">
        <a><img src="https://i.imgur.com/OYzi2Dm.png" title="source: imgur.com" style="width: 100%"/></a>
    </section>

    <div class="content" style="text-align: center;
            position: absolute;
            top: 25%;
            left: 0;
            right: 0;
            overflow: hidden;
            z-index: 5;
            color: #fff;">
        <h1 style="-webkit-text-stroke-width: 2px;-webkit-text-stroke-color: black;
        font-size: 200px; font-family:brush script mt">Welcome</h1>
    </div>
    
    <div class="container mt-4" style="width: 1500px;">
        <h2>Book Rooms</h2>
        <hr style="color: black; height: 1.5px;">
        
        <form action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <label for="ChkInDate" class="form-label">Check-In:</label>
                    <input type="date" class="form-control" name="CheckIn" id="ChkInDate">
                </div>
                <div class="col-md-6">
                    <label for="ChkOutDate" class="form-label">Check-Out:</label>
                    <input type="date" class="form-control" name="CheckOut" id="ChkOutDate">
                </div>
            </div>
            <br>
            <div class="col-6">
                <button type="submit" name="go" class="btn btn-primary">Go</button>
            </div>
            <br>
            <h4 style="text-align: center;"><?php echo $m?></h4>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/bUisFpo.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Standard (Single)</h3>
                    <table>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Maximum Occupancy</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">1 Person/Room</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Nightly Price/Room</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;font-weight: bold;">
                                <?php 
                                    if($_SESSION["dpSS"]>0){
                                        echo "<s style='color: darkred;'>&#8377;".$_SESSION['pSS']."</s>&nbsp;&#8377;".$_SESSION["dpSS"];
                                    }
                                    else{
                                        echo "&#8377;".$_SESSION['pSS'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Rooms Available</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"><?php echo $_SESSION['noSS']?></td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Rooms</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                                <input type="number" name="nSS" id="nSS" min="0" max="<?php echo $_SESSION['noSS']?>" value="<?php echo $_SESSION['nSS']?>" style="width: 50%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Room Features:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <ul>
                        <li>Single Bed</li>
                        <li>1 Person/Room</li>
                        <li>22 inch digital TV</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/CiFTH6P.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Standard (Double)</h3>
                    <table>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Maximum Occupancy</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">2 People/Room</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Nightly Price/Room</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;font-weight: bold;">
                                <?php 
                                
                                    if($_SESSION["dpSD"]>0){
                                        echo "<s style='color: darkred;'>&#8377;".$_SESSION['pSD']."</s>&nbsp;&#8377;".$_SESSION["dpSD"];
                                    }
                                    else{
                                        echo "&#8377;".$_SESSION['pSD'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Rooms Available</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"><?php echo $_SESSION['noSD']?></td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Rooms</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                            <input type="number" name="nSD" id="nSD" min="0" max="<?php echo $_SESSION['noSD']?>" value="<?php echo $_SESSION['nSD']?>" style="width: 50%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Room Features:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <ul>
                        <li>Double Bed</li>
                        <li>2 People/Room</li>
                        <li>22 inch digital TV</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/ZgBQnwI.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Deluxe (Single)</h3>
                    <table>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Maximum Occupancy</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">1 Person/Room</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"s>Nightly Price/Room</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;font-weight: bold;">
                                <?php 
                                    if($_SESSION["dpDS"]>0){
                                        echo "<s style='color: darkred;'>&#8377;".$_SESSION['pDS']."</s>&nbsp;&#8377;".$_SESSION["dpDS"];
                                    }
                                    else{
                                        echo "&#8377;".$_SESSION['pDS'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Rooms Available</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"><?php echo $_SESSION['noDS']?></td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Rooms</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                            <input type="number" name="nDS" id="nDS" min="0" max="<?php echo $_SESSION['noDS']?>" value="<?php echo $_SESSION['nDS']?>" style="width: 50%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Room Features:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <ul>
                        <li>Single Bed</li>
                        <li>1 Person/Room</li>
                        <li>32 inch digital TV</li>
                        <li>AC from 9am to 5pm and 10pm-6am</li>
                        <li>WiFi available 24/7</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/9Z3O837.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Deluxe (Double)</h3>
                    <table>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Maximum Occupancy</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">2 People/Room</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Nightly Price/Room</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;font-weight: bold;">
                                <?php 
                                    if($_SESSION["dpDD"]>0){
                                        echo "<s style='color: darkred;'>&#8377;".$_SESSION['pDD']."</s>&nbsp;&#8377;".$_SESSION["dpDD"];
                                    }
                                    else{
                                        echo "&#8377;".$_SESSION['pDD'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Rooms Available</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"><?php echo $_SESSION['noDD']?></td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Rooms</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                            <input type="number" name="nDD" id="nDD" min="0" max="<?php echo $_SESSION['noDD']?>" value="<?php echo $_SESSION['nDD']?>" style="width: 50%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Room Features:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <ul>
                        <li>Double Bed</li>
                        <li>1 Lawson Sofa</li>
                        <li>2 People/Room</li>
                        <li>32 inch digital TV</li>
                        <li>AC from 9am to 5pm and 10pm-6am</li>
                        <li>WiFi available 24/7</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-4" style="padding: 30px;">
                    <img src="https://i.imgur.com/6Ygg842.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px; margin-top: 12px;"/>
                </div>
                <div class="col-md-4" style="padding: 30px;">
                    <h3>Deluxe Suite</h3>
                    <table>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Maximum Occupancy</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">2 People/Room</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Nightly Price/Room</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;font-weight: bold;">
                                <?php 
                                    if($_SESSION["dpDSt"]>0){
                                        echo "<s style='color: darkred;'>&#8377;".$_SESSION['pDSt']."</s>&nbsp;&#8377;".$_SESSION["dpDSt"];
                                    }
                                    else{
                                        echo "&#8377;".$_SESSION['pDSt'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">Rooms Available</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"><?php echo $_SESSION['noDSt']?></td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">No. of Rooms</th>
                            <td style="border: 1px solid black; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px;">
                                <input type="number" name="nDSt" id="nDSt" min="0" max="<?php echo $_SESSION['noDSt']?>" value="<?php echo $_SESSION['nDSt']?>" style="width: 50%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4" style="padding: 40px; padding-top: 35px;">
                <h4>Room Features:</h4>
                    <div style="font-size: 17px; border: 1px solid black; padding: 10px; padding-bottom: 5px; font-style: italic;">
                        <ul>
                            <li>Double Bed</li>
                            <li>1 Sectional Sofa</li>
                            <li>2 People/Room</li>
                            <li>43 inch Smart TV with Hotstar VIP</li>
                            <li>AC available 24/7</li>
                            <li>WiFi available 24/7</li>
                        </ul>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-12">
                <button type="submit" name="reserve" class="btn btn-primary" onmouseover="this.style.backgroundColor='rgb(170, 0, 0)';return true;" onmouseout="this.style.backgroundColor='red';return true;" style="background: red; border: red; float: right;">Proceed to Pay</button>
            </div>
            <br><br>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

  </body>
</html>