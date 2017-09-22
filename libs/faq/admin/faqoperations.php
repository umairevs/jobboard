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
if(isset($chstatus))
	{	
		$queryupdatestatus="update tbl_faq SET 
							faq_status='".addslashes($chstatus)."'
							where faq_id='".addslashes($faqid)."'";
		if($db->query($queryupdatestatus))
		{
			 $_SESSION['msg']="Question Status updated Successfully";
			 header("Location:home.php?mod=$mod&p=faqlist");
			 exit;
		} 
	}
//*************************************************************	
	if(isset($deletepage))
	{	
	    $querydelete="delete from tbl_faq where faq_id=$deletepage";
		if($db->query($querydelete))
			{
				 $_SESSION['msg'] = "Question Deleted Successfully";
				 header("Location:home.php?mod=$mod&p=faqlist");
				 exit;
			}
	}
	//add new question********************************************
	if(isset($addquestion))
	{  
		$_SESSION['question'] = $question;
		$_SESSION['answer']   = $answer;
 		
		$_SESSION['msg1'] = "";
		if($question == "")
		{
			$questionerror = "Please enter question.";
			$_SESSION['msg1'] = $questionerror;
		}
		
		if($answer == "")
		{
			$answererror = "Please enter answer to the question.";
			$_SESSION['msg1'] = $answererror;
		}
		
		if($_SESSION['msg1'] == "")
		{
			$querycheck="select count(*) as COUNT from tbl_faq where faq_question='$question'";
			$rowcheck=$db->get_row($querycheck,ARRAY_A);
			if($rowcheck[COUNT]==0)	
			{
				if(isset($active))
				$status=1;
				else
				$status=0;

				//$queryinsert="insert into tbl_faq(faq_question,faq_answer,faq_status,faq_groupid) values('$question','$answer',$status,$qgroup)";
				$queryinsert="insert into tbl_faq SET
							faq_question = '".addslashes($question)."',
							faq_answer = '".addslashes($answer)."',
							faq_status ='".addslashes($status)."',
							faq_groupid = '".addslashes($qgroup)."'";
				
				if($db->query($queryinsert))
				{
					 $_SESSION['msg']= "Question Added Successfully";
					 header("Location:home.php?mod=$mod&p=faqlist");
					 exit;
				}
			}
			else
			{
				$title=$question;
				$_SESSION['msg1']=$title. " is Already Exist!";
				$_SESSION['msg1']= $_SESSION['msg'];
				header("Location:home.php?mod=$mod&p=faqlist");
				exit;
			}
		}
		else
			{
				$questerror= $questionerror;
				$anserror= $answererror;
				header("Location:home.php?mod=$mod&p=newfaq&questerror=$questerror&anserror=$anserror");
				exit;
			}	
	}
	//update page title*******************************************************************************
	if(isset($updatequestion))
	{
		//echo $pagetitle=addcslashes($pagetitle); exit;
		$_SESSION['question'] = $_POST['question'];
		$_SESSION['answer']   = $_POST['answer'];
		
		$_SESSION['msg1'] = "";
		if($question == "")
		{
			$questionerror = "Please enter question.";
			$_SESSION['msg1'] = $questionerror;
		}
		
		if($answer == "")
		{
			$answererror = "Please enter answer to the question.";
			$_SESSION['msg1'] = $answererror;
		}
		
		if($_SESSION['msg1'] == "")
		{
			if(isset($active))
			$status=1;
			else
			$status=0;
			$queryupdate="update tbl_faq set 
						 faq_question='".addslashes($question)."',
						 faq_answer='".addslashes($answer)."',
						 faq_status='".addslashes($status)."',
						 faq_groupid='".addslashes($qgroup)."'
						 where faq_id='".addslashes($faqid)."'";
			if($db->query($queryupdate))
			{
				 $_SESSION['msg']= "Question Updated Successfully";
				 header("Location:home.php?mod=$mod&p=faqlist");
				 exit;
			} 
			else
			{
				$_SESSION['msg']= mysql_error();
				header("Location:home.php?mod=$mod&p=faqlist");
				exit;	
			}
		}
		else
			{
				$questerror= $questionerror;
				$anserror= $answererror;
				header("Location:home.php?mod=$mod&p=newfaq&editid=$faqid&questerror=$questerror&anserror=$anserror");
				exit;
			}	
	}
	
	if(isset($editid))
	{
		$queryedit="select * from tbl_faq where faq_id=$editid";
		$rowedit=$db->get_row($queryedit,ARRAY_A);
		
	}	
