<?php
    SESSION_start();
    if(!$_SESSION["admin"])
    {
        echo "<script>
        setTimeout(function(){window.location.href='index.php';},0);
        </script>";
    }
    echo "管理介面";
?>

<form method="POST" action="title.php">
    <input id="ti" placeholder="message board" required="" autofocus="" type="text" name="ti">
    <br>
    <button  type="submit">更改標題</button>
</form>

<form method="POST" action="return.php">
    <button  type="submit">返回</button>
</form>