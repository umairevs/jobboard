<?php
$case = 1;
$error_str = "<ul>";



if($emp_title== '')
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
	
	if($emp_id==""){

		$sortorder = get_sortorder('tbl_emp_type');
		$db->query("insert into tbl_emp_type set emp_title = '".addslashes($emp_title)."', status = '".$status."', sortorder='".$sortorder."'");
		
	}else{
		$db->query("update tbl_emp_type set emp_title = '".addslashes($emp_title)."', status = '".$status."' where emp_id='".$emp_id."'");
	}
	$_SESSION['msg'] = 'Request Processed Successfully.';					
	echo "done-SEPARATOR-home.php?p=salary_type&mod=job_settings";	
}


?>
