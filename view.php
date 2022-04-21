<?php
require_once('config.php');
$id = $_GET['id'];
$sql3 = "select * from post WHERE `id` = '$id'";
$result2 = mysqli_query($link, $sql3);

while ($row = mysqli_fetch_assoc($result2)) {
	$tmp =$row['username'];
	$sql4 = "select * from `users` where `username` = '$tmp'";
	$result4 = mysqli_query($link, $sql4);
	$row3 = mysqli_fetch_assoc($result4);
	echo "<br>名字：" . $row['username'];

    $context = $row['content'];
    $context = str_replace(">"," ",$context);
	$context = str_replace("<"," ",$context);
    $context = str_replace("[b]","<b>",$context);
    $context = str_replace("[/b]","</b>",$context);
    $context = str_replace("[i]","<i>",$context);
    $context = str_replace("[/i]","</i>",$context);
    $context = str_replace("[u]","<u>",$context);
    $context = str_replace("[/u]","</u>",$context);
    $context = str_replace("[img]","<img src=\"",$context);
    $context = str_replace("[/img]","\">",$context);
    $context = str_replace("[/color]","</span>",$context);
    $context = str_replace("[color=","<span style=\"color: ",$context);
    $context = str_replace("]",";\">",$context);

	echo "<br>留言：" . nl2br($context) . "<br>";
	if ($row['filename'] != null) { 
		echo "附加檔案：";
		echo ' 
		<a href="./'. $row['filename'] .'">'. $row['filename'] .'<br></a>';
	}
	echo "<hr>";
}
echo "<br>";
?>

<form method="POST" action="return.php">
    <button  type="submit">返回</button>
</form>

