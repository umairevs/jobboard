<?php
defined('_JEVS') or die('Restricted access');
//echo "<pre>"; print_r($_REQUEST); exit;
if (isset ($_REQUEST['type']))
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
		$qry="update tbl_emails set body = '".$txtData."'  where type ='".$txtSavePage."'";
	}
	mysql_query($qry) or die(mysql_error());
	$_SESSION['msgText']='Saved Successfuly !'; 
	header("location: home.php?mod=$mod&p=useremail&type=".$txtSavePage);		
}


?>