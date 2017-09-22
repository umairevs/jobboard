<?php   
ob_start();
 	session_start();
	ini_set('error_reporting', 0);
	include ('../config/conndb.php');
	defined('_JEVS') or die('Restricted access');
	include('../includes/functions/functions.php');
	include('../includes/functions/common_functions.php');
	include('../includes/upload.php');
	include_once('../includes/simpleimage.php');	


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
		case '1': // add edit country
			include("process/country.php");
		break;

		case '2': // add edit state
			include("process/state.php");
		break;
		
		case '3': // add edit city
			include("process/city.php");
		break;		

		case '4': // get state dropdown
			include("process/state_dropdown.php");
		break;		

		case '5': // add edit categories
			include("process/categories.php");
		break;		

		case '6': // add edit experience
			include("process/experience.php");
		break;			


		case '7': // add edit salary type
			include("process/salary_type.php");
		break;	
	}	
		
}
exit;
?>