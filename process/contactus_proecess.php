<?php
include("../common/top.php");
include("common/functions.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	$name       = trim($_REQUEST['name']);	
	$email       = trim($_REQUEST['email']);
	$message       = trim($_REQUEST['message']);

	
	
	if($email == '')
	{
		$errorstr .= "Please enter your name.\n";
		$case = 0;
		
	}
	
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
		
	}
	
	if($message == '')
	{
		$errorstr .= "Please enter your message.\n";
		$case = 0;
		
	}	
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}else{
	
		$row_email = get_emailtemp('contactus');	
		$htmlbody = "<html><head><title></title></head><body>" .stripslashes(($row_email['body'])) . "</body></html>";
		$body = str_replace('{{NAME}}' ,  $name , $htmlbody);
		$body = str_replace('{{EMAIL}}' ,  $email , $body);
		$body = str_replace('{{MESSAGE}}' ,  nl2br($message) , $body);		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: <info@demo.evsoft.pk>' . "\r\n";
		mail($row_email['toadmin'],stripslashes($row_email['subject']),$body,$headers);
		$_SESSION['success']['msg'] = "Your message sent.";
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."contact-us";	
	}
		
	
}
?>
