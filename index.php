<?php
session_start();
$_SESSION['error']="";
$_SESSION['success']="";
$useremail=$_SESSION['email'];
require_once('connect.php');
            
    if($useremail!=null || $useremail!="")
        {
            header('location:profile.php');
        }
    /* Login Php Code Start */
    if(isset($_REQUEST['login']))
    {
        $email=$_POST['email'];
        $password=$_POST['password'];
        
        $select_user_data=mysql_query('select * from users where email="'.$email.'" and password="'.md5($password).'"');    
        $fetch_user_data=mysql_fetch_array($select_user_data);
        if($fetch_user_data['email']!="" && $fetch_user_data['email']!=null)
        {
            if($fetch_user_data['status']==1)
            {
            $_SESSION['email']=$fetch_user_data['email'];    
            header('location:profile.php');
            }
            elseif($fetch_user_data['status']==0)
            {
             $_SESSION['error']='Please Active Your Account!!';         
            }
            
        }
        else
        {
           $_SESSION['error']='Email Or Password Does not Match!!';     
        }
    }
    if(isset($_REQUEST['ac']))
    {
        if($_REQUEST['ac']!=null && $_REQUEST['ac']!="" && $_REQUEST['t']!=null && $_REQUEST['t']!="")
        {
            $email=base64_decode($_REQUEST['t']);
            $active_code=base64_decode($_REQUEST['ac']);
            $get_row=mysql_query('select * from users where email="'.$email.'"');
            $fetch_row=mysql_fetch_array($get_row);
            if($fetch_row['active_code']==$active_code && $fetch_row['status']==0)
            {
                mysql_query('update users set status=1 where email="'.$email.'"');
                $_SESSION['success']='Your email has successfully active';
            }
            elseif($fetch_row['status']==1)
            {
                $_SESSION['error']='Email Already Active!';
            }
        }
    }
    
    /* Login Php Code End */
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="Social Appp Login">
	<meta name="author" content="Social Appp Login">

	<title>SocialApp Login</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	
	<div class="login-page bk-img" style="background-image: url(img/login-bg.jpg);">
		<div class="form-content">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h1 class="text-center text-bold text-light mt-4x">Sign in...</h1>
						<div class="well row pt-2x pb-3x bk-light">
							<div class="col-md-8 col-md-offset-2">
								<form action="" class="mt" id="login" method="post">

									<label for="email" class="text-uppercase text-sm">Your Email</label>
									<input type="email" name="email" id="email" placeholder="Username" class="email form-control mb">

									<label for="" class="text-uppercase text-sm">Password</label>
									<input type="password" name="password" id="password" placeholder="Password" class="password form-control mb">

									<div class="checkbox checkbox-circle checkbox-info">
										<input id="checkbox7" type="checkbox" checked>
										<label for="checkbox7">
											Keep me signed in
										</label>
									</div>
                                    <div class="error_msg" style="color: red;     font-style: italic; font-size: 15px;"><?php if($_SESSION['error']!="" && $_SESSION['error']!=null){ echo $_SESSION['error']; } ?></div>    
                                    <div class="success" style="color: green;     font-style: italic; font-size: 15px;"><?php if($_SESSION['success']!="" && $_SESSION['success']!=null){ echo $_SESSION['success']; } ?></div>
                                    <button class="btn btn-primary btn-block" name="login" id="login" type="submit">LOGIN</button>

								</form>
							</div>
						</div>
						<div class="text-center text-light">
							<a href="forgot.php" class="text-light">Forgot password?</a>
						</div>
                        <div class="text-center text-light">
							<a href="register.php" class="text-light">Create a new account</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>

</html>
