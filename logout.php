<?php
session_start();
$useremail=$_SESSION['email'];
session_destroy();
header('location:index.php');
?>