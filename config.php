<?php
/*
This fille contains database configuration assuming you are running mysql using
user "root" and password ""
*/

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'hotelbookingmanagement');

//Trying to conne ct to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check the connection
if($conn==false){
    dir('Error: Cannot connect');
}
?>