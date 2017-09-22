<?php
include("../common/top.php");
include("common/functions.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	
	$email       = trim($_REQUEST['email']);
	$password       = $_REQUEST['password'];
	$job_type       = $_REQUEST['job_type'];
	
	$valid_email = 0;
	$valid_password	= 0;
	if($job_type=='')
	{
		$errorstr .= "Please select job type.\n";
		$case = 0;
	}
	else
	if($job_type==2)
	{
		if($email == '')
		{
			$errorstr .= "Please enter your email address.\n";
			$case = 0;
			
		}
		else
		{
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
				$errorstr .="Incorrect email address entered. \n";
				$case = 0;
			}
			else
			{
				
				$ckh_email_explode = explode('@',$email);
	
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
						if(!$check_record)
						{
							$errorstr .= "Email address does not exist in our system.\n";
							$case = 0;
						}
						else
						{
							
							$valid_email = 1;
						}	
					}
					
			}
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
		else
		{
			$valid_password = 1;
		}		
		
		if($valid_email==1 && $valid_password==1)
		{
			 $user_query		=	"Select email, id, status, last_login_date from tbl_employer where  email = '".$email."' AND password = '".sha1($password)."'";	
			$user_arr			=	$db->get_row($user_query,ARRAY_A);
			if($user_arr)
			{
					if($user_arr['status']==0)
					{
						$errorstr .= "Your account status is inactive.\n";
						$case = 0;
					}
					else
					{
						unset($_SESSION['jobseeker']);
						$_SESSION['employer']['id']  =  $user_arr['id'];
						$_SESSION['employer']['email']  =  trim($user_arr['email']);
						if($user_arr['last_login_date']=='0000-00-00 00:00:00')
						{
							$lastlogindate = '';
						}
						else
						{
							$lastlogindate = $user_arr['last_login_date'];
						}	
						
						$_SESSION['employer']['last_login_date']  =  $lastlogindate;
						
						 $user_query		=	"Update tbl_employer set last_login_date = '".date_time()."' where  id = '".$user_arr['id']."'";	
						 $db->query($user_query);
						
						echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."emp-profile";
						exit;
					}
			}
			else
			{
				$errorstr .= "Please enter your password correctly.\n";
				$case = 0;
			}
			
		}
		
			
	}
	else
	if($job_type==1)
	{
		if($email == '')
		{
			$errorstr .= "Please enter your email address.\n";
			$case = 0;
			
		}
		else
		{
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
				$errorstr .="Incorrect email address entered. \n";
				$case = 0;
			}
			else
			{
						$check_record = get_user_by_email($email);
						if(!$check_record)
						{
							$errorstr .= "Email address does not exist in our system.\n";
							$case = 0;
						}
						else
						{
							
							$valid_email = 1;
						}	
						
			}
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
		else
		{
			$valid_password = 1;
		}		
		
		if($valid_email==1 && $valid_password==1)
		{
			 $user_query		=	"Select email, id, status, last_login_date from tbl_job_seaker where  email = '".$email."' AND password = '".sha1($password)."'";	
			$user_arr			=	$db->get_row($user_query,ARRAY_A);
			if($user_arr)
			{
					if($user_arr['status']==0)
					{
						$errorstr .= "Your account status is inactive.\n";
						$case = 0;
					}
					else
					if($user_arr['status']==2)
					{
						$errorstr .= "You are not able to login because your account status is removed.\n";
						$case = 0;
					}
					else
					{
						unset($_SESSION['employer']);
						$_SESSION['jobseeker']['id']  =  $user_arr['id'];
						$_SESSION['jobseeker']['email']  =  trim($user_arr['email']);
						if($user_arr['last_login_date']=='0000-00-00 00:00:00')
						{
							$lastlogindate = '';
						}
						else
						{
							$lastlogindate = $user_arr['last_login_date'];
						}	
						
						$_SESSION['jobseeker']['last_login_date']  =  $lastlogindate;
						
						$user_query		=	"Update tbl_job_seaker set last_login_date = '".date_time()."' where  id = '".$user_arr['id']."'";	
						$db->query($user_query);
						
						echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."jobseeker-profile";
						exit;
					}
			}
			else
			{
				$errorstr .= "Please enter your password correctly.\n";
				$case = 0;
			}
			
		}
		
	}		
	
	
	
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
		

}
?>
