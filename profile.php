<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">My Account</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-group">
												<label class="col-sm-2 control-label">First Name</label>
												<div class="col-sm-10">
													<input name="first_name" type="text" class="form-control" value="<?php echo $fetch_user['first_name']; ?>">
												</div>
                     						</div>
											<div class="hr-dashed"></div>
											<div class="form-group ">
												<label class="col-sm-2 control-label">Last Name</label>
												<div class="col-sm-10">
													<input name="last_name" type="text" class="form-control" value="<?php echo $fetch_user['last_name']; ?>">
												</div>
											</div>
											<div class="hr-dashed"></div>
                                            <div class="form-group">
												<label class="col-sm-2 control-label">Gender</label>
												<div class="col-sm-10 ">
    												<select name="gender" class="form-control">
                                                        <option <?php if($fetch_user['gender']==0){ echo 'selected'; }?> value="0">Male</option>
                                                        <option <?php if($fetch_user['gender']==1){ echo 'selected'; }?> value="1">Female</option>
                                                        <option <?php if($fetch_user['gender']==2){ echo 'selected'; }?> value="2">Other</option>
                                                    </select>
                                                </div>
											</div>
											<div class="hr-dashed"></div>
                                            <div class="form-group ">
												<label class="col-sm-2 control-label">Phone No</label>
												<div class="col-sm-10">
													<input type="text" name="phone" class="form-control" value="<?php echo $fetch_user['phone']; ?>">
												</div>
											</div>
                                           	<div class="hr-dashed"></div>
                                            <div class="form-group ">
												<label class="col-sm-2 control-label">Email</label>
												<div class="col-sm-10">
													<input type="email" name="email" class="form-control" value="<?php echo $fetch_user['email']; ?>" readonly="true">
												</div>
											</div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group ">
												<label class="col-sm-2 control-label">Profile Pic</label>
												<div class="col-sm-10">
											     <input id="" type="file" name="profile_pic" accept="image/*">
											     </div>
                                                 </div>
                                                 <div id="errorBlock43" class="help-block"></div>
											
                                            <div class="hr-dashed"></div>
											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2">
													<a href="" class="btn btn-default" type="button">Cancel</a>
													<button class="btn btn-primary" type="submit" name="update_profile">Save changes</button>
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

</body>

</html>