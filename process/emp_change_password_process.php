<?php
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
	
	$old_password    	  = trim($_REQUEST['old_password']);
	$new_password    	  = trim($_REQUEST['new_password']);
	$confirm_new_password = trim($_REQUEST['confirm_new_password']);
	
	if($old_password == "")
	{
		$errorstr .="Please enter your current password\n";
		$case = 0;
	}
	else
	{
		 $chk_pass_qry ='select password from tbl_employer where 
		  	password  = \''.sha1($old_password).'\' and id="'.$_SESSION['employer']['id'].'" ';
		$chk_pass_arr = $db->get_row($chk_pass_qry, ARRAY_A);
		$chk_password    = $chk_pass_arr['password'];	
		if($chk_password=="")
		{
			$errorstr .="Incorrect current password entered, please try again\n";
			$case = 0;
		}
		else
		{
			if($new_password == "")
			{
				$errorstr .="Please enter your new password\n";
				$case = 0;
			}
			else
			if(strlen($new_password)<6)
			{
				$errorstr .= "Please enter your new password must be at least 6 characters.\n";
				$case = 0;
			}
			elseif($confirm_new_password == "")
			{
				$errorstr .="Please confirm your new password\n";
				$case = 0;
			}
			elseif($new_password != $confirm_new_password)
			{
				$errorstr.="Your new password does not match, please try again\n";
				$case = 0;
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
		$user_query		=	"Update tbl_employer set password = '".sha1($new_password)."' where  id = '".$_SESSION['employer']['id']."'";	
		$db->query($user_query);
		$_SESSION['success']['profile'] = "Password changed successfully";
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."emp-change-password";	
		exit;
	}
	

}
?>
