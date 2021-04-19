<?php
session_start();
require_once "config.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
}
else{
    $sql = "SELECT * FROM loginform where username='".$_SESSION['username']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if(isset($_POST['forgotPassword'])){
    session_start();
    $_SESSION = array();
    session_destroy();
    header("location: forgotPassword.php");
}
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
    <link rel="stylesheet" href="style.css" />
    <title>Hotel Booking Management</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hotel Booking Management</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="accountInfo.php"><?php echo $row['fname']?> <i class="fa fa-user" aria-hidden="true"></i></a>
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

<div class="container mt-4">
    <a href="https://imgur.com/VhlK1IB"><img src="https://i.imgur.com/VhlK1IB.png" title="source: imgur.com" class="img" /></a>
    <h2>Account Details</h2>
    <hr>
    <table>
        <tr>
            <th>Name:</th>
            <td><?php echo $_SESSION['fname']?> <?php echo $_SESSION['lname']?></td>
        </tr>
        <tr>
            <th>Username:</th>
            <td><?php echo $_SESSION['username']?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo $_SESSION['email']?></td>
        </tr>
        <tr>
            <th>Created On:</th>
            <td><?php echo $row['created_at']?></td>
        </tr>
    </table>
    <br>
    <form action="" method="post">
    <div class="col-12" style="text-align: right">
        <button type="forgotPassword" name="forgotPassword" class="btn btn-primary" style="background: red; border: red; padding: 10px;'">Reset Password</button>
    </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>