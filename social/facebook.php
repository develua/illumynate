<?php
	$start_process = (float) array_sum(explode(' ',microtime()));
 
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
 
	require 'Facebook/Facebook.php';
 
	$facebook = new Facebook(array(
	  'appId'  => "1107992032576327",
	  'secret' => "721b42a074773f4ca36b8b78ec33194e",
	));
 
	$user_id = $facebook->getUser();
 
	if($user_id == 0 || $user_id == "")
	{
		$login_url = $facebook->getLoginUrl(array(
		'redirect_uri'         => "http://apps.facebook.com/rapid-apps/",
		'scope'      => "email,publish_stream,user_hometown,user_location,user_photos,friends_photos,
					user_photo_video_tags,friends_photo_video_tags,user_videos,video_upload,friends_videos"));
 
		echo "<script type='text/javascript'>top.location.href = '$login_url';</script>";
		exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
 
<body>
<div id="fb-root">
<p><a target="_top" href="http://apps.facebook.com/rapid-apps/">Back</a></p>
<p><a href="http://4rapiddev.com/facebook-graph-api/php-load-facebook-albums-and-save-to-mysql-database/" target="_blank">Check out the tutorial and source code</a></p>
<?php
	$db_host = "localhost";
    $db_name = "a3782674_paypal";
    $db_username = "a3782674_paypal";
    $db_password = "123456";
 
    $dbh = mysql_connect($db_host, $db_username, $db_password) or die("Unable to connect to MySQL");
    mysql_query('SET NAMES "utf8"');
    mysql_select_db($db_name, $dbh) or die("Could not select $db_name");
 
	echo "<p>Your Facebook Id: " . $user_id . "</p>";
 
	$total_albums = 0;
 
	$fb_userid = "";
	if(isset($_REQUEST["fb_userid"]) && $_REQUEST["fb_userid"] != "")
		$fb_userid = (int)$_REQUEST["fb_userid"];
 
	if($fb_userid != "")
		$uid = $fb_userid;
	else
		$uid = $user_id;
 
	$sql = "select * from fb_albums where uid='{$uid}'";
 
	$q = mysql_query($sql);
	if(!$r = mysql_fetch_array($q)){		
		$fql = "SELECT aid, name, photo_count, cover_object_id FROM album WHERE owner = '{$uid}'";
 
		$ret_obj = $facebook->api(array(
								   'method' => 'fql.query',
								   'query' => $fql,
								 ));
 
		$total_albums = sizeof($ret_obj);
 
		$album_ids = "";
		$query = "insert into fb_albums(uid, album_id, name, total_photos, default_photo)values";
		$values = "";
		for($i=0;$i<$total_albums;$i++)
		{			
			$photo_count = "";
			if(isset($ret_obj[$i]["photo_count"]) || $ret_obj[$i]["photo_count"] != ""){
				$photo_count = $ret_obj[$i]["photo_count"];
			}
 
			$cover_object_id = "";
			$cover_photo = "";
			$default_photo = "";
			if(isset($ret_obj[$i]["cover_object_id"]) && $ret_obj[$i]["cover_object_id"] != "0"){
				$cover_object_id = $ret_obj[$i]["cover_object_id"];
				$cover_photo = $facebook->api("/{$cover_object_id}");
				$default_photo = $cover_photo["picture"];
			}
			$values .= "('{$uid}', '" . $ret_obj[$i]["aid"] . "', '" . mysql_escape_string($ret_obj[$i]["name"]) . "', '" . $photo_count . "', '" . stripslashes($default_photo) . "')," ;
		}
 
		if($values != ""){
			$values = substr($values, 0, strlen($values) -1);
			$values .= ";";
		}
 
		$query .= $values;
		mysql_query($query);
	}
	else
	{
		$total_albums = mysql_num_rows($q);
	}
 
	echo "total_albums: " . $total_albums . "<br>";
 
	$page = 0;
 
	if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "")
		$page = (int)$_REQUEST["page"];
	if($page == 0)$page = 1;
 
	$page_size = 5;
 
	$total_pages = ceil($total_albums/$page_size);
 
	if($page > $total_pages)
		$page = $total_pages;
 
	$start = $total_pages > 0 ? (( $page * $page_size ) - $page_size) : 0;
	$end = $start + $page_size;
	$start = $start <= 1 ? 0 : $start;
	$sql .=" LIMIT $start, $page_size";
 
	$sql = "select * from fb_albums where uid='{$uid}' LIMIT $start, $page_size";
 
	$q = mysql_query($sql);
	$album_table = "";
	$album_table .= "<table border='1'>";
	$album_table .= "<tr><th>Album ID</th><th>Name</th><th>Total Photos</th><th>Default Photo</th></tr>";
	while($r = mysql_fetch_assoc($q))
	{
		$album_table .= "<tr><td>" . $r["album_id"] . "</td><td>" . $r["name"] . "</td><td>" . $r["total_photos"] . "</td><td align='center'><img src='" . $r["default_photo"] . "'></td></tr>";
	}
	$album_table .= "</table>";
 
	echo "<h3>Your Facebook Album List ({$total_albums} albums)</h3>";
	echo $album_table;
 
	//echo create_page_navigation($total_albums, $page, $page_size, "http://apps.facebook.com/rapid-apps/load-albums.php", "fb_userid=" . $uid);
 

?>
<p><a href="http://4rapiddev.com/facebook-graph-api/php-load-facebook-albums-and-save-to-mysql-database/" target="_blank">Check out the tutorial and source code</a></p>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
	FB.Canvas.setSize({ width: 520, height: 1500 });
</script>
</body>
</html>
<?php
	$end_process = (float) array_sum(explode(' ',microtime()));
	echo "<p>Execution time: ". sprintf("%.4f", ($end_process-$start_process))." seconds</p>";
?>