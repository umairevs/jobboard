<?php
$case = 1;
$error_str = "<ul>";



if($exp_title== '')
{
	$error_str .= "<li>Title is required</li>";
	$case = 0;
}

$error_str .= "</ul>";


if($case==0){
	echo $error_str; 
}else{
	
	if($status==""){
		$status = 0;
	}
	
	if($exp_id==""){

		$sortorder = get_sortorder('tbl_experience');
		
		$db->query("insert into tbl_experience set exp_title = '".addslashes($exp_title)."', status = '".$status."', sortorder='".$sortorder."'");
		
		
		
	}else{
		$db->query("update tbl_experience set exp_title = '".addslashes($exp_title)."', status = '".$status."' where exp_id='".$exp_id."'");
	}

	 
	
	$_SESSION['msg'] = 'Request Processed Successfully.';					
	echo "done-SEPARATOR-home.php?p=experience&mod=job_settings";	
}


?>
