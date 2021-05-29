<?php
require_once "config.php";
session_start();
if (isset($_GET['id'])){
    $sql = 'SELECT * FROM bookings WHERE id = '.$_GET['id'];
    $results = mysqli_query($conn, $sql);
    $del = mysqli_fetch_assoc($results);
    if(mysqli_num_rows($results)==0){
        exit('Booking doesn\'t exist');
    }
    $sql = 'DELETE FROM bookings WHERE id = '.$_GET['id'];
    if(mysqli_query($conn, $sql))
    {
        echo "<script>alert('Deleted Booking Successfully!')</script>";
        
    }
    else{
        echo "<script>alert('Unable to delete..')</script>";
    }
    echo "<script>window.location.replace('dashboard.php')</script>";
    exit();
}
elseif (isset($_GET['booking_id'])){
    $sql = 'SELECT * FROM bookings WHERE booking_id = '.$_GET['booking_id'];
    $results = mysqli_query($conn, $sql);
    $del = mysqli_fetch_assoc($results);
    if(mysqli_num_rows($results)==0){
        exit('Booking doesn\'t exist');
    }
    $sql = 'DELETE FROM bookings WHERE booking_id = '.$_GET['booking_id'];
    if(mysqli_query($conn, $sql))
    {
        echo "<script>alert('Cancelled Booking Successfully!')</script>";
        
    }
    else{
        echo "<script>alert('Unable to cancel..')</script>";
    }
    echo "<script>window.location.replace('accountInfo.php')</script>";
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