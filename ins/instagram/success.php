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
  foreach ($result->data as $post) {
  
  $fetch_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'" and link="'.$post->images->standard_resolution->url.'" and social_type="instagram" and sub_type="post_images"');
  $numrows=mysql_num_rows($fetch_exist_url);
  if($numrows>0)
  {
    
  }
  else
  {
	  $address="";
	  $lat="";
	  $lng="";
	  $text="";
		if(isset($post->location->name))
		  {
			$address=$post->location->name;
			$lat=$post->location->latitude; 
			$lng=$post->location->longitude;  	
		  }
	  
		if(isset($post->caption->text))
		{
			$text=$post->caption->text;
		}
	  //echo "<img src=\"{$post->images->thumbnail->url}\"><br/><br/>";
		mysql_query('insert into tbl_socail_url(user_id,social_type,sub_type,link,caption) value("'.$_SESSION['email'].'","instagram","post_images","'.$post->images->standard_resolution->url.'","'.$text.'")');
		$lastInsertId=mysql_insert_id();
		if(isset($post->location->name))
		{
			$queryLocation='insert into tbl_taged_location(tbl_social_id,address,lat,lng) values("'.$lastInsertId.'","'.$address.'","'.$lat.'","'.$lng.'")';
			mysql_query($queryLocation);
		}
  }
  
  $fetch_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'" and link="'.$post->user->profile_picture.'" and social_type="instagram" and sub_type="profile_pic"');
  $numrows=mysql_num_rows($fetch_exist_url);
  if($numrows>0)
  {
    
  }
  else
  {
		$address="";
		$lat="";
	    $lng="";
		$text="";
		if(isset($post->location->name))
	    {
			$address=$post->location->name;
			$lat=$post->location->latitude; 
			$lng=$post->location->longitude;  	
		}
		if(isset($post->caption->text))
		{
			$text=$post->caption->text;
		}
		mysql_query('insert into tbl_socail_url(user_id,social_type,sub_type,link) value("'.$_SESSION['email'].'","instagram","profile_pic","'.$post->user->profile_picture.'")');
		$lastInsertId=mysql_insert_id();
		if(isset($post->location->name))
		{
			$queryLocation='insert into tbl_taged_location(tbl_social_id,address,lat,lng) values("'.$lastInsertId.'","'.$address.'","'.$lat.'","'.$lng.'")';
			mysql_query($queryLocation);
		}
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
		<!--  Instagram Code Start -->
    
    <div class="content-wrapper" style="margin-top: 15px;">
		    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                   <h2 class="page-header" style="padding: 10px;background: antiquewhite;">Instagram Gallery</h2>
            <hr />
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                         <strong style="padding: 10px;"><a href="index.php">Please Login Again For New Images</a></strong>
            </div>
            <div class="container-fluid">
            
			<div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
            <h3 class="page-header" style="margin-top: 10px;padding: 10px;background: aliceblue;">Profile Picture</h3>
            </div>
                 <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">   
                    <?php
                    $select_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'"  and social_type="instagram" and sub_type="profile_pic"');
                    while($fetch_exist_images=mysql_fetch_array($select_exist_url))
                    {
                    ?>
                    
                    <div class="col-lg-3 col-md-3 col-xs-12 col-xs-12 thumb"> 
                        <div style="position: absolute;padding: 10px; display:none;" class="add_edit_tag">
							<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
							<button class="btn btn-xs btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
						</div>
						<a class="fancybox-buttons thumbnail" data-fancybox-group="button" href="<?php echo $fetch_exist_images['link']; ?>">
                            <img class="img-responsive imagesss" src="<?php echo $fetch_exist_images['link']; ?>" alt="" style="min-height: 300px; max-height: 300px;">
                        </a>
                    </div>
                   <?php
                   }
                   ?>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                    <hr />
                </div> 
                <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                     <h3 class="page-header" style="margin-top: 10px;padding: 10px;background: aliceblue;">Post Images</h3>
                </div>
               <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">   
                    <?php
                    $select_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'"  and social_type="instagram" and sub_type="post_images"');
                    while($fetch_exist_images=mysql_fetch_array($select_exist_url))
                    {
                    ?>
                    
                    <div class="col-lg-3 col-md-3 col-xs-12 col-xs-12 thumb">
						<div style="position: absolute;padding: 10px; display:none;" class="add_edit_tag">
							<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
							<button class="btn btn-xs btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
						</div>					
                        <a class="fancybox-buttons thumbnail" data-fancybox-group="button" href="<?php echo $fetch_exist_images['link']; ?>">
                            <img class="img-responsive imagesss" src="<?php echo $fetch_exist_images['link']; ?>" style="min-height: 300px; max-height: 300px;">
                        </a>
                    </div>
                   <?php
                   }
                   ?>
             </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                <hr />
            </div> 
             
        </div>
		</div>
	</div>    
    <!--  Instagram Code End   -->     
          
<!-- Add Tag Model Code Start -->         
	
	 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
            <input type="text" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput" placeholder="Add tags" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
 
	<!-- Add Tag Mode Code End -->

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
	<script type="text/javascript">
		$(document).ready(function(){
			$('.thumb').mouseenter(function(){
				$(this).children('.add_edit_tag').show();
			});
			$('.thumb').mouseleave(function(){
				$(this).children('.add_edit_tag').hide();
			});
		});
	</script>
	<script>
	var data = ["Amsterdam",
    "London",
    "Paris",
    "Washington",
    "New York",
    "Los Angeles",
    "Sydney",
    "Melbourne",
    "Canberra",
    "Beijing",
    "New Delhi",
    "Kathmandu",
    "Cairo",
    "Cape Town",
    "Kinshasa"];
var citynames = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: $.map(data, function (city) {
        return {
            name: city
        };
    })
});
citynames.initialize();

$('.category-container > > input').tagsinput({
    typeaheadjs: [{
          minLength: 3,
          highlight: true,
    },{
        minlength: 3,
        name: 'citynames',
        displayKey: 'name',
        valueKey: 'name',
        source: citynames.ttAdapter()
    }],
    freeInput: true
});
	</script>
</body>

</html>

