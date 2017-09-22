<?php
defined('_JEVS') or die('Restricted access');
if (isset ($_POST['SaveTextData']))
{
	$adminname   = addslashes($_POST['adminname']);
	$toadmin     = addslashes($_POST['toadmin']);
	$touser      = addslashes($_POST['touser']);
	$txtData     = addslashes($_POST['txtData']);	
	$txtSubject  = addslashes($_POST['txtSubject']);	
	$txtSavePage = addslashes($_POST['savepage']);
	
	$rsCMS=mysql_query("select * from tbl_emails where type ='".$txtSavePage."'");
	if ( mysql_num_rows($rsCMS)>0	)
	{		
		$qry="update tbl_emails set adminname = '".$adminname."',toadmin = '".$toadmin."',touser = '".$touser."',subject = '".$txtSubject."',body = '".$txtData."'  where type ='".$txtSavePage."'";
	}else if($txtSavePage != ""){
		$qry="insert into tbl_emails set adminname = '".$adminname."',toadmin = '".$toadmin."',touser = '".$touser."',subject = '".$txtSubject."',body = '".$txtData."'  , type ='".$txtSavePage."'";
	}
	mysql_query($qry) or die(mysql_error());
	$_SESSION['msgText']='Saved Successfuly !'; 
	header("location: home.php?mod=$mod&p=emailsalert&type=".$txtSavePage);		
}


?>