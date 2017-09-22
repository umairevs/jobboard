<?php
error_reporting(1);
include("../common/top.php");
include("../common/functions.php");

if(isset($_REQUEST)) 
{
	$errorstr="";
	$case = 1;
	
	if(!isset($_SESSION['employer']))
	{
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."signin";	
		exit;
	} 
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
	
	if($case==1)
	{
		 $id  = $_REQUEST['id'];
		 $emp_id  = $_SESSION['employer']['id'];
		 $query_success = delete_job($emp_id, $id);	 
		 
		 if($query_success)
		 {
		 	$_SESSION['success']['jobmsg'] = "Job Deleted successfully";
		 }
		
		 	echo "done-SEPARATOR-".SERVER_ROOTPATH."emp-jobs-list";	
		
	}
	

}
?>
