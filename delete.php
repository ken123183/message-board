<?php
session_start();
require_once('config.php');
$id = $_GET['id'];
$sql3 = "select * from post WHERE `id` = '$id'";
$result2 = mysqli_query($link, $sql3);
$row = mysqli_fetch_assoc($result2);
if ($_SESSION["users"] != $row['username']) 
{
    echo '你不是貼文者';
    echo "
         <script>
            setTimeout(function(){window.location.href='return.php';},300);
        </script>";
    return;
}
$fname = $row['filename'];
if(file_exists($fname))
    unlink($fname);
$sql = "delete from post where id='$id'";
mysqli_query($link, $sql);
if (!mysqli_query($link, $sql)) {
	die(mysqli_error());
} else {
    echo '刪除成功';
	echo "
         <script>
            setTimeout(function(){window.location.href='return.php';},300);
        </script>";

}
?>