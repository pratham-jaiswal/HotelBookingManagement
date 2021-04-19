<?php
require_once "config.php";

$email = $username = $password = $confirm_password = "";
$err = $password_err = $confirm_password_err = "";
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])) || empty(trim($_POST['email'])) || empty(trim($_POST['confirm_password']))){
        $err = "Please enter all details";
    }
    else{
        $username = trim($_POST['username']);
        $email  = trim($_POST['email']);
        $password = trim($_POST['password']);
    }
}
if(empty($err)){
    $sql = "SELECT email, username, password FROM loginform where username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
            mysqli_stmt_bind_result($stmt, $email, $username, $hashed_password);
            if(mysqli_stmt_fetch($stmt)){
                session_start();
                if($email == $_POST['email']){
                    //Password is correct. Allow user to login
                    if(empty(trim($_POST['password']))){
                        $password_err = "Password cannot be blank";
                    }
                    elseif(strlen(trim($_POST['password'])) < 5){
                        $password_err = "Password cannot be less than 5 characters";
                    }
                    else{
                        $password = trim($_POST['password']);
                    }
                
                    //Confirm Password validation
                    if(trim($_POST['password']) != trim($_POST['confirm_password'])){
                        $confirm_password_err = "Passwords should match";
                    }
                    if(empty($password_err)){
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $sql="UPDATE loginform SET password='$password' where username='$username'";
                        $stmt = mysqli_query($conn, $sql);
                        header("location: login.php");
                    }
                    else{    
                        echo "<script>alert('$password_err')</script>";
                    }
                }
                else{
                    $err = "Wrong Email address";
                    echo "<script>alert('$err')</script>";
                }
            }
        }
    }
}
else{ 
    echo "<script>alert('$err')</script>";
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
                    <a class="nav-link  active" aria-current="page" href="forgotPassword.php">Reset Password <i class="fa fa-pencil" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register <i class="fa fa-user-plus" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login <i class="fa fa-sign-in" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>

<div class="container mt-4">
    <h2>Reset Password</h2>
    <hr>
    <form action="" method="post">
    <div class="row">
        <div class="col-md-6">
            <label for="inputEmail3" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" id="inputEmail3">
        </div>
        <div class="col-md-6">
                <label for="inputUname" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="inputUname">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="inputPassword3" class="form-label">New Password</label>
            <input type="password" class="form-control" name="password" id="inputPassword3">
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" id="inputPassword">
        </div>
    </div>
    <br>
    <div class="col-12">
            <button type="submit" class="btn btn-primary">Reset</button>
    </div>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>