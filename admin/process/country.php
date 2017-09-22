<?php
$case = 1;
$error_str = "<ul>";



if($Country== '')
{
	$error_str .= "<li>Country name is required</li>";
	$case = 0;
}

$error_str .= "</ul>";

if($case==0){
	echo $error_str; 
}else{
	
	if($status==""){
		$status = 0;
	}
	
	if($CountryId==""){

			$db->query("insert into tbl_countries set Country = '".addslashes($Country)."', status = '".$status."'");
		
	}else{
			$db->query("update tbl_countries set Country = '".addslashes($Country)."', status = '".$status."' where CountryId='".$CountryId."'");
	}
	$_SESSION['msg'] = 'Request Processed Successfully.';					
	echo "done-SEPARATOR-home.php?p=countrylist&mod=location";	
}


?>
