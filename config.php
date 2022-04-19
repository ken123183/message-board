<?php

session_start();
define('DB_SERVER', 'db');
define('DB_USERNAME', 'ken123183');
define('DB_PASSWORD', 'PASSWORD_ken123183');
define('DB_NAME', 'myDb');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>