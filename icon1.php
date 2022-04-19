<?php
SESSION_start();
require_once('config.php');

if (!isset($_POST['submit'])) die();

$url = $_POST['url'];
$fname = basename($url);
$temp = explode(".",$fname);
$extension = $temp[1];
# echo $extension;
$allow = array("jpg","png");
$temp1 = array_search($extension,$allow);
if (!($temp1 !== false))
{
    #echo $temp;
    echo '你的檔案類型為'.$extension;
    echo '只能上傳 jpg or png';
    echo "  <script>
                setTimeout(function(){window.location.href='index.php';},500);
                </script>";
    return; 
}
$newfname = md5(uniqid(microtime(true), true)).'.'.$extension;

file_put_contents( $newfname, fopen($url, 'r'));
$username = $_SESSION["users"];

$sql2 = "SELECT * FROM `users` WHERE `username` = '$username';";
$result=mysqli_query($link,$sql2);
$row = mysqli_fetch_array($result);   
# 刪除舊檔案
# echo $row['iconname'];
if (file_exists($row['iconname']))
    unlink($row['iconname']);

$sql = "UPDATE users SET iconname = '$newfname' WHERE username = '$username';";
if($result=mysqli_query($link,$sql)){
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
mysqli_close($link);
?>

<form method="POST" action="return.php">
    <button  type="submit">返回</button>
</form>