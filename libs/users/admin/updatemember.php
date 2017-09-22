<?php
//Check access of module
include("security_module.php");

	if (isset ( $_REQUEST['a']) )
	{
		
		$UserId = $_REQUEST['u'];

		if ($_REQUEST['a'] == '0' ) 
		{
			$qry = "update tbl_job_seaker set status = '".$_REQUEST['a']."' where id='".$UserId."'";
			mysql_query($qry);
			$_SESSION['msg'] = "Member Status Updated Successfully";
		}
		
		
		if ($_REQUEST['a'] == '1' ) 
		{
			$qry = "update tbl_job_seaker set status = '".$_REQUEST['a']."' where id='".$UserId."'";
			mysql_query($qry);
			$_SESSION['msg'] = "Member Status Updated Successfully";
		}
		
		if ( $del=$_REQUEST['a'] == 'd' ) 
		{
		
		$delqry = "delete from  tbl_job_seaker  where id  ='".$UserId."'";
		$qry = mysql_query($delqry);
		if($qry)
		{
		  
			$_SESSION['msg'] = "Member Deleted from list";
		  }
		}
		
	}
	
	
	header("location:home.php?p=members&mod=".$mod);exit; 
?>