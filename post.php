<?php session_start();
    if( !isset($_POST['context']) ||  $_POST['context']=="" ){
    header("Location: index.php");
    }
    require_once('config.php');
	$context = $_POST['context'];
    $username = $_SESSION['users'];
    if( isset($_POST['context']) ||  $_POST['context'] != "" ){
        $filename = $_FILES['file']['name'];
        $filetype = $_FILES['file']['type'];
        $filesize = $_FILES['file']['size'];
        $filetmp  = $_FILES['file']['tmp_name'];
        $dest = $_FILES['file']['name'];
        if(file_exists($dest)) 
        {
            echo '檔案已存在<br>';
            echo "  <script>
                setTimeout(function(){window.location.href='index.php';},500);
                </script>";
            return;
        }
        move_uploaded_file($filetmp, $dest);
        $sql4 = "INSERT post(username, content, `filename`) VALUES ('$username', '$context', '$filename')";
     }
    else{
         $sql4 = "INSERT post(username, content) VALUES ('$username', '$context')";
    }
    $r = mysqli_query($link, $sql4);
	if (!$r) {
		die('Error: ' . mysqli_error($link));
	} else {
        echo '留言成功';
        echo $filename;
		echo "  <script>
                setTimeout(function(){window.location.href='index.php';},1000);
                </script>";

	}
?>

