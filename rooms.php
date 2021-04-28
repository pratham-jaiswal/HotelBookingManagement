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

    $prices = [];
    $dprices = [];
    $sql = "SELECT * FROM rooms";
    $results = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($results)) {
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

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $pSS = $_POST['npss'];
        $pSD = $_POST['npsd'];
        $pDS = $_POST['npds'];
        $pDD = $_POST['npdd'];
        $pDSt = $_POST['npdst'];
        $dpSS = $_POST['dpss'];
        $dpSD = $_POST['dpsd'];
        $dpDS = $_POST['dpds'];
        $dpDD = $_POST['dpdd'];
        $dpDSt = $_POST['dpdst'];
    }
    $f = 0;
    if(isset($_POST['updateRooms'])){
        $sql = "UPDATE rooms SET price=$pSS, discountedPrice=$dpSS WHERE room_type='Standard Single'";
        if (mysqli_query($conn, $sql)){
            $f = 1;
        }
        else{
            $f = 0;
        }
        $sql = "UPDATE rooms SET price=$pSD, discountedPrice=$dpSD WHERE room_type='Standard Double'";
        if (mysqli_query($conn, $sql)){
            $f = 1;
        }
        else{
            $f = 0;
        }
        $sql = "UPDATE rooms SET price=$pDS, discountedPrice=$dpDS WHERE room_type='Deluxe Single'";
        if (mysqli_query($conn, $sql)){
            $f = 1;
        }
        else{
            $f = 0;
        }
        $sql = "UPDATE rooms SET price=$pDD, discountedPrice=$dpDD WHERE room_type='Deluxe Double'";
        if (mysqli_query($conn, $sql)){
            $f = 1;
        }
        else{
            $f = 0;
        }
        $sql = "UPDATE rooms SET price=$pDSt, discountedPrice=$dpDSt WHERE room_type='Deluxe Suite'";
        if (mysqli_query($conn, $sql)){
            $f = 1;
        }
        else{
            $f = 0;
        }
        if($f==1){
            echo "<script>alert('Price(s) updated successfully')</script>";
        }
        else{
            echo "<script>alert('Something went wrong')</script>";
        }

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
                    <a class="nav-link active" aria-current="page" href="rooms.php">Rooms</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container mt-4" style="width: 1000px;">
        <h2>Rooms</h2>
        <hr style="color: black; height: 1.5px;">
        <br>
        <form action="" method="post">
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-6" style="padding: 30px;">
                    <img src="https://i.imgur.com/bUisFpo.png" title="source: imgur.com" style="width: 100%;border: 4px solid white; border-radius: 10px;"/>
                </div>
                <div class="col-md-6" style="padding: 30px;">
                    <h3>Standard (Single)</h3>
                    <hr style="color: black; height: 1.5px; opacity: 0.4;">
                    <div class="col">
                        <label for="npss" class="form-label" style="font-weight: bold;">Nightly Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="npss" min="0" value="<?php echo $pSS?>" id="npss">
                    </div>
                    <br>
                    <div class="col">
                        <label for="dpss" class="form-label" style="font-weight: bold;">Discounted Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="dpss" min="0" max="<?php echo $pSS?>" value="<?php echo $dpSS?>" id="dpss">
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-6" style="padding: 30px;">
                    <img src="https://i.imgur.com/CiFTH6P.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px;"/>
                </div>
                <div class="col-md-6" style="padding: 30px;">
                    <h3>Standard (Double)</h3>
                    <hr style="color: black; height: 1.5px; opacity: 0.4;">
                    <div class="col">
                        <label for="npsd" class="form-label" style="font-weight: bold;">Nightly Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="npsd" min="0" value="<?php echo $pSD?>" id="npsd">
                    </div>
                    <br>
                    <div class="col">
                        <label for="dpsd" class="form-label" style="font-weight: bold;">Discounted Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="dpsd" min="0" max="<?php echo $pSD?>" value="<?php echo $dpSD?>" id="dpsd">
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-6" style="padding: 30px;">
                    <img src="https://i.imgur.com/ZgBQnwI.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px;"/>
                </div>
                <div class="col-md-6" style="padding: 30px;">
                    <h3>Deluxe (Single)</h3>
                    <hr style="color: black; height: 1.5px; opacity: 0.4;">
                    <div class="col">
                        <label for="npds" class="form-label" style="font-weight: bold;">Nightly Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="npds" min="0" value="<?php echo $pDS?>" id="npds">
                    </div>
                    <br>
                    <div class="col">
                        <label for="dpds" class="form-label" style="font-weight: bold;">Discounted Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="dpds" min="0" max="<?php echo $pDS?>" value="<?php echo $dpDS?>" id="dpds">
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-6" style="padding: 30px;">
                    <img src="https://i.imgur.com/9Z3O837.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px;"/>
                </div>
                <div class="col-md-6" style="padding: 30px;">
                    <h3>Deluxe (Double)</h3>
                    <hr style="color: black; height: 1.5px; opacity: 0.4;">
                    <div class="col">
                        <label for="npdd" class="form-label" style="font-weight: bold;">Nightly Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="npdd" min="0" value="<?php echo $pDD?>" id="npdd">
                    </div>
                    <br>
                    <div class="col">
                        <label for="dpdd" class="form-label" style="font-weight: bold;">Discounted Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="dpdd" min="0" max="<?php echo $pDD?>" value="<?php echo $dpDD?>" id="dpdd">
                    </div>
                </div>
            </div>
            <div class="row" style="background: orange; margin: 2%; border-radius: 20px;">
                <div class="col-md-6" style="padding: 30px;">
                    <img src="https://i.imgur.com/6Ygg842.png" title="source: imgur.com" style="width: 100%; border: 4px solid white; border-radius: 10px;"/>
                </div>
                <div class="col-md-6" style="padding: 30px;">
                    <h3>Deluxe Suite</h3>
                    <hr style="color: black; height: 1.5px; opacity: 0.4;">
                    <div class="col">
                        <label for="npdst" class="form-label" style="font-weight: bold;">Nightly Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="npdst" min="0" value="<?php echo $pDSt?>" id="npdst">
                    </div>
                    <br>
                    <div class="col">
                        <label for="dpdst" class="form-label" style="font-weight: bold;">Discounted Price/Room (&#8377;)</label>
                        <input type="number" class="form-control" name="dpdst" min="0" max="<?php echo $pDSt?>" value="<?php echo $dpDSt?>" id="dpdst">
                    </div>
                </div>
            </div>
            <br>
            <div class="col-12">
                <button type="submit" name="updateRooms" class="btn btn-primary" style="float: right;">Update</button>
            </div>
            <br><br>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>