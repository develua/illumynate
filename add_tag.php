<?php
$response=array();
if(isset($_POST['tag']))
{
	include('connect.php');
	$tag=$_POST['tag'];
	$social_id=base64_decode($_POST['social_id']);
	$sql=mysql_query('select id from tbl_own_tag where tbl_social_id="'.$social_id.'"');
	$count=mysql_num_rows($sql);
	
	if($count>0)
	{
		$fetch_row=mysql_fetch_array($sql);
		$update=mysql_query('update tbl_own_tag set tag_name="'.$tag.'" where id="'.$fetch_row['id'].'"');
		if($update)
		{
			$response['msg']='Tag Successfully Update';
			$response['type']='success';
		}
		else
		{
			$response['msg']='Sorry Some Problem Occur!';
			$response['type']='error';
		}
	}
	else
	{
		 
		mysql_query('insert into tbl_own_tag(tbl_social_id,tag_name) values("'.$social_id.'","'.$tag.'")');
		$is_success=mysql_insert_id();
		if($is_success)
		{
			$response['msg']='Tag Successfully Save';
			$response['type']='success';
		}
		else
		{
			$response['msg']='Sorry Some Problem Occur11!';
			$response['type']='error';
		}
	}
	echo json_encode($response);
	die;
}
else
{
	$response['msg']='You are not autorized to use this Api. For use this please contact on info@example.com';
	$response['type']='error';
	echo json_encode($response);
	die;
}
?>