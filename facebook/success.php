<?php
ob_start();
session_start();
include('header.php');
include('sidebar.php');
include_once('src/facebook.php');
$params = array(
    'appId' => '458086794383584',
    'secret' => '760a513033ddbf86528b7c190d18da46',
);
$facebook = new Facebook($params);
if($fetch_user['facebook']!=1)
{
    header('location:login.php');
}
$user = $facebook->getUser();




// Check whether the user has granted access
if ($user) {
  mysql_query('update users set facebook=1 where email="'.$_SESSION['email'].'"');
   $data = $facebook->api(
            '/me/albums',
            'GET',
            array(
                'fields' => 'id,name,privacy,photos.fields(id,name,images,backdated_time,caption,tags,place)',
                'limit' => '300'
            )
        );
        
    $data1 = $facebook->api(
            '/me/photos',
            'GET',
            array(
                'type'=>'tagged',
                'fields' => 'id,name,images,privacy,backdated_time,place,backdated_time_granularity,tags,album.fields(id,name,privacy)',
                'limit' => '999'
            )
        );
      
      
        /*
        foreach ($data['data'] as $album) {
            echo '<div>';
                echo '<h3>' . $album['name'] . ' ' . $album['privacy'] . '</h3>';
                echo '<textarea style="width: 800px; height: 500px;">';
                    foreach ($album['photos']['data'] as $photo) {
                                echo $photo['images'][0]['source'].'';
                    }
                echo '</textarea>';

                echo '<textarea style="width: 800px; height: 500px;">';
                    foreach ($album['photos']['data'] as $photo) {
                               echo $photo['images'][7]['source'].'';
                    }
                echo '</textarea>';
            echo '</div>';
            //break;
        } */
        /*
        print_r($data1);
        foreach ($data1['data'] as $photo) {
           echo $photo['images'][0]['source'].'<br/>';
            echo '<div>';
               
                echo '<textarea style="width: 800px; height: 500px;">';
                   
                                $photo['images'][0]['source'].'';
                     
                echo '</textarea>';

                 
                
            echo '</div>';
         }
        
        die; */
   
  
  //Code For Album Photo Start
 
  foreach ($data['data'] as $album) {
  
      foreach ($album['photos']['data'] as $photo) {
                        
          $fetch_exist_url=mysql_query('select * from tbl_social_url where user_id="'.$_SESSION['email'].'" and link="'.$photo['images'][0]['source'].'" and social_type="facebook" and sub_type="'.$album['name'].'"');
          $numrows=mysql_num_rows($fetch_exist_url);
          if($numrows>0)
          {
            
          }
          else
          {
			  
		  $address="";
		  $city="";
		  $state="";
		  $country="";
		  $lat="";
		  $lng="";
		  if(isset($photo['place']))
		  {
			  if(isset($photo['place']['location']['address']))
			  {
				$address=$photo['place']['location']['address'];
			  }
			  if(isset($photo['place']['location']['city']))
			  {
				$city=$photo['place']['location']['city'];
			  }	
			  if(isset($photo['place']['location']['state']))
			  {
				$state=$photo['place']['location']['state'];
			  }
			  if(isset($photo['place']['location']['country']))
			  {
				$country=$photo['place']['location']['country'];
			  }
			  $lat=$photo['place']['location']['latitude'];
			  $lng=$photo['place']['location']['longitude'];	
		  }  
          mysql_query('insert into tbl_social_url(user_id,social_type,sub_type,link,caption) value("'.$_SESSION['email'].'","facebook","'.$album['name'].'","'.$photo['images'][0]['source'].'","'.$photo['name'].'")');
          
		  $lastInsertId=mysql_insert_id();
			if(isset($photo['place']))
			{
				$queryLocation='insert into tbl_tagged_location(tbl_social_id,address,city,state,country,lat,lng) values("'.$lastInsertId.'","'.$address.'","'.$city.'","'.$state.'","'.$country.'","'.$lat.'","'.$lng.'")';
				mysql_query($queryLocation);
			}
			if(isset($photo['tags']))
			{
				foreach($photo['tags']['data'] as $tagData)
				{
					$queryTags='insert into tbl_tagged(tbl_social_id,tagedName) values("'.$lastInsertId.'","'.$tagData['name'].'")';
					mysql_query($queryTags);	
				}
				
			}
		  
		  }
      
       
      
      }
  }
  //Code For Album Photo End
  
  //Code For Taged Photo Start
  
  foreach ($data1['data'] as $photo) {
          $fetch_exist_url=mysql_query('select * from tbl_social_url where user_id="'.$_SESSION['email'].'" and link="'.$photo['images'][0]['source'].'" and social_type="facebook" and sub_type="Taged Images"');
          $numrows=mysql_num_rows($fetch_exist_url);
          if($numrows>0)
          {
            
          }
          else
          {
			  $address="";
			  $city="";
		      $state="";
			  $country="";
			  $lat="";
			  $lng="";
			  if(isset($photo['place']))
			  {
				  
				  if(isset($photo['place']['location']['address']))
				  {
					$address=$photo['place']['location']['address'];
				  }
				  if(isset($photo['place']['location']['city']))
				  {
					$city=$photo['place']['location']['city'];
				  }	
			      if(isset($photo['place']['location']['state']))
				  {
					$state=$photo['place']['location']['state'];
				  }
				  if(isset($photo['place']['location']['country']))
				  {
					$country=$photo['place']['location']['country'];
				  }
				  $lat=$photo['place']['location']['latitude'];
				  $lng=$photo['place']['location']['longitude'];	
			  }
			mysql_query('insert into tbl_social_url(user_id,social_type,sub_type,link,caption) value("'.$_SESSION['email'].'","facebook","Taged Images","'.$photo['images'][0]['source'].'","'.$photo['name'].'")');
			$lastInsertId=mysql_insert_id();
			if(isset($photo['place']))
			{
				$queryLocation='insert into tbl_tagged_location(tbl_social_id,address,city,state,country,lat,lng) values("'.$lastInsertId.'","'.$address.'","'.$city.'","'.$state.'","'.$country.'","'.$lat.'","'.$lng.'")';
				mysql_query($queryLocation);
			}
			if(isset($photo['tags']))
			{
				foreach($photo['tags']['data'] as $tagData)
				{
					$queryTags='insert into tbl_tagged(tbl_social_id,tagedName) values("'.$lastInsertId.'","'.$tagData['name'].'")';
					mysql_query($queryTags);	
				}
				
			}
			
		  }
  }
  //Code For Taged Photo End
}
?>
<!-- Css Code Start -->
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="../css/SimpleSlider.css" rel="stylesheet" type="text/css">

