<?php
require_once('header.php');
require_once('sidebar.php');
$_SESSION['error']="";
$_SESSION['success']="";
if(isset($_REQUEST['changepassword']))
{
    
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $oldpassword=$_POST['oldpassword'];
    
    if($password!=$cpassword)
    {
        $_SESSION['error']="Password Must be Same!!";
    }
    else
    {
        $select_password_exist=mysql_query('select id from users where  email="'.$useremail.'" and password="'.md5($oldpassword).'"');
        $fetch_password_exist=mysql_fetch_array($select_password_exist);
        if($fetch_password_exist['id']!=null && $fetch_password_exist['id']!="")
        {
          $update_password=mysql_query('update users set password="'.md5($cpassword).'" where id="'.$fetch_password_exist['id'].'"');
          if($update_password)
          {
            $_SESSION['success']="Password Successfully Changed";
          }  
        }
        else
        {
          $_SESSION['error']="Old Password Does not Match!!";   
        }
    }
}
?>
<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Change Password</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal" id="changepassword">
											<div class="form-group">
												<label class="col-sm-2 control-label">Old Password</label>
												<div class="col-sm-10">
													<input type="password" name="oldpassword" id="oldpassword" class="form-control" required="true">
												</div>
											</div>
                                            <div class="form-group">
												<label class="col-sm-2 control-label">New Password</label>
												<div class="col-sm-10">
													<input type="password" name="password" id="password" class="form-control" required="true">
												</div>
											</div>
                                            <div class="form-group">
												<label class="col-sm-2 control-label">Confirm New Password</label>
												<div class="col-sm-10">
													<input type="password" name="cpassword" id="cpassword" class="form-control" required="true">
												</div>
											</div>
								            <label class="col-sm-2 control-label"></label>
											<div class="col-sm-10 error_msg" style="color: red;     font-style: italic; font-size: 15px;"><?php if($_SESSION['error']!="" && $_SESSION['error']!=null){ echo $_SESSION['error']; } ?></div>    
        						            <label class="col-sm-2 control-label"></label>
											<div class="col-sm-10 success" style="color: green;     font-style: italic; font-size: 15px;"><?php if($_SESSION['success']!="" && $_SESSION['success']!=null){ echo $_SESSION['success']; } ?></div>    
     
											<div class="hr-dashed"></div>
                                			<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn btn-default" id="reset" type="button">Cancel</button>
													<button class="btn btn-primary" name="changepassword" type="submit">Save changes</button>
												</div>
											</div>

										</form>

									</div>
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
        /* Change Password Js Start  */
        $("#changepassword").submit(function(e){
            
            if($("#password").val()!=$("#cpassword").val())
            {
                e.preventDefault();
                $('.error_msg').text("Password must be same");
                $('#cpassword').focus();
            }
            
        });
        $("#reset").click(function(){
            $('#oldpassword').val('');
            $('#password').val('');
            $('#cpassword').val('');
            
        });
        /* Change Password Js End  */ 
    });
    </script>
</body>

</html>