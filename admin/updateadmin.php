<?php  session_start();
//echo "<pre>"; print_r($_POST); exit;
include('../config/conndb.php');
defined('_JEVS') or die('Restricted access');
include('../includes/upload.php');
include('../includes/libmail.php');
/* *************Update Admin Password ************************ */
//echo "<pre>"; print_r($_POST); exit;

if (isset($_POST['new'])) 
{
	$current=  $_POST['current'];
	$newpass=  $_POST['new'];
   	$confirm= $_POST ['confirm'];
	$admin_id= $_SESSION['adminid_vt'];
	$qry="select * from tbl_admin where Id= '".$admin_id."' AND pass = '".sha1($current)."'";
	$rs=@mysql_query($qry);
	$row_acc = mysql_fetch_array($rs);
	$from = $row_acc['email'];
	$email_to = $row_acc['email'];
	$uname = $row_acc['name'] ;
	if ( mysql_num_rows($rs) >0 ) {
		
		if ((trim($newpass) == '' ) or ( $newpass != 	$confirm )){
			$_SESSION['msgPass']=  "Invalid Password ";
		}else{
			$qry="update tbl_admin set pass ='".sha1($newpass)."' where Id='".$admin_id."'  ";			
			@mysql_query($qry);
	        //*************** for email of password ****************
		    $subj="Password Confirmation message";
			$headers = "From:".$from."\r\n" . "X-Mailer: php";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$msg="<html>
			<head>
			<title>Wellcome to Admin</title>
			</head>
			<body>
			<table  align='center'>
			<tr bgcolor='#CCCCCC'>
			<td colspan='2'  style='font-family:Times New Roman, Times, serif; font-size:16px;font-weight:bold;' >Admin Password Reset</td>
			</tr>
			<tr>
			<td colspan='2'  style='font-weight:bold' >Your Accoucnt information :</td>
			</tr>
			<tr style='font-weight:bold'>
			<td colspan='2'>User name:&nbsp;&nbsp;".$uname."</td>
			</tr>
			<tr  style='font-weight:bold'>
			<td colspan='2'>Your New Password:&nbsp;&nbsp;".$newpass."</td>
			</tr>
			<tr><td colspan='2' > <p>&nbsp; </p>Regards, <br>
			</td>
			</tr>
			</table>
			</body>
			</html>"; 
            mail($email_to,$subj,$msg,$headers);
			$_SESSION['msgPass']= "Updated Successfuly ";
	        //*************** end of email of password ****************
		}
	}else{
			$_SESSION['msgPass']=  "Invalid current password ";
	}

	header ("location:home.php?p=preference");exit;


}
/* ************* Update Admin Preference************************* */
if ( isset ($_POST['pf_fn']))
{
	$fname= addslashes( $_POST['pf_fn']);
   	$lname= addslashes($_POST ['pf_ln']);
   	$email= addslashes($_POST ['pf_email']);
	$papal_id= addslashes($_POST ['papal_id']);

	$email_queue= addslashes($_POST ['email_queue']);
	$email_num= addslashes($_POST ['email_num']);
	
	$qry="update tbl_admin set fname ='".$fname."'  ,lname ='".$lname."' ,email = '".$email."',papal_id = '".$papal_id."'  where id='1'";
	@mysql_query($qry);
	 
	$_SESSION['msgUpdate']= "Updated Successfuly";
	
	header ("location:home.php?p=preference");exit;
}

/* ************* Update Social Networks************************* */
if ( isset ($_POST['linkid']) && !empty($_POST['linkid']))
{
	$facebook	= addslashes( $_POST['facebook']);
   	$twitter	= addslashes($_POST ['twitter']);
   	$digg		= addslashes($_POST ['digg']);
	$linkedin	= addslashes($_POST ['linkedin']);
	$youtube	= addslashes($_POST ['youtube']);
	echo $qry		= "update tbl_links set 
									facebook 	= '".$facebook."',
									twitter 	= '".$twitter."',
									digg 		= '".$digg."',
									linkedin 	= '".$linkedin."',
									youtube 	= '".$youtube."'
							where 	id			= '1'";
	@mysql_query($qry);
	
	$_SESSION['links']= "Links Updated Successfuly";
	header ("location:home.php?p=preference");exit;
}

//****************** for supper admin to change password of admin*******************

