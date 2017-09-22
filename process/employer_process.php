<?php
include("../common/top.php");
include("common/functions.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	
	$email       	= trim($_REQUEST['email']);
	$confirm_email  = trim($_REQUEST['confirm_email']);
	$cv_file        = $_FILES['cv_file'];
	
	
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
					if($check_record)
					{
						$errorstr .= "Email account $email already exist.\n";
						$case = 0;
					}
				}
				
		}
	}

	 if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
	
	 if($case==1)
	{
		
		$rand_number  = rand(1111111,9999999);
		// Insert Employer record
		 $sql_qry="insert into tbl_employer set  email = '".$email."', password = '". sha1($rand_number) ."', status = 0, added_date = '".date("Y-m-d H:i:s") ."',verify_code='".$rand_number."'";			
		 $db->query($sql_qry);	// Query execute
		 
		 //Get Employer Insert ID
		 $emp_id  =  mysql_insert_id();
		 
		 //Insert job 
		 insert_job($emp_id, $_REQUEST);
		 
		 $row_email = get_emailtemp('employeraccount');	
		
		 $activation_url 	= "<a href=\"".SERVER_ROOTPATH."activation/".base64_encode($emp_id)."/$rand_number\">Click here for account activation</a>";;
		 // Making email msg
		 $htmlbody = "<html><head><title></title></head><body>" .stripslashes(($row_email['body'])) . "</body></html>";
	  $body = str_replace('{{Company_Name}}' ,  $company_name , $htmlbody); 
		$body = str_replace('{{ActivationLink}}' ,  $activation_url ,$body );
		 $headers = "MIME-Version: 1.0" . "\r\n";
		 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		 // More headers
		$headers .= 'From: <info@demo.evsoft.pk>' . "\r\n";
	
		
	
	     mail($email,stripslashes($row_email['subject']),$body,$headers);

		
		echo "done-SEPARATOR-".SERVER_ROOTPATH."thanks.php";	
		exit;  
		
		$_SESSION['employer_email']  =  $email;
		echo "done-SEPARATOR-".SERVER_ROOTPATH."postajob";	
		exit;
	}
	

}
?>