//*********************************************change group status
if(isset($faqgroupid))
{
	$queryupdatestatus="update tbl_faq_groups SET 
						group_status='".addslashes($st)."' 
						where faqg_id='".addslashes($faqgroupid)."'";
	if($db->query($queryupdatestatus))
	{
		 $_SESSION['msg']= "Group status updated Successfully";
		 header("Location:home.php?mod=$mod&p=faqgrouplist");
		 exit;
	}
}
if(isset($addgroup))
{	
	//echo "<pre>"; print_r($_POST);exit;
	$_SESSION['groupName'] = $groupname;
	$_SESSION['sortOrder'] = $sortingorder;
	$_SESSION['msg'] = "";
	if($groupname == "")
	{
		$groupnameerror = "Please enter group name.";
		$_SESSION['msg1'] = $groupnameerror;
	}
	
	if($sortingorder == "")
	{
		$sortingordererror = "Enter sort order.";
		$_SESSION['msg1'] = $sortingordererror;
	}

	if($_SESSION['msg1'] == "")
	{
		if(isset($active))
			$status=1;
		else
			$status=0;

		$querychk="select count(*) as COUNT from tbl_faq_groups where group_title='$groupname'";
		$rowchk=$db->get_row($querychk,ARRAY_A);
		if($rowchk[COUNT]==0)
		{
		
		
			$queryinsert="insert into tbl_faq_groups SET
						group_title='".addslashes($groupname)."',
						sortorder='".addslashes($sortingorder)."',
						group_status='".addslashes($status)."'";
			if($db->query($queryinsert))
			{
					 $_SESSION['msg']= "Group Added Successfully";
					 header("Location:home.php?mod=$mod&p=faqgrouplist");
					 exit;
			}
			else
			{
					$_SESSION['msg']= mysql_error();
					header("Location:home.php?mod=$mod&p=faqgrouplist");
					exit;
			}
		}
		else
		{
			$_SESSION['msg']= "Already Exist!";
			header("Location:home.php?mod=$mod&p=faqgrouplist");
			exit;
		}
	}
	else
	{
		$grerror= $groupnameerror;
		$sorterror= $sortingordererror;
		header("Location:home.php?mod=$mod&p=newfaqgroup&grerror=$grerror&sorterror=$sorterror");
		exit;
	}
}
//***************************************************************
if(isset($changesortingorder))
{
	
	 	$querysel="select * from tbl_faq_groups order by sortorder $limit";
	   $rowsel=$db->get_results($querysel,ARRAY_A);
		if(isset($rowsel))
		foreach($rowsel as $arrsel)
		{	
			$sortorder="srtorder".$arrsel[faqg_id];
			$sortorder=$$sortorder;

			$queryupdate="update tbl_faq_groups SET 
						  sortorder='".addslashes($sortorder)."' 
						  where faqg_id='".addslashes($arrsel[faqg_id])."'"; 
			$db->query($queryupdate);
		}
	
}
//*********************************
if($delid != "")
	{
		//echo $delid;exit;
		$sqldel1 = "delete from tbl_faq where faq_groupid = '$delid' ";
		$db->query($sqldel1);
		
		 $sqldel = "delete from tbl_faq_groups where faqg_id = '$delid' ";
		
		if($db->query($sqldel))
		{
			 $_SESSION['msg']= "Group Deleted Successfully";
			 header("Location:home.php?mod=$mod&p=faqgrouplist");
			 exit;
		}
	}
if(isset($editidgroup))
{
	$editidgroup= $editidgroup;
	$queryeditg="select * from tbl_faq_groups where faqg_id=$editidgroup";
	$roweditg=$db->get_row($queryeditg,ARRAY_A);
}
if(isset($updategroup)) 
{
	$_SESSION['msg1'] = "";
	if($groupname == "")
	{
		$groupnameerror = "Please enter group name.";
		$_SESSION['msg1'] = $groupnameerror;
	}
	
	if($sortingorder == "")
	{
		$sortingordererror = "Enter sort order.";
		$_SESSION['msg1'] = $sortingordererror;
	}
	
	if($_SESSION['msg1'] == "")
	{
	
		if(isset($active))
		$status=1;
		else
		$status=0;

		$queryupdate="update tbl_faq_groups SET 
					group_title='".addslashes($groupname)."',
					sortorder='".addslashes($sortingorder)."',
					group_status='".addslashes($status)."' 
					where  faqg_id='".addslashes($faqgid)."'"; 
		if($db->query($queryupdate))
		{
			 $_SESSION['msg']= "Group Updated Successfully";
			 header("Location:home.php?mod=$mod&p=faqgrouplist");
			 exit;
		}
		else
		{
			$_SESSION['msg']= mysql_error();
			header("Location:home.php?mod=$mod&p=faqgrouplist");
			exit;
		}
	}
	else
	{
		$grerror= $groupnameerror;
		$sorterror= $sortingordererror;
	    $editid  =base64_encode($faqgid);	
		header("Location:home.php?mod=$mod&p=newfaqgroup&grerror=$grerror&sorterror=$sorterror&editidgroup=$editid");
		exit;
	}	
}
?>