<?php
session_start();
$useremail=$_SESSION['email'];
if($useremail==null || $useremail=="")
{
    header('location:index.php');
}
require_once('../../connect.php');
$select_user=mysql_query('select * from users where email="'.$useremail.'"');
$fetch_user=mysql_fetch_array($select_user);
$userid=$fetch_user['id'];


if(isset($_REQUEST['update_profile']))
{
    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $gender=$_POST['gender'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $profile=$_FILES['profile_pic']['name'];
    $ext=pathinfo($profile,PATHINFO_EXTENSION);
    if($profile!=null && $profile!=null)
    {
        $pic=$userid.".".$ext;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'],'profile_pic/'.$pic);
        mysql_query('update users set profile_pic="'.$pic.'" where email="'.$useremail.'"');
    }    
    mysql_query('update users set first_name="'.$first_name.'",last_name="'.$last_name.'",gender="'.$gender.'",phone="'.$phone.'" where email="'.$useremail.'"');
}


?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>illuMYnate</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="../../css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="../../css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="../../css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="../../css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="../../css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="../../css/style.css">

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div class="brand clearfix">
		<a href="http://illumynate.com/dashboard.php" style="text-decoration: none!important;" class="logo"><img src="../../img/logos/Illumynate_homepage_header.png" title="illuMYnate"></a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li><a href="help.html">Help</a></li>
			<li class="ts-account">
				<a href="#"><?php if($fetch_user['profile_pic']!=null && $fetch_user['profile_pic']!=""){ echo '<img src="../../profile_pic/'.$fetch_user['profile_pic'].'" class="ts-avatar hidden-side" style="    max-width: 50px;" alt="">'; } else { echo '<img src="../../img/Illum_icon_rounded.png" class="ts-avatar hidden-side" alt="">'; }?><?php echo $fetch_user['first_name']." ".$fetch_user['last_name']; ?><i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="../../profile.php">My Account</a></li>
					<li><a href="../../changepassword.php">Change Password</a></li>
					<li><a href="../../logout.php">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>

	