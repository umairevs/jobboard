<?php
$case = 1;
$error_str = "<ul>";



if($Region== '')
{
	$error_str .= "<li>State name is required</li>";
	$case = 0;
}

if($Code== '')
{
	$error_str .= "<li>State code is required</li>";
	$case = 0;
}

$error_str .= "</ul>";

if($case==0){
	echo $error_str; 
}else{
	
	if($status==""){
		$status = 0;
	}
	
	if($RegionID==""){


			$db->query("insert into tbl_state set Region = '".addslashes($Region)."', Code = '".addslashes($Code)."', CountryID = '".addslashes($CountryID)."', status = '".$status."'");
		
	}else{
			$db->query("update tbl_state set Region = '".addslashes($Region)."', Code = '".addslashes($Code)."', CountryID = '".addslashes($CountryID)."', status = '".$status."' where RegionID='".$RegionID."'");
	}
	$_SESSION['msg'] = 'Request Processed Successfully.';					
	echo "done-SEPARATOR-home.php?p=statelist&mod=location";	
}


?>
