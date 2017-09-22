<?php
error_reporting(1);
include("../common/top.php");
include("common/functions.php");

if(isset($_POST)) 
{

	$errorstr="";
	$case = 1;
	
	if(!isset($_SESSION['employer']))
	{
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."signin";	
		exit;
	}
	

	if($job_category == '')
	{
		$errorstr .= "Please select job category.\n";
		$case = 0;
		
	}
	
	if($jobtype == '')
	{
		$errorstr .= "Please select job type.\n";
		$case = 0;
		
	}
	
	if($job_title == '')
	{
		$errorstr .= "Please enter job title.\n";
		$case = 0;
		
	}
	
	if($job_description == '')
	{
		$errorstr .= "Please enter job description.\n";
		$case = 0;
		
	}
	
	
	if($job_country == '')
	{
		$errorstr .= "Please select country.\n";
		$case = 0;
		
	}
	
	
	if($job_state == '')
	{
		$errorstr .= "Please select state.\n";
		$case = 0;
		
	}
	
	if($job_city == '')
	{
		$errorstr .= "Please select city.\n";
		$case = 0;
		
	}
	
	
	if($job_salary_min == '')
	{
		$errorstr .= "Please enter minimum salary.\n";
		$case = 0;
		
	}
	
	if($job_salary_max == '')
	{
		$errorstr .= "Please enter maximum salary.\n";
		$case = 0;
		
	}
	
	if($job_salary_type == '')
	{
		$errorstr .= "Please select salary type.\n";
		$case = 0;
		
	}
	
	if($job_experience_level == '')
	{
		$errorstr .= "Please select job experience level.\n";
		$case = 0;
		
	}
	
	
	if($job_function == '')
	{
		$errorstr .= "Please enter job function.\n";
		$case = 0;
		
	}
	
	if($expiry_date == '')
	{
		$errorstr .= "Please select job expiry date.\n";
		$case = 0;		
	}
	else
	{
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$expiry_date)) 
		{
			$errorstr .= "Expiry date format invalid \n";
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
		 $edit_id  = $_REQUEST['edit_id'];
		 //Get Employer Insert ID
		if($edit_id!='')
		{
		 $emp_id  =   $_SESSION['employer']['id'];	
		 $query_success = update_job($emp_id, $edit_id, $_REQUEST);	 
		 if($query_success)
		 {
		 	$_SESSION['success']['jobmsg'] = "Record updated successfully";
		 }
		 else
		 {
		 	$_SESSION['success']['jobmsg'] = "Record not updated";
		 }
		 	echo "done-SEPARATOR-".SERVER_ROOTPATH."emp-edit-job/".$edit_id;	
		}
		else
		{
			$emp_id  =   $_SESSION['employer']['id'];
			 $query_success = insert_job($emp_id, $_REQUEST);
			 
			  if($query_success)
			 {
				$_SESSION['success']['jobmsg'] = "Record added successfully";
			 }
			 else
			 {
				$_SESSION['success']['jobmsg'] = "Record not added";
			 }
			
			 echo "done-SEPARATOR-".SERVER_ROOTPATH."emp-jobs-list";	
		}
		
	}
	

}
?>
