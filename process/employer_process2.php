<?php
error_reporting(1);
include("../common/top.php");
include("common/functions.php");

if(isset($_POST)) 
{

	$errorstr="";
	$case = 1;
	
	if($_SESSION['employer_email']=='')
	{
		$errorstr .= "Please enter your emaila address.\n";
		$case = 0;
	}
	else
	{
		
			
			$ckh_email_explode = explode('@',$_SESSION['employer_email']);

				$ckh_email_valid   = $ckh_email_explode[1];

				$email_array = array('gmail.com', 'hotmail.com', 'yahoo.com', 'facebook.com');

				if(in_array($ckh_email_valid,$email_array))

				{

					$errorstr .= "Gmail,Hotmail, Yahoo and Facebook Email is not allowed.\n";

					$case = 0;

				}
				else
				{
					$check_record = get_user_by_employer($email);
					if($check_record)
					{
						$errorstr .= "Email account $email already exist.\n";
						$case = 0;
					}
				}
				
		
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
	
	if($industry == '')
	{
		$errorstr .= "Please enter industry.\n";
		$case = 0;
		
	}
	
	if($company_name == '')
	{
		$errorstr .= "Please enter company name.\n";
		$case = 0;
		
	}
	
	if($password == '')
	{
		$errorstr .= "Please enter your password.\n";
		$case = 0;
		
	}
	else
	if(strlen($password)<6)
	{
		$errorstr .= "Please enter your password at least 6 characters.\n";
		$case = 0;
	}
	
	if($mobile_no == '')
	{
		$errorstr .= "Please enter mobile number.\n";
		$case = 0;
		
	}
	
	if($address == '')
	{
		$errorstr .= "Please enter company address.\n";
		$case = 0;
		
	}
	
	if(!isset($_REQUEST['agree']))
	{
		$errorstr .= "Please accept terms and condition.\n";
		$case = 0;
	}
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
	
	if($case==1)
	{
	
		$rand_number  = rand(11111,99999);
	   
		// Insert Employer record
		$sql_qry="insert into tbl_employer set  email = '".addslashes($_SESSION['employer_email'])."', password = '". sha1($password)."',industry = '".addslashes($industry)."',company_name = '".addslashes($company_name)."',mobile_no = '".addslashes($mobile_no)."',address = '".addslashes($address)."', status = 0, added_date = '".date("Y-m-d H:i:s")."',verify_code = '".$rand_number."'";			
		 $db->query($sql_qry);	// Query execute
		 
		 //Get Employer Insert ID
		 $emp_id  =  mysql_insert_id();
		 
		 //Insert job 
		 insert_job($emp_id, $_REQUEST);
			
			
		$row_email = get_emailtemp('employeraccount');	
		
		$activation_url 	=	"<a href=\"".SERVER_ROOTPATH."activation/".base64_encode($emp_id)."/$rand_number\">Click here for account activation</a>";;
		// Making email msg
		$htmlbody = "<html><head><title></title></head><body>" .stripslashes(($row_email['body'])) . "</body></html>";
		$body = str_replace('{{Company_Name}}' ,  $company_name , $htmlbody);
		$body = str_replace('{{ActivationLink}}' ,  $activation_url ,$body );	
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: <info@demo.evsoft.pk>' . "\r\n";
		
		 mail($_SESSION['employer_email'],stripslashes($row_email['subject']),$body,$headers);

		
		echo "done-SEPARATOR-".SERVER_ROOTPATH."thanks.php";	
		exit;
	}
	

}
?>
