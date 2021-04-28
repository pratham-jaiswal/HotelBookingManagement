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
    $bookingId = [];
    $sql = "SELECT * FROM bookings WHERE username='".$username."'";
    $results = mysqli_query($conn, $sql);
    if(!empty($results)){
        while($row = mysqli_fetch_assoc($results)) {
            $bookingId[] = $row['booking_id'];
        }
    }
    $html = "<h2>Bookings</h2><hr style='color: black; height: 1.5px; opacity: 0.6;'>";
    if(empty($bookingId))
    {
        $html .=  "<h4 style='color: grey;'>No bookings yet!</h4><br><br><br><br><br><br><br>";
    }
    else{
        $bookingId = array_unique($bookingId);
        
        $c = 0;
        foreach($bookingId as $bid){
            $sql = "SELECT * FROM bookings WHERE booking_id=$bid";
            $results = mysqli_query($conn, $sql);
            $room_no = [];
            $checkInDate = [];
            $checkOutDate = [];
            $room_type = [];
            $reserved_on = [];
            $username = [];
            $name = [];
            $email = [];
            $price = [];
            if(!empty($results)){
                $i=0;
                while($row = mysqli_fetch_assoc($results)){
                    if($i==0){
                        $checkInDate[] = $row['checkInDate'];
                        $checkOutDate[] = $row['checkOutDate'];
                        $reserved_on[] = $row['reserved_on'];
                        $username[] = $row['username'];
                        $name[] = $row['name'];
                        $email[] = $row['email'];
                        $i=1;
                    }
                    $price[] = $row['price'];
                    $room_type[] = $row['room_type'];
                    $room_no[] = $row['room_no'];
                }
                $totDays = (strtotime($checkOutDate[0]) - strtotime($checkInDate[0]))/(60 * 60 * 24);
                $room_type = array_unique($room_type);
                $price = array_unique($price);

                $html .= '<div class="row"><div class="col-md-6"><h4>Booking ID: '.$bid.'</h4><br>';
                $html .= '</div><div class="col-md-6"><button type="submit" name="print" onclick="printArea('.$bid.')" class="btn btn-primary" style="float: right;">View</button></div>';
                $html .= "</div><div class='container mt-4' id='".$bid."' style='width: 800px; display: none;'>";
                $html .= '<h1 style="font-family: Brush Script MT; font-size: 50px; text-align: center;">Hotel Booking Management System</h1><hr style="color: black; height: 1.5px; opacity: 1;"><br>';
                $html .= "<div class='row'><div class='col-md-6'>";
                $html .= "Booking ID: ".$bid."</div><div class='col-md-6'>";
                $html .= "Reserved On: ".$reserved_on[$c]."</div><div class='col-md-6'>Name: ".$name[$c]."</div><div class='col-md-6'>Email: ".$email[$c]."</div>";
                $html .= "<div class='col-md-6'>Check-In Date: ".$checkInDate[0]."</div><div class='col-md-6'>Check-Out Date: ".$checkOutDate[0]."</div></div>";
                $html .= '<br><table style="width: 100%; border: 1px solid black">';
                $html .= '<tr>';
                $html .= '<th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Room Type</th>';
                $html .= '<th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Rooms Numbers</th>';
                $html .= '<th style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Net Price</th>';
                $html .= '</tr>';
                $pi = 0;
                $totpr = 0;
                foreach($room_type as $rt){
                    $html .= '<tr>';
                    $html .= '<td style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$rt.'</td>';
                    $html .= '<td style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">';
                    $nr = 0;
                    
                    foreach($room_no as $rn){
                        if((($rn>100)&&($rn<=105))&&($rt=='Standard (Single)')){
                            $html .= $rn." ";
                            $nr++;
                        }
                        elseif((($rn>200)&&($rn<=205))&&($rt=='Standard (Double)')){
                            $html .= $rn." ";
                            $nr++;
                        }
                        elseif((($rn>300)&&($rn<=305))&&($rt=='Deluxe (Single)')){
                            $html .= $rn." ";
                            $nr++;
                        }
                        elseif((($rn>400)&&($rn<=405))&&($rt=='Deluxe (Double)')){
                            $html .= $rn." ";
                            $nr++;
                        }
                        elseif((($rn>500)&&($rn<=505))&&($rt=='Deluxe Suite')){
                            $html .= $rn." ";
                            $nr++;
                        }
                    }
                    $a = 0;
                    foreach($price as $p){
                        
                        if($a==$pi){
                            $html .= '</td><td style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">&#8377;'.$nr*$p*$totDays.'</td>';
                            $totpr = $totpr + ($nr*$p*$totDays);
                        }
                        $a++;
                    }
                    $pi++;
                    $html .= '</tr>';
                }
                $html .= '<tr>';
                $html .= '<td style="font-weight: bold; padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Total</td>';
                $html .= '<td style="font-weight: bold; padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"></td>';
                $html .= '<td style="font-weight: bold; padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">'.$totpr.'</td>';
                $html .= '</tr>';

                if(($totpr>0)&&($totpr<=1000)){
                    $tax = 0;
                    $taxp = 0;
                }
                elseif(($totpr>1000) && ($totpr<=7500)){
                    $tax = $totpr*(12/100);
                    $taxp = 12;
                }
                else{
                    $tax = $totpr*(18/100);
                    $taxp = 18;
                }
                $totpr = $totpr + $tax;


                $html .= '<tr>';
                $html .= '<td style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Tax ('.$taxp.'%)</td>';
                $html .= '<td style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"></td>';
                $html .= '<td style="padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">&#8377;'.$tax.'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="font-weight: bold;padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">Net Total</td>';
                $html .= '<td style="font-weight: bold;padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;"></td>';
                $html .= '<td style="font-weight: bold;padding-left: 30px; padding-bottom: 10px; padding-top: 10px; border: 1px solid black;">&#8377;'.$totpr.'</td>';
                $html .= '</tr>';
                $html .= '</table>';
                $html .= '<br><br>';
                $html .= '</div>';        
            }
        }
    }



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
                    echo '<li class="nav-item"><a class="nav-link" href="rooms.php">Admin</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="contactt.php">Contact <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
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
    <br><br>
    <form action="" method="post">
        <?php echo $html; ?>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>