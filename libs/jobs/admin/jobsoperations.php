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
		$queryupdatestatus="update tbl_jobs SET 
							job_status='".addslashes($chstatus)."'
							where id='".addslashes($faqid)."'";
		if($db->query($queryupdatestatus))
		{
			 $_SESSION['msg']="Status updated Successfully";
			 header("Location:home.php?mod=$mod&p=joblist");
			 exit;
		} 
	}
//*************************************************************	
	if(isset($deletepage))
	{	
	    $querydelete="delete from tbl_jobs where id=$deletepage";
		if($db->query($querydelete))
			{
				 $_SESSION['msg'] = "Job Deleted Successfully";
				 header("Location:home.php?mod=$mod&p=joblist");
				 exit;
			}
	}  
 
 
?>