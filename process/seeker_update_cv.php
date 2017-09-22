<?php
error_reporting(1);
include("../common/top.php");
include("common/functions.php");
include_once('includes/simpleimage.php');

if(isset($_REQUEST)) 
{

	$errorstr="";
	$case = 1;
	
	//print_r($_REQUEST);
	if($fullname=='') 
	{
		$errorstr .= "Please enter full name \n";
		$case = 0;
	}
	
	$allowedExts 	= array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");	
	
		
	if(!isset($_SESSION['jobseeker']))
	{
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."logout";	
		exit;
	}
$sqlimage = '';
	
 

if ($_FILES['image_filename']['tmp_name']!= "" )
	{			
			$temp = explode(".", $_FILES['image_filename']['name']);
			$extension = end($temp);
			if (!in_array($extension, $allowedExts)) 
			{	
				
				$errorstr .= "You have selected an invalid file\n"."Valid files are gif, png, jpg, jpeg.\n";
				$case = 0;
			}
			elseif($_FILES['image_filename']['size'] > 5000000)
			{
				$errorstr .= "Selected image too large\n"."Max size allowed is 5MB.\n";
				$case = 0;
			}else{
				//Upload image
				$uploadfilename= rand().'_'.rand().'.'.$extension;
				$var = move_uploaded_file($_FILES['image_filename']['tmp_name'],"media/user_images/".$uploadfilename); 
				$sqlimage = ", photo_of_resume = '".$uploadfilename."'";
				
				//Resize image
				$simpleImage = new SimpleImage();
				$simpleImage->load('media/user_images/'.$uploadfilename); 
				$simpleImage->resizeToWidth(95);
				$simpleImage->resizeToHeight(85);
				$simpleImage->save('media/user_images/thumbs/'.$uploadfilename);
								
			}
		
	}	
	
	
	
	
	//work exp validation
	$size_of_company  = sizeof($company_name);
	for($k=0;$k<$size_of_company;$k++)
	{
		if($company_name[$k]!='' || $designation[$k]!='' || $from_job[$k]!='' || $to_job[$k]!='' || $job_description[$k]!='')
		{
			if($company_name[$k]=='') 
			{
				$errorstr .= "Please enter Company name \n";
				$case = 0;
			}
			
			if($designation[$k]=='') 
			{
				$errorstr .= "Please enter your designation \n";
				$case = 0;
			}
			
			if($from_job[$k]=='') 
			{
				$errorstr .= "Please select from job date \n";
				$case = 0;
			}
			else
			{
				if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$from_job[$k])) 
				{
					$errorstr .= "Time period from job date is invalid format \n";
					$case = 0;
				} 
			}
				
			if($to_job[$k]=='') 
			{
				$errorstr .= "Please select to job date \n";
				$case = 0;
			}
			else
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$to_job[$k])) 
				{
					$errorstr .= $to_job[$k]."Time period to job date is invalid format \n";
					$case = 0;
				} 
			
			if($job_description[$k]=='') 
			{
				$errorstr .= "Please enter job description \n";
				$case = 0;
			}		
		}
	}
	
	//work exp validation
	$size_of_inst_name  = sizeof($inst_name);
	for($k=0;$k<$size_of_inst_name;$k++)
	{
		if($inst_name[$k]!='' || $degree[$k]!='' || $from_date[$k]!='' || $to_date[$k]!='' || $description[$k]!='')
		{
			if($inst_name[$k]=='') 
			{
				$errorstr .= "Please enter Institue name \n";
				$case = 0;
			}
			
			if($degree[$k]=='') 
			{
				$errorstr .= "Please enter your degree \n";
				$case = 0;
			}
			
			if($from_date[$k]=='') 
			{
				$errorstr .= "Please select from date for education background \n";
				$case = 0;
			}
			else
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$from_date[$k])) 
				{
					$errorstr .= "Time period from date for education background is invalid format \n";
					$case = 0;
				} 
			
			
			if($to_date[$k]=='') 
			{
				$errorstr .= "Please select to job date \n";
				$case = 0;
			}
			else
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$to_date[$k])) 
				{
					$errorstr .= "Time period to date for education background is invalid format \n";
					$case = 0;
				} 
			
			if($description[$k]=='') 
			{
				$errorstr .= "Please enter education background description \n";
				$case = 0;
			}		
		}
	}
	
	
	//language validation
	$size_of_language  = sizeof($language);
	$m=1;
	for($k=0;$k<$size_of_language;$k++)
	{
		 $ratings  =  $rat_val[$k];
		
		
		
		if($language[$k]!='' || $_REQUEST['rating_'.$ratings]!='')
		{
			if($language[$k]=='') 
			{
				$errorstr .= "Please enter language name \n";
				$case = 0;
			}
		//	echo $_REQUEST['rating_'.$rat_val];
			if($_REQUEST['rating_'.$ratings]=='') 
			{
				$errorstr .= "Please select star rating \n";
				$case = 0;
			}
			
			
			
		}
		$m++;
	}
	
	
	if($father_name=='') 
	{
		$errorstr .= "Please enter father name \n";
		$case = 0;
	}
	
	if($mother_name=='') 
	{
		$errorstr .= "Please enter mother name \n";
		$case = 0;
	}
	
	if($dob=='') 
	{
		$errorstr .= "Please select your date of birth \n";
		$case = 0;
	}
	else
	if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dob)) 
	{
		$errorstr .= "Date of birth correct format YYYY-mm-dd \n";
		$case = 0;
	} 
	
	if($birth_place=='') 
	{
		$errorstr .= "Please enter your birth place \n";
		$case = 0;
	}
	
	if($nationality=='') 
	{
		$errorstr .= "Please enter your birth place \n";
		$case = 0;
	}
	
	if($sex=='') 
	{
		$errorstr .= "Please select Gender status \n";
		$case = 0;
	}
	
	if($address=='') 
	{
		$errorstr .= "Please enter your address \n";
		$case = 0;
	}

	
	
	if($case==1)
	{
	
		 $resume_info  = get_seeker_resume($_SESSION['jobseeker']['id']);
		 
		if($resume_info)
		{
						$user_query		=	"update  tbl_job_seaker_resume set 
									full_name = '".addslashes($fullname)."',
									additional_info = '".addslashes($additional_info)."',
									carrer_obj = '".addslashes($carrer_obj)."',
									qualification = '".addslashes($qualification)."',
									full_names = '".addslashes($fullname)."',
									father_name = '".addslashes($father_name)."',
									mother_name = '".addslashes($mother_name)."',
									dob = '".addslashes($dob)."',
									birth_place = '".addslashes($birth_place)."',
									nationality = '".addslashes($nationality)."',
									sex = '".addslashes($sex)."',
									address = '".addslashes($address)."',
									declaration  = '".addslashes($declaration)."',
									status  = '1',
									posted_date  = '".date("Y-m-d H:i:s")."'
									$sqlimage
									where 
									user_id  = '".addslashes($_SESSION['jobseeker']['id'])."'
									";	
			 $db->query($user_query);
			 
			 
			
		}
		else
		{
			
			$sqlimage = ", photo_of_resume = '".$old_image."'";
			$user_query		=	"insert into tbl_job_seaker_resume set 
									full_name = '".addslashes($fullname)."',
									additional_info = '".addslashes($additional_info)."',
									carrer_obj = '".addslashes($carrer_obj)."',
									qualification = '".addslashes($qualification)."',
									full_names = '".addslashes($fullname)."',
									father_name = '".addslashes($father_name)."',
									mother_name = '".addslashes($mother_name)."',
									dob = '".addslashes($dob)."',
									birth_place = '".addslashes($birth_place)."',
									nationality = '".addslashes($nationality)."',
									sex = '".addslashes($sex)."',
									address = '".addslashes($address)."',
									declaration  = '".addslashes($declaration)."',
									user_id  = '".addslashes($_SESSION['jobseeker']['id'])."',
									status  = '1',
									posted_date  = '".date("Y-m-d H:i:s")."'
									$sqlimage
									";	
			 $db->query($user_query);
			 
		}	
			
			//work exp insertion
			$delete_query  =  delete_record($_SESSION['jobseeker']['id'],'tbl_job_seaker_work_history');
			
			$size_of_company  = sizeof($company_name);
			for($k=0;$k<$size_of_company;$k++)
			{
				
			
				$work_history_query		=	"insert into tbl_job_seaker_work_history set 
									company_name = '".addslashes($company_name[$k])."',
									designation = '".addslashes($designation[$k])."',
									from_job = '".addslashes($from_job[$k])."',
									to_job = '".addslashes($to_job[$k])."',
									job_description = '".addslashes($job_description[$k])."',
									posted_date = '".date("Y-m-d H:i:s")."',
									user_id  = '".addslashes($_SESSION['jobseeker']['id'])."'
									";	
			   $db->query($work_history_query);
			}
			
			
			//institute name insertion
			$delete_query  =  delete_record($_SESSION['jobseeker']['id'],"tbl_job_seaker_edu_background");
			$size_of_inst_name  = sizeof($inst_name);
			for($k=0;$k<$size_of_inst_name;$k++)
			{
				
					$edu_query		=	"insert into tbl_job_seaker_edu_background set 
									inst_name = '".addslashes($inst_name[$k])."',
									degree = '".addslashes($degree[$k])."',
									from_date = '".addslashes($from_date[$k])."',
									to_date = '".addslashes($to_date[$k])."',
									description = '".addslashes($description[$k])."',
									posted_date = '".date("Y-m-d H:i:s")."',
									user_id  = '".addslashes($_SESSION['jobseeker']['id'])."'
									";	
			   		$db->query($edu_query);
				
			}
			
			//language insertioni
			$delete_query  =  delete_record($_SESSION['jobseeker']['id'],"tbl_job_seaker_language");
			$size_of_language  = sizeof($language);
			$m=1;
			for($k=0;$k<$size_of_language;$k++)
			{
				 
					$ratings  =  $rat_val[$k];
					
					$lanugage_query	="insert into tbl_job_seaker_language set 
									language = '".addslashes($language[$k])."',
									rating = '".addslashes($_REQUEST['rating_'.$ratings])."',
									posted_date = '".date("Y-m-d H:i:s")."',
									user_id  = '".addslashes($_SESSION['jobseeker']['id'])."'
									";	
			   		$db->query($lanugage_query);

				$m++;
			}
			
			 echo "done-SEPARATOR-".SERVER_ROOTPATH."edit-resume-SEPARATOR-Record added successfully.";	
			exit;
		
	}
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
}
?>

