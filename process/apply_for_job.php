<?php
error_reporting(0);
include("../common/top.php");
include("../common/functions.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	$job_id       = trim($_REQUEST['job_id']);	
	
	
	if(!isset($_SESSION['jobseeker']))
	{
		echo $errorstr .= "Please Sign in first .\n";
		$case = 0;
		exit;
		
	}
	else
	{
		$resume_info  = get_seeker_resume($_SESSION['jobseeker']['id']);
		$father_name   =  stripslashes($resume_info['father_name']);	
		
		if($father_name=='')
		{
			echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."post-resume-SEPARATOR-Please Post Your CV";	
			exit;
		}
	}
	
	if($job_id == '')
	{
		$errorstr .= "Job does not exist.\n";
		$case = 0;		
	}
	else
	{
		$job_check = jobs_detail($job_id);
		if(!$job_check)
		{
			$errorstr .= "Job does not exist.\n";
			$case = 0;		
		}
		
		
		$check = job_applied_check($job_id);
		if($check)
		{
			$errorstr .= "You are already applied for this job.\n";
			$case = 0;		
		}
	}
	
	if($case==1)
	{
		$jobinfo  = jobs_detail($job_id);
		$expiry_date  = $jobinfo['expiry_date'];
		
		if($expiry_date>=date("Y-m-d"))
		{
			$errorstr .= "Sorry this job is expired.\n";
			$case = 0;
		}
	}
	
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
	
	if($case==1)
	{
	  $emp_id	=	$job_check['employer_id'];
	  
	
		$user_query		=	"insert into tbl_jobs_applied set job_id = '".$job_id."', emp_id = '".$emp_id."', seeker_id = '".$_SESSION['jobseeker']['id']."', posted_date = '".date("Y-m-d H:i:s")."'";	
	
		$db->query($user_query);
		echo "done-SEPARATOR-$job_id-SEPARATOR-Successfully Applied";
		
		exit;
	}
	
}	