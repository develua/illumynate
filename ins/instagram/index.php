<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<style>
.box-content {
	display: inline-block;
	width: 200px;
    padding: 10px;
}

.bottom {
	border-bottom: 1px solid #ccc;
}

.right {
	border-right: 1px solid #ccc;
}
</style>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

					 <h2>Login with Instragram</h2>
                               	
						<div class="row right">
							<div class="col-md-12">
		                  <hr style="size: 10px;"/>
                                <?php
                                  require 'instagram.class.php';
                                  require 'instagram.config.php';
                                  
                                  // Display the login button
                                  $loginUrl = $instagram->getLoginUrl();
                                  echo "<a class='btn btn-info' href=\"$loginUrl\">Sign in with Instagram</a>";
                                ?>

                     </div>
	               </div>						
				</div>	
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap-select.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/jquery.dataTables.min.js"></script>
	<script src="../../js/dataTables.bootstrap.min.js"></script>
	<script src="../../js/Chart.min.js"></script>
	<script src="../../js/fileinput.js"></script>
	<script src="../../js/chartData.js"></script>
	<script src="../../js/main.js"></script>

</body>

</html>

