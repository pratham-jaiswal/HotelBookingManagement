<?php
require_once "config.php";
session_start();
$name = $email = $message = "";
$name_err = $email_err = $message_err = "";
//name validation
if($_SERVER['REQUEST_METHOD']=="POST"){
    //Check if name is empty
    if(empty(trim($_POST['name']))){
        $name_err = "Name cannot be blank";
    }
    else{
        $sql = "SELECT id FROM contactform WHERE name = ?";
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

    //Check if message is empty
    if(empty(trim($_POST['message']))){
        $message_err = "Message cannot be blank";
    }
    else{
        $sql = "SELECT id FROM contactform WHERE message = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_message);

            //Set the value of param message
            $param_message = trim($_POST['message']);
            //Try to execute the statement
            if(mysqli_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                $message = trim($_POST['message']);
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
        $sql = "SELECT id FROM contactform WHERE email = ?";
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
    //If there were no errors then insert the values into the database
    if(empty($name_err) && empty($email_err) && empty($message_err)){
        $sql = "INSERT INTO contactform (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_message);
            $param_name = $name;
            $param_email = $email;
            $param_message = $message;
            if(mysqli_stmt_execute($stmt)){
                echo "<script>alert('Submitted Successfully')</script>";
            }
            else{
                echo "<script>alert('Something went wrong.. Cannot Redirect');</script>";
            }
        }
        else{
            echo 'Something went wrong';
        }
    }
    else{
        if(!empty($name_err)){
            echo "<script>alert('$name_err')</script>";
        }
        elseif(!empty($email_err)){
            echo "<script>alert('$email_err')</script>";
        }
        elseif(!empty($message_err)){
            echo "<script>alert('$username_err')</script>";
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
            <?php if(!isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register <i class="fa fa-user-plus" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login <i class="fa fa-sign-in" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.php">Contact <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="accountInfo.php"><?php echo $_SESSION['fname']?> <i class="fa fa-user" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</i></a>
                </li>
                <?php if($_SESSION["admin"]=='YES'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Admin</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.php">Contact <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </nav>

<div class="container mt-4">
    <h2>Contact Us</h2>
    <hr>
    <form action="" method="post">
        <div class="row">
            <div class="col-6">
                <label for="inputname" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="inputname">
            </div>
            <div class="col-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="inputEmail4">
            </div>
        </div>
        <br>
        <div class="col-12">
            <label for="message" class="form-label">Message</label>
            <textarea type="text" class="form-control" name="message" style="height: 300px;text-align: top;"></textarea>
        </div>
        <br>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>