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
		$queryupdatestatus="update tbl_state SET 
							status='".addslashes($chstatus)."'
							where RegionID='".addslashes($RegionID)."'";
		if($db->query($queryupdatestatus))
		{
				 $_SESSION['msg'] = "Request Processed Successfully.";
			 header("Location:home.php?mod=$mod&p=statelist");
			 exit;
		} 
	}
//*************************************************************	

	if($action=="deletepage")
	{	
		$querydelete="delete from tbl_state where RegionID=$cId";
		if($db->query($querydelete))
			{
				 $_SESSION['msg'] = "Request Processed Successfully.";
				 header("Location:home.php?mod=$mod&p=statelist");
				 exit;
			}
	}
	
?>