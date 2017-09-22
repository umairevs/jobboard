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
			$querycatupdate="update tbl_salary_type set status=$chstatus where salary_id=$catidchg";
			if($db->query($querycatupdate))
			{		
					
					$_SESSION['msg'] = "Requested processed successfully!";
					if($return_url != "")
					{
						header("location:$return_url");
					}
					else 
					{
						header("location:home.php?p=salary_type&mod=".$mod);
					}
			}
		}

//////////////////////////////////////delete category/////////////////////////////////////////////////
		if(isset($_GET['action']) && $_GET['action']=='del')
		{
		    $temid =$_REQUEST['cId'];
			

			$sqldel1 = "delete from tbl_salary_type where salary_id = '$temid' ";
			if($db->query($sqldel1))
			{
				$_SESSION['msg'] = "Requested processed successfully!";
				header("location:home.php?p=salary_type&mod=".$mod);exit;
			}
			else
			{
				$_SESSION['msg'] = "Record Does not Deleted. Try again";
				header("location:home.php?p=salary_type&mod=".$mod);exit;
			}	
		
	   }
		
	






?>