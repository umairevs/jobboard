<?php
 defined('_JEVS') or die('Restricted access');
 foreach($_POST  as $key => $value)
	{
	   $$key = $value;
	}
	foreach($_GET as $key => $value)  
	{
	   $$key = $value;
	}
///////////////////////////////////////////////////////////////////////////////
	
	
	///////////////////////////////////// CHANGE STATUS/////////////////////////////////
	
		if(isset($_GET['catidchg']))
		{	
			$catidchg = addslashes($_GET['catidchg']);
			$chstatus = addslashes($_GET['chstatus']);
			/*var_dump($res);exit;	  */
			$querycatupdate="update tbl_categories set active_status=$chstatus where category_id=$catidchg";
			if($db->query($querycatupdate))
			{		
					
					$_SESSION['msg'] = "Category updated successfully!";
					if($return_url != "")
					{
						header("location:$return_url");
					}
					else 
					{
						header("location:home.php?p=categorylist&mod=".$mod);
					}
			}
		}

//////////////////////////////////////delete category/////////////////////////////////////////////////
		if(isset($_GET['action']) && $_GET['action']=='del')
		{
		    $temid =$_REQUEST['cId'];
			$recipe  = get_categories($temid);
			$oldfile = $recipe['category_image'];
			
			@unlink("../media/category/$oldfile");
			@unlink("../media/category/thumbs/$oldfile");

			$sqldel1 = "delete from tbl_categories where category_id = '$temid' ";
			if($db->query($sqldel1))
			{
				$_SESSION['msg'] = "Category deleted successfully";
				header("location:home.php?p=categorylist&mod=".$mod);exit;
			}
			else
			{
				$_SESSION['msg'] = "Record Does not Deleted. Try again";
				header("location:home.php?p=categorylist&mod=".$mod);exit;
			}	
		
	   }
		
	






?>