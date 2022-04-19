<?php
SESSION_start();
require_once('config.php');
# 檢查檔案是否上傳成功
if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
    echo '檔案名稱: ' . $_FILES['my_file']['name'] . '<br/>';
    echo '檔案類型: ' . $_FILES['my_file']['type'] . '<br/>';
    echo '檔案大小: ' . ($_FILES['my_file']['size'] / 1024) . ' KB<br/>';
    echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'] . '<br/>';
    
    $allow = array("jpg","png");
    $extension = pathinfo($_FILES['my_file']['name'], PATHINFO_EXTENSION);
    $temp = array_search($extension,$allow);
    if (!($temp !== false))
    {
        #echo $temp;
        echo '你的檔案類型為'.$extension;
        echo '只能上傳 jpg or png';
        echo "  <script>
                setTimeout(function(){window.location.href='index.php';},500);
                </script>";
        return; 
    }
    $file = $_FILES['my_file']['tmp_name'];
     # 重新命名
    $dest = md5(uniqid(microtime(true), true)).'.'.$extension;
     # 將檔案移至指定位置
    move_uploaded_file($file, $dest);

    $username = $_SESSION["users"];

    $sql2 = "SELECT * FROM `users` WHERE `username` = '$username';";
    $result=mysqli_query($link,$sql2);
    $row = mysqli_fetch_array($result);   
    # 刪除舊檔案
    # echo $row['iconname'];
    if (file_exists($row['iconname']))
        unlink($row['iconname']);
    $sql = "UPDATE users SET iconname = '$dest' WHERE username = '$username';";
    if($result=mysqli_query($link,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    mysqli_close($link);
} 
else {
    echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
}

?>

<form method="POST" action="return.php">
    <button  type="submit">返回</button>
</form>