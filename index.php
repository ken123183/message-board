<?php
session_start();
require_once('config.php');
$sql = "select * from title";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
	echo "<b> TITLE : " . nl2br($row['text']) . "</b>    <br>";
}
if($_SESSION["users"]) {
    $username = $_SESSION["users"];
    $sql = "SELECT * FROM `users` WHERE `username` = '$username';";
    $result=mysqli_query($link,$sql);
    try {
        $row = mysqli_fetch_array($result);
        if($row)
        {
            $image = $row["iconname"];
            $temp = explode(".",$image);
            $extension = $temp[1];
            $allow = array("jpg","png");
            $temp1 = array_search($extension,$allow);
            # echo $image.'<br>',$temp.'<br>',$extension.'<br>',$temp1.'<br>';
            if ($temp1 !== false)
            {
                echo '頭貼:';
                echo "<img src = \"$image\" width='50' height = '50';></img><br>";
            }
            else 
            {
                echo '沒有大頭貼<br>';
            }
        } 
    }
    catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), '<br>';
        echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    }
    
    echo "hello, user : " , $_SESSION["users"], '<br>';
    if(isset($_SESSION["admin"]) and $_SESSION["admin"] == true) echo "你是管理員 <br>";
    else echo"你不是管理員 <br>";
} 
else{
    echo "趕緊的 註冊 <br>";
} 
echo htmlspecialchars(date('G:i'));
?>
<html>
<script type='text/javascript'>
    window.onload=function (){
        var online = '<?=$_SESSION["users"]?>';
        var admin = '<?=$_SESSION["admin"]?>';
        if (!online){
            let element = document.getElementById("offline");
            element.style.visibility = 'visible';
            element.style.display = 'block';
        }
        else{
            let element = document.getElementById("online");
            element.style.visibility = 'visible';
            element.style.display = 'block';
        }
        if(admin == 1){
            let element = document.getElementById("admin");
            element.style.visibility = 'visible';
            element.style.display = 'block';
        }
    }
</script>
<div id = "offline" style="visibility:hidden;display:none">
    <form method="POST" action="registered.php">
        <input id="username" placeholder="Username" required="" autofocus="" type="text" name="username">
        <input id="password" placeholder="Password" required="" type="password" name="password">
        <button  type="submit">註冊</button>
    </form>

    <form method="POST" action="login.php">
        <input id="username" placeholder="Username" required="" autofocus="" type="text" name="username">
        <input id="password" placeholder="Password" required="" type="password" name="password">
        <button  type="submit">登入</button>
    </form>
</div>

<div id = "online" style="visibility:hidden;display:none">
    <form method="POST" action="logout.php">
        <button  type="submit">登出</button>
    </form>
    上傳大頭貼(URL)
    <form method="post" action="icon1.php">
        <input name="url" size="50" placeholder="Source URL"  required>
        <input name="submit" type="submit" value="Download">
    </form>
    上傳大頭貼(本地)
    <form method="post" enctype="multipart/form-data" action="icon2.php">
        <input type="file" name="my_file">
        <input type="submit" value="Upload">
    </form>
    留言
    <form method="POST" enctype="multipart/form-data" action="post.php">
        <textarea  id="context" type="text" name="context"></textarea>
        <input id="file" type="file" name="file">
        <button  type="submit">留言</button>
    </form>
    <?php 
        require_once('config.php');
        $sql3 = "select * from post";
        $result3 = mysqli_query($link, $sql3);
        while ($row = mysqli_fetch_assoc($result3)) {
            $tmp = $row['username'];
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
                echo '<a href="./'. $row['filename'] .'">'. $row['filename'] .'<br></a>';
            }
            if ($username == $row['username']) { 
                echo ' <a href="delete.php?id=' . $row['id'] . '">刪除</a>';
            }
            echo ' <a href="view.php?id=' . $row['id'] . '">單獨顯示</a><br>';
            echo "<hr>";
        }
        echo "<br>";
        echo '<div class="bottom left position-abs content">';
        echo "總共有" . mysqli_num_rows($result3) . "則留言";
    ?>

</div>

<div id = "admin"  style="visibility:hidden;display:none">
    <form method="POST"  action="toadmin.php">
        <button  type="submit">管理介面</button>
    </form>
</div>

</html>