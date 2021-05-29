<?php
session_start();
require_once "config.php";
if(isset($_SESSION['username'])){
    if($_SESSION["admin"]=='YES'){
        header("location: dashboard.php");
    }
    else{
        header("location: home.php");
    }
    exit();
}

$fname = $lname = $email = $username = $password = $confirm_password = "";
$fname_err = $lname_err = $email_err = $username_err = $password_err = $confirm_password_err = "";


if($_SERVER['REQUEST_METHOD']=="POST"){
    //Check if first name is empty
    if(empty(trim($_POST['fname']))){
        $fname_err = "First Name cannot be blank";
    }
    else{
        $sql = "SELECT id FROM loginform WHERE fname = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_fname);

            //Set the value of param fname
            $param_fname = trim($_POST['fname']);
            //Try to execute the statement
            if(mysqli_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                $fname = trim($_POST['fname']);
            }
            else{
                echo "<script>alert('Something went wrong');</script>";
            }
        }
    }

    //Check if last name is empty
    if(empty(trim($_POST['lname']))){
        $lname_err = "Last Name cannot be blank";
    }
    else{
        $sql = "SELECT id FROM loginform WHERE lname = ?";
        $stmt = mysqli_prepare($conn, $sql);
        $results = mysqli_query($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_lname);

            //Set the value of param lname
            $param_lname = trim($_POST['lname']);
            //Try to execute the statement
            if(mysqli_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                $lname = trim($_POST['lname']);
            }
            else{
                echo "<script>alert('Something went wrong');</script>";
            }
        }
    }
    
    //Check if email is empty
    if(empty(trim($_POST['email']))){
        $email_err = "Email cannot be blank";
    }
    else{
        $sql = "SELECT id FROM loginform WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            //Set the value of param email
            $param_email = trim($_POST['email']);
            //Try to execute the statement
            if(mysqli_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken";
                }
                else{
                    $email = trim($_POST['email']);
                }
            }
            else{
                echo "<script>alert('Something went wrong');</script>";
            }
        }
    }

    //Check if username is empty
    if(empty(trim($_POST['username']))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM loginform WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //Set the value of param username
            $param_username = trim($_POST['username']);
            //Try to execute the statement
            if(mysqli_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken";
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "<script>alert('Something went wrong');</script>";
            }
        }
    }
    

    //Password validation
    if(empty(trim($_POST['password']))){
        $password_err = "Password cannot be blank";
    }
    elseif(strlen(trim($_POST['password'])) < 8){
        $password_err = "Password cannot be less than 8 characters";
    }
    else{
        $password = trim($_POST['password']);
    }

    //Confirm Password validation
    if(trim($_POST['password']) != trim($_POST['confirm_password'])){
        $confirm_password_err = "Passwords should match";
    }

    //If there were no errors then insert the values into the database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($fname_err) && empty($lname_err)){
        $sql = "INSERT INTO loginform (fname, lname, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if($stmt){
            mysqli_stmt_bind_param($stmt, "sssss", $param_fname, $param_lname, $param_email, $param_username, $param_password);

            //Set these parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            //Try to execute the query
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            }
            else{
                echo "<script>alert('Something went wrong.. Cannot Redirect');</script>";
            }
        }
        mysqli_stmt_close($stmt);
    }
    else{
        if(!empty($fname_err)){
            echo "<script>alert('$fname_err')</script>";
        }
        elseif(!empty($lname_err)){
            echo "<script>alert('$lname_err')</script>";
        }
        elseif(!empty($email_err)){
            echo "<script>alert('$email_err')</script>";
        }
        elseif(!empty($username_err)){
            echo "<script>alert('$username_err')</script>";
        }
        elseif(!empty($password_err)){
            echo "<script>alert('$password_err')</script>";
        }
        elseif(!empty($confirm_password_err)){
            echo "<script>alert('$confirm_password_err')</script>";
        }
    }
    mysqli_close($conn);
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
                    <a class="nav-link active" aria-current="page" href="register.php">Register <i class="fa fa-user-plus" aria-hidden="true"></i></a>
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
    <h2>Please Register</h2>
    <hr>
    <form action="" method="post">
        <div class="row">
            <div class="col-md-6">
                <label for="inputFName" class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" id="inputFName">
            </div>
            <div class="col-md-6">
                <label for="inputLName" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" id="inputLName">
            </div>
        </div>
            <br>
        <div class="row">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputUname" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="inputUname">
            </div>
        </div>
            <br>
        <div class="row">
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="inputPassword4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="inputPassword">
            </div>
        </div>
        <br>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
