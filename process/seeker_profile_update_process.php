<?php
include("../common/top.php");
include("common/functions.php");
include_once('includes/simpleimage.php');


if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	$allowedExts 	= array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");	
	if(!isset($_SESSION['jobseeker']))
	{
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."logout";	
		exit;
	}
	
if($user_name == '')
	{
		$errorstr .= "Please enter your name.\n";
		$case = 0;
		
	}
	
	if($mobile_number == '')
	{
		$errorstr .= "Please enter your mobile number.\n";
		$case = 0;
		
	}
	
	
	if($job_country == '')
	{
		$errorstr .= "Please select country.\n";
		$case = 0;
		
	}
	
	if($job_state == '')
	{
		$errorstr .= "Please select state.\n";
		$case = 0;
		
	}
	
	if($job_city == '')
	{
		$errorstr .= "Please select city.\n";
		$case = 0;
		
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
				$sqlimage = ", image = '".$uploadfilename."'";
				
				//Resize image
				$simpleImage = new SimpleImage();
				$simpleImage->load('media/user_images/'.$uploadfilename); 
				$simpleImage->resizeToWidth(95);
				$simpleImage->resizeToHeight(85);
				$simpleImage->save('media/user_images/thumbs/'.$uploadfilename);
				
				if($old_image != ''){
				
				
					@unlink("media/user_images/".$old_image);
					@unlink("media/user_images/thumbs/".$old_image);
					
				}
			}
		
	}	
	
	if($case==0)
	{
		
			echo $errorstr;
			exit;
	}
	
	if($case==1)
	{
		$user_query		=	"Update tbl_job_seaker set name = '".$user_name."', mobile_number = '".$mobile_number."', country = '".$job_country."', state = '".$job_state."', city = '".$job_city."' $sqlimage where  id = '".$_SESSION['jobseeker']['id']."'";	
		$db->query($user_query);
		$_SESSION['success']['profile'] = "Record updated successfully";
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."jobseeker-profile";	
		exit;
	}
	

}
?>
