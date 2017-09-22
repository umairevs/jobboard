<?php
	
//include ("security.php");
defined('_JEVS') or die('Restricted access');
if (isset($_POST['SaveTextData']))
{	

//print_r($_POST);exit;
//echo "sadf";exit;
	
	$id=$_POST['id'];
	$pid=$_POST['pid'];
	$txtData     = addslashes($_POST['txtData']);
	$videolink   = addslashes($_POST['videolink']);
	$exlink      = addslashes($_POST['exlink']);
	$metatitle   = addslashes($_POST['metatitle']);
	$metakeyword = addslashes($_POST['metakeyword']);
	$metadesc    = addslashes($_POST['metadesc']);
	$title       = addslashes($_POST['title']);
	$parent      = $_POST['parent'];
	
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
			$_SESSION["addart_v"]["metadesc"] = $_POST["metadesc"];
			$_SESSION["addart_v"]["metakeyword"] = $_POST["metakeyword"];
			$_SESSION["addart_v"]["metatitle"] = $_POST["metatitle"];
			
			header("location:home.php?mod=$mod&p=editarticles");exit;
		}
		else{
			
			$qry="update tbl_articles set title  = '".$title."' , description  = '".$_POST['description']."', orderby  = '".$_POST["orderby"]."', content='".$txtData."', metatitle='".$metatitle."', metakeyword='".$metakeyword."', metadesc='".$metadesc."' where id='".$id."'";	
			$myqry=mysql_query($qry);
		
			if($myqry)
			{
			$_SESSION['msg']=$title." Updated Successfuly !";
			}
			if(isset($pid) && $pid!=''){
				header("location:home.php?mod=$mod&p=subpages&id=".$pid);
			}else {
				header("location:home.php?mod=$mod&p=articles");
			}
		}	
}
?>