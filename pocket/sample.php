<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php
include('../connect.php');
ini_set('display_errors', '1');
require('scrap.php');
require('Pocket.php');
$params = array(
	'consumerKey' => '58150-d33d72137fb908e88d4e14c3' // fill in your Pocket App Consumer Key
);


if (empty($params['consumerKey'])) {
	die('Please fill in your Pocket App Consumer Key');
}

$pocket = new Pocket($params);
//echo "<pre>";
if (isset($_GET['authorized'])) {
		$user = $pocket->convertToken($_GET['authorized']);
	/*
		$user['access_token']	the user's access token for calls to Pocket
		$user['username']	the user's pocket username
	*/
//	print_r($user);

	// Set the user's access token to be used for all subsequent calls to the Pocket API
	$pocket->setAccessToken($user['access_token']);

//	echo NEWLINE;

/*	
	$params = array(
		'url' => 'https://github.com/gleek/', // required
		'tags' => 'github'
	);
	print_r($pocket->add($params, $user['access_token']));
*/
//	echo NEWLINE;

	// Retrieve the user's list of unread items (limit 5)
	// http://getpocket.com/developer/docs/v3/retrieve for a list of params
	$params = array( 
            'state'=>'all',
            'detailType'=>'complete',
			'count' => 50
	);
	$items = $pocket->retrieve($params, $user['access_token']);
	//print_r($items);
   // die;
    $update='update users set pocket="1" where email="'.$useremail.'"';
    mysql_query($update);
    foreach($items['list'] as $item)
    {
	 
    $url = $item['resolved_url'];
    $obj = new Scrap;
    $obj::setUrl($url);
    
    
    
    
    //we need to validate the link first
    if($obj::checkUrl()){
        
        if($obj::getImg()!='http://codetrash/assets/images/sains.png' )
        {
           // echo $item['resolved_title'].'<br/>'; 
           // echo "<a href='".$item['resolved_url']."'><img src='".$obj::getImg()."' style='height:200px; width:25%;'/></a><br/>";
            $select_exist=mysql_query('select tbl_social_url.id from tbl_social_url left join tbl_pocket_data on tbl_pocket_data.tbl_social_id=tbl_social_url.id where tbl_pocket_data.resolved_tag="'.$item['resolved_title'].'" and tbl_pocket_data.resolved_url="'.$item['resolved_url'].'" and tbl_social_url.user_id="'.$useremail.'"');
            $fetch_exist=mysql_num_rows($select_exist);
            if($fetch_exist<=0)
            {
                //  $query='insert into tbl_social_url(user_id,social_type,sub_type,link,created_on) values("'.$useremail.'","pocket","data","'.$obj::getImg().'","'.date('Y-m-d h:i:s').'")';
                $query='insert into tbl_social_url(user_id,social_type,sub_type,link,created_on) values("'.$useremail.'","pocket","data","'.$item['excerpt'].'","'.date('Y-m-d h:i:s').'")';
                mysql_query($query);
                $id=mysql_insert_id();
                $pocket_query='insert into tbl_pocket_data(tbl_social_id,user_id,pocket_item_id,resolved_url,resolved_tag,created_at) values("'.$id.'","'.$useremail.'","'.$item['item_id'].'","'.$item['resolved_url'].'","'.$item['resolved_title'].'","'.date('Y-m-d h:i:s').'")';
                mysql_query($pocket_query);
            }
        }
        else if(isset($item['image']))
        {
           // echo $item['resolved_title'].'<br/>'; 
           // echo "<a href='".$item['resolved_url']."'><img src='".$item['image']['src']."' style='height:200px; width:25%;'/></a><br/>";
            
            $select_exist=mysql_query('select tbl_social_url.id from tbl_social_url left join tbl_pocket_data on tbl_pocket_data.tbl_social_id=tbl_social_url.id where tbl_pocket_data.resolved_tag="'.$item['resolved_title'].'" and tbl_pocket_data.resolved_url="'.$item['resolved_url'].'" and tbl_social_url.user_id="'.$useremail.'"');
            $fetch_exist=mysql_num_rows($select_exist);
            if($fetch_exist<=0)
            {
                $query='insert into tbl_social_url(user_id,social_type,sub_type,link,created_on) values("'.$useremail.'","pocket","data","'.$item['excerpt'].'","'.date('Y-m-d h:i:s').'")';
                mysql_query($query);
                $id=mysql_insert_id();
                $pocket_query='insert into tbl_pocket_data(tbl_social_id,user_id,pocket_item_id,resolved_url,resolved_tag,created_at) values("'.$id.'","'.$useremail.'","'.$item['item_id'].'","'.$item['resolved_url'].'","'.$item['resolved_title'].'","'.date('Y-m-d h:i:s').'")';
                mysql_query($pocket_query);
            }
            
            
            
        }
        else
        {
           // echo $item['resolved_title'].'<br/>'; 
           // echo "<a href='".$item['resolved_url']."'><img src='http://codetrash/assets/images/sains.png' style='height:200px; width:25%;'/></a><br/>";
            $select_exist=mysql_query('select tbl_social_url.id from tbl_social_url left join tbl_pocket_data on tbl_pocket_data.tbl_social_id=tbl_social_url.id where tbl_pocket_data.resolved_tag="'.$item['resolved_title'].'" and tbl_pocket_data.resolved_url="'.$item['resolved_url'].'" and tbl_social_url.user_id="'.$useremail.'"');
            $fetch_exist=mysql_num_rows($select_exist);
            if($fetch_exist<=0)
            {
                $query='insert into tbl_social_url(user_id,social_type,sub_type,link,created_on) values("'.$useremail.'","pocket","data","https://www.mirrorservice.org/sites/gutenberg.org/2/6/6/5/26656/26656-page-images/p0052-blank.png","'.date('Y-m-d h:i:s').'")';
                mysql_query($query);
                $id=mysql_insert_id();
                $pocket_query='insert into tbl_pocket_data(tbl_social_id,user_id,pocket_item_id,resolved_url,resolved_tag,created_at) values("'.$id.'","'.$useremail.'","'.$item['item_id'].'","'.$item['resolved_url'].'","'.$item['resolved_title'].'","'.date('Y-m-d h:i:s').'")';
                mysql_query($pocket_query);
            }
        }
    }else{
       // echo "Invalid Domain,";
        if(isset($item['image']))
        {
            //echo $item['resolved_title'].'<br/>'; 
            //echo "<a href='".$item['resolved_url']."'><img src='".$item['image']['src']."' style='height:200px; width:25%;'/></a><br/>";
            $select_exist=mysql_query('select tbl_social_url.id from tbl_social_url left join tbl_pocket_data on tbl_pocket_data.tbl_social_id=tbl_social_url.id where tbl_pocket_data.resolved_tag="'.$item['resolved_title'].'" and tbl_pocket_data.resolved_url="'.$item['resolved_url'].'" and tbl_social_url.user_id="'.$useremail.'"');
            $fetch_exist=mysql_num_rows($select_exist);
            if($fetch_exist<=0)
            {
              $query='insert into tbl_social_url(user_id,social_type,sub_type,link,created_on) values("'.$useremail.'","pocket","data","'.$item['excerpt'].'","'.date('Y-m-d h:i:s').'")';
              mysql_query($query);
              $id=mysql_insert_id();
              $pocket_query='insert into tbl_pocket_data(tbl_social_id,user_id,pocket_item_id,resolved_url,resolved_tag,created_at) values("'.$id.'","'.$useremail.'","'.$item['item_id'].'","'.$item['resolved_url'].'","'.$item['resolved_title'].'","'.date('Y-m-d h:i:s').'")';
              mysql_query($pocket_query);  
            }
        }
        else
        {
            //echo $item['resolved_title'].'<br/>'; 
            //echo "<a href='".$item['resolved_url']."'><img src='http://codetrash/assets/images/sains.png' style='height:200px; width:25%;'/></a><br/>";
            //echo 'insert into tbl_social_url(user_id,social_type,sub_type,link,created_on) values("'.$useremail.'","pocket","data","http://codetrash/assets/images/sains.png","'.date('Y-m-d h:i:s').'")';
            $select_exist=mysql_query('select tbl_social_url.id from tbl_social_url left join tbl_pocket_data on tbl_pocket_data.tbl_social_id=tbl_social_url.id where tbl_pocket_data.resolved_tag="'.$item['resolved_title'].'" and tbl_pocket_data.resolved_url="'.$item['resolved_url'].'" and tbl_social_url.user_id="'.$useremail.'"');
            $fetch_exist=mysql_num_rows($select_exist);
            if($fetch_exist<=0)
            {
              $query='insert into tbl_social_url(user_id,social_type,sub_type,link,created_on) values("'.$useremail.'","pocket","data","https://www.mirrorservice.org/sites/gutenberg.org/2/6/6/5/26656/26656-page-images/p0052-blank.png","'.date('Y-m-d h:i:s').'")';
              mysql_query($query);
              $id=mysql_insert_id();
              $pocket_query='insert into tbl_pocket_data(tbl_social_id,user_id,pocket_item_id,resolved_url,resolved_tag,created_at) values("'.$id.'","'.$useremail.'","'.$item['item_id'].'","'.$item['resolved_url'].'","'.$item['resolved_title'].'","'.date('Y-m-d h:i:s').'")';
              mysql_query($pocket_query);  
            }  
        }
    }
	 
     $sqlTagSelect='select id,pocket_tag from tbl_pocket_data where pocket_item_id="'.$item['item_id'].'"'; 
     $selectTag=mysql_query($sqlTagSelect);
     $numTagRow=mysql_num_rows($selectTag);
     $fetchTagRow=mysql_fetch_array($selectTag);
     $fetchTagArray=explode(',',$fetchTagRow['pocket_tag']);
    
    if($numTagRow>0)
     {
       
        if(isset($item['tags']))
        {
            
            foreach($item['tags'] as $tag)
            {
                $key = array_search($tag['tag'], $fetchTagArray);
                if($key>=0)
                {
                  array_push($fetchTagArray,$tag['tag']);
                }
                
            }
        }
        $implode_this=implode(",",$fetchTagArray);
        mysql_query('update tbl_pocket_data set pocket_tag="'.$implode_this.'" where id="'.$fetchTagRow['id'].'"');
        
     }
      
    }
 header('location:index.php');  
} else {
    if(isset($_POST['login']))
    {
	// Attempt to detect the url of the current page to redirect back to
	// Normally you wouldn't do this
	$redirect = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https' : 'http') . '://'  . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?authorized=';

	// Request a token from Pocket
	$result = $pocket->requestToken($redirect);
	/*
		$result['redirect_uri']		this is the URL to send the user to getpocket.com to authorize your app
		$result['request_token']	this is the request_token which you will need to use to
						obtain the user's access token after they have authorized your app
	Normally you should save the 'request_token' in a session so it can be
	retrieved when the user is redirected back to you
	*/
	$result['redirect_uri'] = str_replace(
		urlencode('?authorized='),
		urlencode('?authorized=' . $result['request_token']),
		$result['redirect_uri']
	);
	// To redirect back to us.
//echo "</pre>";
	header('Location: ' . $result['redirect_uri']);
    }
}

?>

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

					 <h2>Login with Pocket</h2>
                               	
						<div class="row right">
						<div class="col-md-12">
		                  <hr style="size: 10px;"/>
                              <form method="post" action="">
                                <button class='btn btn-info' type="submit" name="login">Sign in with Pocket</button>
                              </form>
                        </div>
	               </div>						
				</div>	
			</div>
		</div>
	</div>

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

</body>

</html>

