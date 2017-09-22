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
		$queryupdatestatus="update tbl_countries SET 
							status='".addslashes($chstatus)."'
							where CountryId='".addslashes($CountryId)."'";
		if($db->query($queryupdatestatus))
		{
				 $_SESSION['msg'] = "Request Processed Successfully.";
			 header("Location:home.php?mod=$mod&p=countrylist");
			 exit;
		} 
	}
//*************************************************************	

	if($action=="deletepage")
	{	
		$querydelete="delete from tbl_countries where CountryId=$cId";
		if($db->query($querydelete))
			{
				 $_SESSION['msg'] = "Request Processed Successfully.";
				 header("Location:home.php?mod=$mod&p=countrylist");
				 exit;
			}
	}
	
?>