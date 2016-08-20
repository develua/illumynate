<?php
include('header.php');
include('sidebar.php');
if($fetch_user['facebook']!=1)
{
    header('location:login.php');
}
?>
<script type="text/javascript" src="js/lib/jquery-1.10.1.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="js/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
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
            
            <div class="container-fluid">
            
			<div class="row">
               <?php
                    $select_exist_url_group=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'"  and social_type="facebook" group by sub_type');
                    while($fetch_exist_images_group=mysql_fetch_array($select_exist_url_group))
                    {
                    echo '<div class="col-lg-12 col-md-12 col-xs-12 col-xs-12"><h3 class="page-header" style="margin-top: 10px; padding:10px;background: aliceblue; ">'.$fetch_exist_images_group['sub_type'].'</h3></div>';
               ?>
              <!-- <h3 class="page-header" style="margin-top: 10px; padding:20px">Post Images</h3>-->
               <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">   
                    <?php
                   
                    $select_exist_url=mysql_query('select * from tbl_socail_url where user_id="'.$_SESSION['email'].'"  and social_type="facebook" and sub_type="'.$fetch_exist_images_group['sub_type'].'"');
                    while($fetch_exist_images=mysql_fetch_array($select_exist_url))
                    {
                    ?>
                    
                    <div class="col-lg-3 col-md-4 col-xs-12 col-sm-12 thumb" > 
                        <a class="fancybox-buttons thumbnail" data-fancybox-group="button" href="<?php echo $fetch_exist_images['link']; ?>">
                            <img class="img-responsive imagesss" src="<?php echo $fetch_exist_images['link']; ?>" alt="" style="max-height: 300px; min-height: 300px;">
                        </a>
                    </div>
                   <?php
                    }
                    
                   ?>
             </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                <hr />
            </div> 
            <?php
                    }
            ?> 
        </div>
		</div>
	</div>
    
    <!-- Pocket Code Start -->
    <div class="content-wrapper" style="margin-top: 15px;">
		    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                   <h2 class="page-header" style="padding: 10px;background: antiquewhite;">Pocket Gallery</h2>
            <hr />
            </div>
            
            <div class="container-fluid">
            
			<div class="row">
                 <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">   
                    <?php
                    $select_exist_url=mysql_query('select tbl_socail_url.id,tbl_socail_url.link,tbl_pocket_data.resolved_tag,tbl_pocket_data.resolved_url from tbl_socail_url left join tbl_pocket_data on tbl_pocket_data.tbl_social_id=tbl_socail_url.id where tbl_socail_url.user_id="'.$_SESSION['email'].'"  and tbl_socail_url.social_type="pocket" and tbl_socail_url.sub_type="data"');
                    while($fetch_exist_images=mysql_fetch_array($select_exist_url))
                    {
                    ?>
                    <div class="col-lg-3 col-md-3 col-xs-12 col-xs-12 thumb" style="max-height: 300px; min-height: 300px;     margin-bottom: 20px;"> 
                        <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12" style="min-height: 50px; max-height: 50px; width: 100%;overflow: hidden;  background: #3e454c;
    color: white;
    padding: 15px;"><?php if($fetch_exist_images['resolved_tag']!=null && $fetch_exist_images['resolved_tag']!=""){echo $fetch_exist_images['resolved_tag'];} else { echo "No Tag"; } ?>
                        </div>
                        <hr />
                        <a class="fancybox-buttons thumbnail" data-fancybox-group="button" href="<?php echo $fetch_exist_images['resolved_url']; ?>">
                            <img class="img-responsive imagesss" src="<?php echo $fetch_exist_images['link']; ?>" alt="" width="100%" style="min-height: 250px; max-height: 250px;">
                        </a>
                    </div>
                   <div class="clear-fix"></div>
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
    <!--  Pocket Code End  -->

    <!--  Instagram Code Start -->
    
    <div class="content-wrapper" style="margin-top: 15px;">
		    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12">
                   <h2 class="page-header" style="padding: 10px;background: antiquewhite;">Instagram Gallery</h2>
                <hr />
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

