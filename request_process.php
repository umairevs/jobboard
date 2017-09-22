<?php   
include("common/top.php");


	foreach($_POST  as $key => $value)
{
   $$key = $value;
}
foreach($_GET as $key => $value)
{
   $$key = $value;
}
$regex 		 = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
$numbers_check = '/^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z]{6,}$/';
$Alpharex = '/^[a-z][a-z ]*$/i';	
if(isset($_REQUEST['calling']) && !empty($_REQUEST['calling']) && $_REQUEST['calling']!="")
{
	switch($_REQUEST['calling'])
	{
		case '1': 
			include("process/findajob_process.php");
		break;	
		case '2': 
			include("process/findajob_process.php");
		break;	
		case '3': 
			include("process/employer_process.php");
		break;	
		case '4': 
			include("process/employer_process2.php");
		break;	
		case '5': 
			include("process/signin_proecess.php");
		break;	
		case '6': 
			include("process/emp_profile_update_process.php");	
		break;	
		case '7': 
			include("process/emp_change_password_process.php");		
		break;	
		case '8': 
			include("process/job_process.php");
		break;	
		case '9': 
		include("process/seeker_profile_update_process.php");	
		break;	
		case '10': 
			include("process/seeker_change_password_process.php");		
		break;	
		case '11': 
			include("process/seeker_update_cv.php");			
		break;	
		
		case '12': 
			include("process/contactus_proecess.php");			
		break;	
	}	
		
}
exit;
?>