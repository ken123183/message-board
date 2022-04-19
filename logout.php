<?php
session_start();
unset($_SESSION['users']);
unset($_SESSION['admin']);
header("Location: https://demo.ken123183.social/index.php");
?>