<?php
error_reporting(1);
include("../common/top.php");
include("../common/functions.php");

if(isset($_REQUEST)) 
{

	$errorstr="";
	$case = 1;
	
	if(!isset($_SESSION['jobseeker']))
	{
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."logout";	
		exit;
	}
	
	
	$pass =  $_REQUEST['pass'];
	if($pass!='yes') 
	{
		$errorstr = "Sorry you are not able to remove an account";
		$case = 0;
	}
	
	if($case==1)
	{
		 $query_success = delete_job_seeker();	 
		 
		 if($query_success)
		 {
		 	unset($_SESSION['jobseeker']);
			echo "done-SEPARATOR-".SERVER_ROOTPATH."logout-SEPARATOR-Your account deleted successfully.";	
			exit;
		 }
		 else
		 {
		 	echo "done-SEPARATOR-".SERVER_ROOTPATH."-SEPARATOR-Your account not removed.";	
			exit;
		 }
	}
	
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}

}
?>

