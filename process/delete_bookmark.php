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
		 $seeker_id  = $_SESSION['jobseeker']['id'];
		 $query_success = delete_bookmark($seeker_id, $id);	 
		 
		 if($query_success)
		 {
		 	$_SESSION['success']['jobmsg'] = "Bookmark remove successfully";
		 }
		
		 	echo "done-SEPARATOR-".SERVER_ROOTPATH."jobseeker-bookmark";	
		
	}
	

}
?>
