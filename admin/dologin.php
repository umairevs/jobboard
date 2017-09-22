<?php ob_start();	session_start();
      include ('../config/conndb.php');				
	  defined('_JEVS') or die('Restricted access');
	if ( isset($_POST['login'])) 
	{ 
		if (empty($_POST['name']) || empty($_POST['password']))
		{
			$msg=base64_encode('Please enter User Or Password to continue.');
			header("location:index.php?msg=$msg");exit;
		}
		/*if (empty($_POST['pincode']))
		{
			$msg=base64_encode('Please enter Security Code to continue.');
			header("location:index.php?msg=$msg");exit;
		}elseif ($_POST['pincode'] != $_SESSION['security_code'])
		{
			$msg=base64_encode('Entered Security Code is Invalid.');
			header("location:index.php?msg=$msg");exit;
		}*/
		
		$qry="SELECT * FROM tbl_admin where name = '".$_POST['name']."' and pass='".sha1($_POST['password'])."'";
	
		$rs = @mysql_query($qry);
		if ( @mysql_num_rows($rs) > 0 ) 
		{
			session_start();
			
			$_SESSION['adminLogin_vt']='True';
			$rowAdmin = mysql_fetch_array($rs);
			
			$_SESSION['usertype_vt']=$rowAdmin['type'];
			$_SESSION['fname_vt']=$rowAdmin['fname'];
			$_SESSION['lname_vt']=$rowAdmin['lname'];
			$_SESSION['email_vt']=$rowAdmin['email'];
			$_SESSION['adminid_vt']=$rowAdmin['Id'];
			
			header("location:home.php?p=homepage");exit;
			
			//header("location:home.php?p=articles&mod=multi-level-cms");exit;
			
			
			
		}else{
		
			$msg=base64_encode('Invalid user name or password !');
			header("location:index.php?msg=$msg");exit;
		}
	}else{
		header("location:index.php");exit;
	}
?>