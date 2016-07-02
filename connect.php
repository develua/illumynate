<?php
$host='localhost';
$user='phpmyadmin';
$pass='illumyn8';
$db='socialapp';

$conn=mysql_connect($host,$user,$pass) or die("Cridential error");
mysql_select_db($db,$conn) or die("Database Not Selected");
?>