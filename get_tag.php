<?php
$response="";
	if(isset($_REQUEST['social_id']))
	{
		include('connect.php');
		$social_id=base64_decode($_REQUEST['social_id']);
		$sql=mysql_query('select * from tbl_own_tag where tbl_social_id="'.$social_id.'"');
		$fetch_row=mysql_fetch_array($sql);
		if($fetch_row['id']!=null && $fetch_row['id']!="")
		{
				$response=$fetch_row['tag_name'];
		}
		else
		{
				$response="";
		}
		echo json_encode($response);
		die;
	}
	else
	{
		$response='You are not autorized to use this Api. For use this please contact on info@example.com';
		echo json_encode($response);
		die;
	}
?>