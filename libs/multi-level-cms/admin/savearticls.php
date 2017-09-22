<?php
defined('_JEVS') or die('Restricted access');
if($_GET['action'] == "change")
		{
			$update = "update tbl_articles set status = '".$_GET['status']."' where id='".$_GET['id']."'";
			$res_update-mysql_query($update);
			if($update)
			{	
				$_SESSION['msg'] = "Page Status Updated successfully";
				header("location: home.php?mod=$mod&p=articles");exit; 
			}
		}
		
	if($_GET['action'] == "changesub")
		{	$pid = $_GET['pid'];
			$update = "update tbl_articles set status = '".$_GET['status']."' where id='".$_GET['id']."'";
			$res_update-mysql_query($update);
			if($update)
			{	
				$_SESSION['msg'] = "Page Status Updated successfully";
				header("location: home.php?mod=$mod&p=subpages&id=$pid");exit; 
			}
		}
		
if (isset ($_POST['SaveTextData']))
{	
	//print_r($_POST); exit;
	$parent      = $_POST['parent'];
	$txtData     = addslashes($_POST['txtData']);
	$videolink   = addslashes($_POST['videolink']);
	$exlink      = addslashes($_POST['exlink']);
	$metakeyword = addslashes($_POST['metakeyword']);
	$metadesc    = addslashes($_POST['metadesc']);
	$title       = addslashes($_POST['title']);
	$parentt     = explode(',',$parent); 
	$parent      = $parentt[0];
	$level       = $parentt[1];
	$metatitle   = addslashes($_POST['metatitle']);
	
	if($_POST["title"] == '')
	{
		$_SESSION['addart']['title'] = "Please Enter Some Title.";
	}
	
	if($_POST["orderby"]!='' && !preg_match("#^[0-9\-\+\ ]+$#",$_POST["orderby"])){
			$_SESSION["addart"]["orderby"] = "Error: Page Order Should be Numaric";
	}
	if($_POST['txtData'] == '')
	{
		$_SESSION['addart']['txtData'] = "Please Enter Page Contents to Continue.";
	}
	
	if(isset($_SESSION["addart"]))
		{
			$_SESSION["addart_v"]["title"] = $_POST["title"];
			$_SESSION["addart_v"]["parent"] = $_POST["parent"];
			$_SESSION["addart_v"]["description"] = $_POST["description"];
			$_SESSION["addart_v"]["orderby"] = $_POST["orderby"];
			$_SESSION["addart_v"]["txtData"] = $_POST["txtData"];
			$_SESSION["addart_v"]["metakeyword"] = $_POST["metakeyword"];
			$_SESSION["addart_v"]["metatitle"] = $_POST["metatitle"];
			$_SESSION["addart_v"]["metadesc"] = $_POST["metadesc"];
			
			header("location:home.php?mod=$mod&p=addarticles");exit;
		}
		else{
			
			$qry="insert into  tbl_articles set title  = '".$title."', description  = '".$_POST['description']."', parent  = '".$parent."', orderby  = '".$_POST["orderby"]."', category_level  = '".$level."', content='".$txtData."', metatitle='".$metatitle."', metakeyword='".$metakeyword."', metadesc='".$metadesc."'";	
			$myqry=mysql_query($qry);
			if($myqry)
			{
				$_SESSION['msg']="Page Added Successfuly !";
				//header('location:home.php?p=articles');
			}
			if(isset($_POST['id']) && $_POST['id']!=''){
				header("location:home.php?mod=$mod&p=subpages&id=".$_POST['id']);
			}else {
				header("location:home.php?mod=$mod&p=articles");
			}
	
	}
}

?>