<?php
session_start();
require_once('config.php');
if( !isset($_POST['username']) || !isset($_POST['password']) || $_POST['username']=="" || $_POST['password']=="" ){
    header("Location: index.php");
}
$username = $_POST['username'];
$password = $_POST['password'];
if(!ctype_alnum($username))
{
    echo '不能有特殊符號';
    echo "  <script>
                setTimeout(function(){window.location.href='index.php';},500);
                </script>";
    return;
}

require_once('config.php');
$sql = "SELECT * FROM `users` WHERE `username` = '$username' and `password` = '$password';";

$result=mysqli_query($link,$sql);
mysqli_close($link);
try {
    $row = mysqli_fetch_array($result);   
    
    if($row ){
        $_SESSION["users"] = $username;
        $_SESSION["admin"] = $row["admin"];
        header("Location: https://demo.ken123183.social/index.php");
        echo $_SESSION["users"], '<br>';
        echo '登入成功';
    }else{
        echo '登入失敗';
    }
}

catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}


?>

<form method="POST" action="return.php">
    <button  type="submit">返回</button>
</form>