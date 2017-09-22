<?php
error_reporting(1);
include("../common/top.php");
include("common/functions.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	
	$email       = trim($_REQUEST['email']);
	$confirm_email       = trim($_REQUEST['confirm_email']);
	$cv_file       = $_FILES['cv_file'];
	
	
	if($_REQUEST['calling']==1)
	{
		if($_FILES["cv_file"]['name']=="")
		{
			$errorstr .="Please upload your CV\n";
			$case = 0;
		}
		else
		if($_FILES["cv_file"]['name']!="")
		{
			$filename = $_FILES["cv_file"]['name'];
			$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
			$ext = array('doc', 'docx','pdf');
			if(!in_array($TmpExt,$ext))
			{
				$errorstr .= "Incorrect file format, please upload doc,docx or pdf file.\n";
				$case = 0;
			}
		}
	}
		
	if($case==0)
	{
		echo $step = "step1";
		echo $errorstr;
		exit;
	}
	else
	{
		$calling = 2;
	}
	
	
	if($_REQUEST['calling']==2 || $calling==2)
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
			
			$get_userlist =  get_user_by_email($email);
			
			if($get_userlist)
			{
				if($get_userlist['status']==0)
				{
					$errorstr .="Your account status is inactive\n";
					$case = 0;
				}
				
			}
		}
	}
	
	

}	
	if($case==0)
	{
		
		if($_REQUEST['calling']==1 && $calling==2)
		{
			echo $step = "step2";
			exit;
		}
		else
		{
			echo $step = "step2";
			echo $errorstr;
			exit;
		}
		//echo $errorstr;
		
	}
	
	if($case==1)
	{
		
		if($_FILES["cv_file"]['name']!="")
	{
			$filename = $_FILES["cv_file"]['name'];
			$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
			
			$getname  = explode(".",$_FILES["cv_file"]['name']);
			$getname  = $getname[0];
			
			
			$uploadfilename= $getname.'_'.rand().'.'.$TmpExt;
			$var = move_uploaded_file($_FILES['cv_file']['tmp_name'],"media/category/".$uploadfilename); 
				
		
			
			
			$filename = "media/category/".$_FILES["cv_file"]["name"];  //File that resides on your server
			$byteArr = file_get_contents($filename); //This actually reads the content as a string but is automatically converted to a byte array for the web service
			$key = "e70d3452-3365-e711-9104-00155d692ee1";
			$password = "pass1234";
			
			$atservices_wsdl = "http://www.cvparseapi.com/cvparseapi.asmx?WSDL";
			
		
			 
			try {
			  $atservices_client = new SoapClient($atservices_wsdl);
			
			  //The names f, fileName, YourKey, Password must match exactly what the service expects (this is case sensitive)
			  $args = array('f' => $byteArr,
			  'fileName' => $filename,
			  'YourKey' => $key,
			  'Password' => $password
			  );
			
			  $myXMLData = $atservices_client->ParseResumeNTG($args);
			  $xml=simplexml_load_string($myXMLData->ParseResumeNTGResult);
			  
		 
			  
			  $name = $xml->Resume[0]->Name;
			  $phone = $xml->Resume[0]->Phone;
			  $ResumeText	=$xml->Resume[0]->ResumeText;
			} catch (Exception $e) {
			  echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
			
			
			
	}
		$time = time();
		$password_simple  = rand(1111111, 9999999);
		$password  = sha1($password_simple);
	 	
			 $sql_qry="insert into tbl_job_seaker set  name = '".addslashes($name)."', password = '$password',mobile_number = '".addslashes($phone)."',email = '".addslashes($email)."', file = '".$uploadfilename."', posted_date = '".date("Y-m-d H:i:s")."', verify_code = '".$time."', resume_text = '".$ResumeText."'";
			
		    $db->query($sql_qry);	
			
			$last_ins_id  = mysql_insert_id();
					
		    $row_email =  get_emailtemp('jobseekeraccount'); // Get email template
		
			 $row_adm =  get_admininfo(); // Get admin info
			
			// fetching admin credentials end //
			$htmlbody = "<html><head><title></title></head><body>" .stripslashes(($row_email['body'])) . "</body></html>";
			
			$activation_url 	=	"<a href=\"".SERVER_ROOTPATH."activation_jobseeker/".base64_encode($last_ins_id)."/$time\">Click here for account activation</a>";;
			
			$body = str_replace('{{Fullname}}' ,  $name  ,$htmlbody );
			$body = str_replace('{{Password}}' ,  $password_simple  ,$body );
			$body = str_replace('{{ActivationLink}}' ,  $activation_url ,$body );
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$headers .= 'From: <info@demo.evsoft.pk>' . "\r\n";		
			
			
			
			 mail($email,stripslashes($row_email['subject']),$body,$headers);
			
			
		echo $step = "step3";
		echo "Check your email, click the link we sent to $email";	
		exit;
	}
	
	
}
?>
