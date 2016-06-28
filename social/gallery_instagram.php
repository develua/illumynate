<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php
require 'ins/instagram/instagram.class.php';
require 'ins/instagram/instagram.config.php';
$code = $_GET['code'];
if (true === isset($code)) {

  $data = $instagram->getOAuthToken($code);
  if(empty($data->user->username))
  {
  }
  else
  {
	$_SESSION['userdetails']=$data;
	$user=$data->user->username;
	$fullname=$data->user->full_name;
	$bio=$data->user->bio;
	$website=$data->user->website;
	$id=$data->user->id;
	$token=$data->access_token;
    $instagram->setAccessToken($data);
 
  
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
    // Do something with this data.
 
  echo "<img src=\"{$post->images->thumbnail->url}\"><br/><br/>";
  mysql_query('insert into tbl_socail_url(user_id,social_type,link) value("'.$_SESSION['email'].'","instagram","'.$post->images->thumbnail->url.'")');
  
  }

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
