<?php
$host='localhost';
$user='winne682_social';
$pass='S!5b?bclwRxx';
$db='winne682_socialapp';

$conn=mysql_connect($host,$user,$pass) or die("Cridential error");
mysql_select_db($db,$conn) or die("Database Not Selected");
?>