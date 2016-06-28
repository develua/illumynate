<?php
include('header.php');
include('sidebar.php');

if($fetch_user['instagram']!=1)
{
    
 echo '<script>window.location="index.php";</script>';
}

require 'instagram.class.php';
require 'instagram.config.php';

// Receive OAuth code parameter
$code = $_GET['code'];



// Check whether the user has granted access
if (true === isset($code)) {

  // Receive OAuth token object
  $data = $instagram->getOAuthToken($code);
  // Take a look at the API response
   
if(empty($data->user->username))
{
//header('Location: index.php');

}
else
{
	session_start();
	$_SESSION['userdetails']=$data;
	$user=$data->user->username;
	$fullname=$data->user->full_name;
	$bio=$data->user->bio;
	$website=$data->user->website;
	$id=$data->user->id;
	$token=$data->access_token;
 //s print_r($data);
 
 $instagram->setAccessToken($data);
 
  mysql_query('update users set instagram=1 where email="'.$_SESSION['email'].'"');
function fetchData($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $result = curl_exec($ch);
  curl_close($ch); 
  return $result;
  }
  $result = fetchData("https://api.instagram.com/v1/users/$id/media/recent/?access_token=$token");
  $result = json_decode($result);
  //print_r($result);
  foreach ($result->data as $post) {
  
  $fetch_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'" and link="'.$post->images->standard_resolution->url.'" and social_type="instagram" and sub_type="post_images"');
  $numrows=mysql_num_rows($fetch_exist_url);
  if($numrows>0)
  {
    
  }
  else
  {
  //echo "<img src=\"{$post->images->thumbnail->url}\"><br/><br/>";
  mysql_query('insert into tbl_socail_url(user_id,social_type,sub_type,link) value("'.$_SESSION['email'].'","instagram","post_images","'.$post->images->standard_resolution->url.'")');
  }
  
  $fetch_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'" and link="'.$post->user->profile_picture.'" and social_type="instagram" and sub_type="profile_pic"');
  $numrows=mysql_num_rows($fetch_exist_url);
  if($numrows>0)
  {
    
  }
  else
  {
  //echo "<img src=\"{$post->images->thumbnail->url}\"><br/><br/>";
  mysql_query('insert into tbl_socail_url(user_id,social_type,sub_type,link) value("'.$_SESSION['email'].'","instagram","profile_pic","'.$post->user->profile_picture.'")');
  }
  
  
  }
// Display results


/*
$id=mysql_query("select instagram_id from instagram_users where instagram_id='$id'");

if(mysql_num_rows($id) == 0)
{	
mysql_query("insert into instagram_users(username,Name,Bio,Website,instagram_id,instagram_access_token) values('$user','$fullname','$bio','$website','$id','$token')");
}
*/

//header('Location: home.php');
}
} 
else 
{
// Check whether an error occurred
if (true === isset($_GET['error'])) 
{
    echo 'An error occurred: '.$_GET['error_description'];
}

}

?>
<script type="text/javascript" src="../../js/lib/jquery-1.10.1.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="../../js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="../../js/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../../js/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../../js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="../../js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../../js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="../../js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="../../js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <script type="text/javascript">
    			$('.fancybox').fancybox();

    $('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});

    </script>
    
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}

		 
	</style>
		<div class="content-wrapper" style="margin-top: 15px;">
		    <div class="col-lg-12">
                   <h2 class="page-header">Instagram Photos Gallery</h2>
         
                    <strong><a href="index.php">Please Login Again For New Images</a></strong>
                <hr />
            </div>
            
            <div class="container-fluid">
            
			<div class="row">
                <h3 class="page-header" style="margin-top: 10px; padding:20px">Profile Picture</h3>
                 <div class="col-lg-12">   
                    <?php
                    $select_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'"  and social_type="instagram" and sub_type="profile_pic"');
                    while($fetch_exist_images=mysql_fetch_array($select_exist_url))
                    {
                    ?>
                    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb"> 
                        <a class="fancybox-buttons thumbnail" data-fancybox-group="button" href="<?php echo $fetch_exist_images['link']; ?>">
                            <img class="img-responsive imagesss" src="<?php echo $fetch_exist_images['link']; ?>" alt="">
                        </a>
                    </div>
                   <?php
                   }
                   ?>
                </div>
                <div class="col-lg-12">
                    <hr />
                </div> 
               <h3 class="page-header" style="margin-top: 10px; padding:20px">Post Images</h3>
               <div class="col-lg-12">   
                    <?php
                    $select_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'"  and social_type="instagram" and sub_type="post_images"');
                    while($fetch_exist_images=mysql_fetch_array($select_exist_url))
                    {
                    ?>
                    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb"> 
                        <a class="fancybox-buttons thumbnail" data-fancybox-group="button" href="<?php echo $fetch_exist_images['link']; ?>">
                            <img class="img-responsive imagesss" src="<?php echo $fetch_exist_images['link']; ?>" alt="">
                        </a>
                    </div>
                   <?php
                   }
                   ?>
             </div>
            <div class="col-lg-12">
                <hr />
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

