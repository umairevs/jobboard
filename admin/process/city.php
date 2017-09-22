<?php
$case = 1;
$error_str = "<ul>";


if($RegionID== '')
{
	$error_str .= "<li>State name is requireddd</li>";
	$case = 0;
}

if($City== '')
{
	$error_str .= "<li>City is required</li>";
	$case = 0;
}

$error_str .= "</ul>";

if($case==0){
	echo $error_str; 
}else{
	
	if($status==""){
		$status = 0;
	}
	
	if($CityId==""){

			$db->query("insert into tbl_city set City = '".addslashes($City)."', RegionID = '".addslashes($RegionID)."', CountryID = '".addslashes($CountryID)."', status = '".$status."'");
		
	}else{
		

			$db->query("update tbl_city set City = '".addslashes($City)."', RegionID = '".addslashes($RegionID)."', CountryID = '".addslashes($CountryID)."', status = '".$status."' where CityId='".$CityId."'");
	}
	$_SESSION['msg'] = 'Request Processed Successfully.';					
	echo "done-SEPARATOR-home.php?p=citylist&mod=location";	
}


?>
