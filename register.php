<?php
session_start();
$_SESSION['error']="";
$_SESSION['success']="";
/*   Php Code Start  */
if(isset($_REQUEST['register']))
{
require_once('connect.php');
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$email=$_POST['email'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];
if($password!=$cpassword)
{
    $_SESSION['error']='Password Must be Same';
}
else
{
$select_user_exist=mysql_query('select id from users where email="'.$email.'"');
$fetch_user_num=mysql_num_rows($select_user_exist);
if($fetch_user_num>0)
{
   $_SESSION['error']='Email Already Exists';
}
else
{
    
    $active_code=uniqid();
    $query=mysql_query('insert into users(first_name,last_name,email,password,active_code) values("'.$first_name.'","'.$last_name.'","'.$email.'","'.md5($password).'","'.$active_code.'")');
    $inserid=mysql_insert_id();
    if($inserid)
    {
            $to  = $email;
            
            // subject
            $subject = 'Activation link for IlluMYnate!';
            
            // message
            $message = '
            <html>
            <body>
            <table>
            <thead style="background-color: #4f5362;">
            <th style="padding: 15px;color: white;">Thanks For Registering with illuMYnate</th>
            </thead>
            <tbody style="background-color: #4b9dbe;">
            <tr>
            <td style="padding: 15px;font-size: 20px;height: 200px;">
            <strong>Hello '.$first_name.',</strong><br />
                        Thanks for registering with illuMYnate, please click <a href="http://illumynate.com/index.php?t='.base64_encode($email).'&ac='.base64_encode($active_code).'">here</a> to active your account.
            </td>
            </tr>
            </tbody>
            <tfoot style="background-color: #4f5362;">
            <tr><td style="padding: 15px;color: white; text-align: center;">@copyright illuMYnate</td></tr>
            </tfoot>
            </table>
            </body>
            </html>

            ';
            
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            // Additional headers
            $headers .= '<info@illuMYnate.com>' . "\r\n";
            
            // Mail it
            mail($to, $subject, $message, $headers);
        $_SESSION['success']="Please Go to your account and confirm your email";
    }
}
}
}
/*   Php Code End  */
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Harmony - Free responsive Bootstrap admin template by Themestruck.com</title>

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

<body style="background-image: url(img/login-bg.jpg); background-repeat: round!important;" class="bk-img">
	
	<div class="login-page" >
		<div class="form-content">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h1 class="text-center text-bold text-light mt-4x">Sign Up</h1>
						<div class="well row pt-2x pb-3x bk-light">
							<div class="col-md-8 col-md-offset-2">
								<form action="" class="mt" id="register" method="post">
                                    <label for="first_name" class="text-uppercase text-sm">First Name</label>
									<input type="text" id="first_name" name="first_name" placeholder="Enter your first name here" class="form-control mb" required="true">

                                    <label for="last_name" class="text-uppercase text-sm">Last Name</label>
									<input type="text" id="last_name" name="last_name" placeholder="Enter your last name here" class="form-control mb" required="true">

									<label for="email" class="text-uppercase text-sm">Email</label>
									<input type="email" id="email" name="email" placeholder="Username" class="form-control mb" required="true">

									<label for="password" class="text-uppercase text-sm">Password</label>
									<input type="password" id="password" class="password form-control mb" name="password" placeholder="Password" required="true">
                                    
                                    <label for="" class="text-uppercase text-sm">Confirm Password</label>
									<input type="password" class="cpassword form-control mb" name="cpassword" placeholder="Password"  required="true">

                                    <div class="error_msg" style="color: red;     font-style: italic; font-size: 15px;"><?php if($_SESSION['error']!="" && $_SESSION['error']!=null){ echo $_SESSION['error']; } ?></div>    
        						    <div class="success" style="color: green;     font-style: italic; font-size: 15px;"><?php if($_SESSION['success']!="" && $_SESSION['success']!=null){ echo $_SESSION['success']; } ?></div>    
        						  
									<button class="btn btn-primary btn-block" name="register" type="submit">Submit</button>
                                </form>
							</div>
						</div>
					    <div class="text-center text-light">
							<a href="index.php" class="text-light">Already have an account</a>
						</div>
                        <div class="text-center text-light">
							<a href="forgot.php" class="text-light">Forgot password?</a>
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
    <script type="text/javascript">
    $(document).ready(function(){
       $("#register").submit(function(e){
        var password=$(".password").val();
        var cpassword=$(".cpassword").val();
        if(password!=cpassword)
        {
            e.preventDefault();
            $('.error_msg').text("Password must be same");
            $('.cpassword').focus();
        }
        });
    });
    </script>
</body>

</html>