<style type="text/css">
body,td,th {
font-family: Verdana, "Lucida Grande";
}
.product-image img
{
    height:100%!important;
}
</style>


<!-- Css Code End -->

<!-- Jquery Code Start -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


<!-- Jquery Code End -->

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="../js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="../js/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../js/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="../js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="../js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="../js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
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
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <h2 class="page-header" style="background: antiquewhite;padding: 10px;">Facebook Gallery</h2>
            <hr />    
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                        <a href="login.php" style="padding: 10px;">Please Login Again For New Images</a>
            </div>
            
            <div class="container-fluid" id="">
            
			<div class="row" id="">
               <?php
                    $select_exist_url_group=mysql_query('select * from tbl_social_url where user_id="'.$_SESSION['email'].'"  and social_type="facebook" group by sub_type');
                    while($fetch_exist_images_group=mysql_fetch_array($select_exist_url_group))
                    {
                    echo '<div class="col-lg-12 col-md-12 col-xs-12 col-xs-12"><h3 class="page-header" style="margin-top: 10px; padding:10px;background: aliceblue; ">'.$fetch_exist_images_group['sub_type'].'</h3></div>';
               ?>
              <!-- <h3 class="page-header" style="margin-top: 10px; padding:20px">Post Images</h3>-->
               <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12 ">   
                    <?php
                   
                    $select_exist_url=mysql_query('select * from tbl_social_url where user_id="'.$_SESSION['email'].'"  and social_type="facebook" and sub_type="'.$fetch_exist_images_group['sub_type'].'"');
                    while($fetch_exist_images=mysql_fetch_array($select_exist_url))
                    {
                    ?>
                    
                    <div class="col-lg-3 col-md-4 col-xs-12 col-sm-12 thumb gallery-img" > 
						<div style="position: absolute;padding: 10px; display:none;" class="add_edit_tag">
							<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
							<button class="btn btn-xs btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
						</div>
                        <a class="thumbnail">
                            <img class="img-responsive imagesss" src="<?php echo $fetch_exist_images['link']; ?>" alt="" style="max-height: 300px; min-height: 300px;">
                        </a>
                        <div data-desc="Here will content of all the images">
                        </div>
                    </div>
                   <?php
                    }
                    
                   ?>
             </div>
            <div  class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                <hr />
            </div> 
            <?php
                    }
            ?> 
        </div>
		</div>
	</div>
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
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
 
	<!-- Add Tag Mode Code End -->	
	<!-- Loading Scripts -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap-select.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/dataTables.bootstrap.min.js"></script>
	<script src="../js/Chart.min.js"></script>
	<script src="../js/fileinput.js"></script>
	<script src="../js/chartData.js"></script>
	<script src="../js/main.js"></script>
  
<script src="../js/Am2_SimpleSlider.js" type="text/javascript"></script>
<script type="text/javascript">
     $('.gallery-img').Am2_SimpleSlider();
</script> 
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
$(document).ready(function(){
	$('.gallery-img').mouseenter(function(){
		$(this).children('.add_edit_tag').show();
	});
	$('.gallery-img').mouseleave(function(){
		$(this).children('.add_edit_tag').hide();
	});
	$('.add_edit_tag').on('click',function(){
		$('.product-gallery-popup').hide();
	});
});
</script>
</body>

</html>

