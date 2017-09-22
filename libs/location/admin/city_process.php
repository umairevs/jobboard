<?php 
   defined('_JEVS') or die('Restricted access');
	foreach($_POST  as $key => $value)
	{
	   $$key = $value;
	}
	foreach($_GET as $key => $value)
	{
	   $$key = $value;
	}
if(isset($chstatus))
	{	
		$queryupdatestatus="update tbl_city SET 
							status='".addslashes($chstatus)."'
							where CityId='".addslashes($CityId)."'";
		if($db->query($queryupdatestatus))
		{
				 $_SESSION['msg'] = "Request Processed Successfully.";
			 header("Location:home.php?mod=$mod&p=citylist");
			 exit;
		} 
	}
//*************************************************************	

	if($action=="deletepage")
	{	
		$querydelete="delete from tbl_city where CityId=$cId";
		if($db->query($querydelete))
			{
				 $_SESSION['msg'] = "Request Processed Successfully.";
				 header("Location:home.php?mod=$mod&p=citylist");
				 exit;
			}
	}
	
?>