<?php
include("../common/top.php");
include("common/functions.php");
include_once('includes/simpleimage.php');


if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	$allowedExts 	= array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");	
	if(!isset($_SESSION['employer']))
	{
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."signin";	
		exit;
	}
	print_r($_REQUEST);
	
if($industry == '')
	{
		$errorstr .= "Please enter industry.\n";
		$case = 0;
		
	}
	
	if($company_name == '')
	{
		$errorstr .= "Please enter company name.\n";
		$case = 0;
		
	}
	
	
	if($mobile_no == '')
	{
		$errorstr .= "Please enter mobile number.\n";
		$case = 0;
		
	}
	
	if($address == '')
	{
		$errorstr .= "Please enter company address.\n";
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
				$var = move_uploaded_file($_FILES['image_filename']['tmp_name'],"media/emp_images/".$uploadfilename); 
				$sqlimage = ", image = '".$uploadfilename."'";
				
				//Resize image
				$simpleImage = new SimpleImage();
				$simpleImage->load('media/emp_images/'.$uploadfilename); 
				$simpleImage->resizeToWidth(95);
				$simpleImage->resizeToHeight(85);
				$simpleImage->save('media/emp_images/thumbs/'.$uploadfilename);
				
				if($old_image != ''){
				
				
					@unlink("media/emp_images/".$old_image);
					@unlink("media/emp_images/thumbs/".$old_image);
					
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
		$user_query		=	"Update tbl_employer set industry = '".$industry."', company_name = '".$company_name."', mobile_no = '".$mobile_no."', address = '".$address."' $sqlimage where  id = '".$_SESSION['employer']['id']."'";	
		$db->query($user_query);
		$_SESSION['success']['profile'] = "Record updated successfully";
		echo "gotonext-SEPARATOR-".SERVER_ROOTPATH."emp-profile";	
		exit;
	}
	

}
?>
