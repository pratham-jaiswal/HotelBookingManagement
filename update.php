<?php
require_once "config.php";
if (isset($_GET['id'])){
    echo 11;
    $sql = 'UPDATE contactform SET replied = "YES" WHERE id ='.$_GET["id"];
    if(mysqli_query($conn, $sql))
    {
        echo "<script>alert('Updated Successfully!')</script>";
        
    }
    else{
        echo "<script>alert('Unable to update..')</script>";
    }
    echo "<script>window.location.replace('dashboard.php')</script>";
    exit();
}
elseif (isset($_GET['booking_id'])){
    echo 11;
    $sql = 'UPDATE bookings SET checked_in = "YES" WHERE booking_id ='.$_GET["booking_id"];
    if(mysqli_query($conn, $sql))
    {
        echo "<script>alert('Updated Successfully!')</script>";
        
    }
    else{
        echo "<script>alert('Unable to update..')</script>";
    }
    echo "<script>window.location.replace('dashboard.php')</script>";
    exit();
}
else{
    if($_SESSION["admin"]=='NO'){
        header("location: home.php");
        exit();
    }
    else{
        header("location: dashboard.php");
        exit();
    }
}
?>