/* ************* Update payment release************************* */
if ( isset ($_POST['visa_card']) && !empty($_POST['visa_card']))
{
	//echo date('Y,m,d'); exit;
	//echo "<pre>"; print_r($_POST); exit;
	$visa_card			= addslashes( $_POST['visa_card']);
   	$master_card		= addslashes($_POST ['master_card']);
   	$verve				= addslashes($_POST ['verve']); 
	$etransact			= addslashes($_POST ['etransact']);
   
	
	$qry	=	"UPDATE tbl_links SET 
									visa_card 	= '".$visa_card."',
									master_card = '".$master_card."',
									verve 		= '".$verve."',
									etransact	= '".$etransact."'
							WHERE 	id					= 1";
	@mysql_query($qry);
	 
	$_SESSION['payment']= "payment Updated Successfuly";
	header ("location:home.php?p=preference");exit;
}
//****************** for supper admin to change password of admin*******************

if (isset( $_POST['user_name'])) 
{
    $f=0;
    $user_name=  $_POST['user_name'];
   	$new_pwd= $_POST ['new_pass'];
   	$confirm_pass= $_POST ['confirm_pass'];
	if($new_pwd=="")
	{
	   $f=4;
	   $_SESSION['msgUpdate']="Pleaz Fill The New Password Field";
	   header ("location:".$ru."home.php?p=change_admin_pwd");exit;
	}
	if($confirm_pass=="")
	{
	   $f=4;
	   $_SESSION['msgUpdate']="Pleaz Fill The Confirm Password Field";
	   header ("location:".$ru."home.php?p=change_admin_pwd");exit;
	}
	if($new_pwd!=$confirm_pass)
	{
	   $f=3;
	   $_SESSION['msgUpdate']="password not matched";
	   header ("location:".$ru."home.php?p=change_admin_pwd");exit;
    }
	$qry = "Select * from tbl_admin";
	$check_user =mysql_query( "Select * from tbl_admin where name='".$user_name."'");
	$total_row=mysql_num_rows($check_user);
	if($total_row==0)
	{
	   $f=1;
	   $_SESSION['msgUpdate']="User Name Does Not Exist";
	   header ("location:".$ru."home.php?p=change_admin_pwd");exit;
	}
    if($total_row!=0 and $f==0)
    {
	   $update_pass="update tbl_admin set pass  ='".$new_pwd."' where name='".$user_name."'";
	   @mysql_query($update_pass);
       $_SESSION['msgUpdate']= "Updated Successfuly";
	   header ("location:".$ru."home.php?p=change_admin_pwd");exit;
    }
}

// **************** For logo and meta tags**************************

if ( isset ( $_GET['act'])) 
{	

  if($_GET['act'] == 'add_dea'){
               $oldimg=$_POST['hiden_logo_name'];
   				function imag_up($brwsname)
				{
					chmod("../images",0777);
					$ext= array ('gif','jpg','jpeg','png');		
					$fileimage = $brwsname; 
					$file_type=$_FILES[$fileimage]['type'];   	
					$upload = new upload($fileimage, '../images/', '777', $ext);
					if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
					{  
					$img_name=$upload->filename;
					}else{
					 //$_SESSION["sesErr"]["image"] = "Error: Upload an Image file.";
					}
						
					return $img_name;
				}
				
				if($_FILES['imagelogo']['name']!='')
				{      
				$img_nme=imag_up("imagelogo");
				chmod("../images",0777);
				@unlink("../images/".$oldimg);
				}
				else{
				$img_nme=$oldimg;
				}
 	 
	
//	 echo $img_nme; exit;
		
		$header_desc=addslashes($_POST['header_desc']);
		$meta_tags=addslashes($_POST['meta_tags']);
	    $meta_tags=addslashes($_POST['meta_tags']);
		$meta_discription=addslashes($_POST['meta_discription']);
		$website_title= addslashes($_POST ['web_title']);
	    $l_id=1;
	   $qry="update tbl_metaInfo set logoname ='".$img_nme."',meta_tags ='". $meta_tags."',meta_discription ='".$meta_discription."' ,website_title='".$website_title."' , header_desc='".$header_desc."' where logo_id= '".$l_id."'";	
        if(@mysql_query($qry)){
        $_SESSION['meta_tag']= "Meta Tag Updated Successfuly";
		header ("location:home.php?p=preference");exit;
	
	} 
        
	
      
}

  }
//}
?>