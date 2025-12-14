<?php
$HOSTNAME = "127.0.0.1";
$USERNAME = "root";
$PASSWORD = ""; 
$DATABASE = "shop_db";
$PORT     = 4306; 
$conn  = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE, $PORT);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>