<?php
	include('../config/conndb.php');
	include("../includes/libmail.php");		
	include("../includes/functions/functions.php");	
	include('includes/phpmailer/class.phpmailer.php');	
	ob_start();	session_start();			

/*...............................Forgot Passsword..................................................*/	

	if ( isset ($_POST['mode']) && $_POST['mode'] == 'forgetpassword') 
	{
		$subject="Forget Password";
		if (empty($_POST['name']))
		{
			$msg = base64_encode("Please Enter User Email!");
			header("Location: forgot_password.php?msg=$msg");
			exit;
		}
		
		$qrylogin = "SELECT * FROM tbl_admin WHERE email  = '".$_POST['name']."'";
		$rslogin = $db->get_row($qrylogin,ARRAY_A);
		$encrypted=$rslogin[email];
		
		if($encrypted != $_POST['name'])
		{
			$msg = base64_encode("Invalid Login name!");
			header("Location: forgot_password.php?msg=$msg");
			exit;
		}
		else
		{		
		   $qryTitle= mysql_query("SELECT  website_title  FROM tbl_metaInfo");
		   $rowTitle= mysql_fetch_array($qryTitle);
		   
		    $new_password = getPassword(12);
		   
		    $query_pass = "update tbl_admin set pass = '".sha1($new_password)."' where email = '".trim($_POST["name"])."'";
			$result_pass = mysql_query($query_pass);	
		
			$admin_name=$rslogin['fname'].' '.$rslogin['lname'];
			$email_text = "Dear ".$admin_name.",<br><br>Here is the Following information:-<br><br>Useranme:-"
						.$rslogin[name].
						" <br>Password:- "
						.$new_password."<br><br>". $rowTitle['website_title'];

			$subject="Forget Password";

			//$rslogin[email] = 'moeez.evs@gmail.com';

			$m = new Mail(); // create the mail
			$m->From($rslogin[email]);
			$m->To($rslogin[email]);
			$m->Subject($subject);
			$m->Body($email_text);
			
			$m->Send(); 
			$msg = base64_encode("Password Sent to your Mail Box!");
			header("Location: forgot_password.php?msg=$msg ");
			exit;
		}
	}else{
		$msg = base64_encode("Invalid Access");
		header("Location: forgot_password.php?msg=$msg");
		exit;
	}
	
	
?>