<?php

session_start();
require_once('config.php');
if( !isset($_POST['username']) || !isset($_POST['password']) || $_POST['username']=="" || $_POST['password']=="" ){
    header("Location: index.php");
}
$username = $_POST['username'];
$password = $_POST['password'];
if(!ctype_alnum($username) || !ctype_alnum($password))
{
    echo '不能有特殊符號';
    return;
}
require_once('config.php');
$sql = "SELECT * FROM `users` WHERE `username` = '$username'";

$result=mysqli_query($link,$sql);
try {
    $row = mysqli_fetch_array($result);   
    
    if($row ){
        echo 'username註冊過了';
    }else{
        $sql = "INSERT INTO `users`(`username`,`password`) VALUES('".$username."','".$password."')";
        if(mysqli_query($link, $sql)){
            echo "Records inserted successfully.";
            echo "
            <script>
            setTimeout(function(){window.location.href='return.php';},1000);
            </script>";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        mysqli_close($link);
    }
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}
?>