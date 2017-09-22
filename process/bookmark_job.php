<?php
error_reporting(0);
include("../common/top.php");
include("../common/functions.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	$job_id       = trim($_REQUEST['job_id']);	
	
	
	if(!isset($_SESSION['jobseeker']))
	{
		echo $errorstr .= "Please Sign in first .\n";
		$case = 0;
		exit;
		
	}
	
	
	if($job_id == '')
	{
		$errorstr .= "Job does not exist.\n";
		$case = 0;		
	}
	else
	{
		$job_check = jobs_detail($job_id);
		if(!$job_check)
		{
			$errorstr .= "Job does not exist.\n";
			$case = 0;		
		}
		
		
		
	}
	
	
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
	
	if($case==1)
	{
	  $emp_id	=	$job_check['employer_id'];
	  
		$check = job_bookmark_check($job_id);
		if(!$check)
		{
			$user_query		=	"insert into tbl_jobs_bookmark set job_id = '".$job_id."', emp_id = '".$emp_id."', seeker_id = '".$_SESSION['jobseeker']['id']."', posted_date = '".date("Y-m-d H:i:s")."'";	
	
			$db->query($user_query);
			
			?>
            done-SEPARATOR-<a href="javascript:;" onClick="bookmark_job(<?php echo $job_id;?>)"  class="btn btn-primary bookmark"><i class="fa fa-bookmark-o" aria-hidden="true"></i>Remove Bookmark</a>
            <?php		
		}
		else
		{
			$user_query		=	"Delete from  tbl_jobs_bookmark where  seeker_id = '".$_SESSION['jobseeker']['id']."' AND job_id = '".$job_id."'";		
			$db->query($user_query);
			
			?>
             done-SEPARATOR-<a href="javascript:;" onClick="bookmark_job(<?php echo $job_id;?>)" class="btn btn-primary bookmark"><i class="fa fa-bookmark-o" aria-hidden="true"></i>Bookmark</a>
            <?php		
		}
	
	}
	
}	