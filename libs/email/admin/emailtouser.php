<?php defined('_JEVS') or die('Restricted access');
include("../classes/myemailclass.php");

$current_date 	= date('Y-m-d h:i:s'); 
$user_id 		= addslashes($_POST['user']);
$user_id 		= addslashes($_POST['user']);  
$sub_cate_id 	= addslashes($_POST['sub_cate']);
$oid 			= addslashes($_POST['oid']);
$subject 		= addslashes($_POST['type']);  
$parent_id 		= addslashes($_POST['parent_cate']);
$txtData 		= addslashes($_POST['txtData']);
$course_title	= addslashes($_POST['course_title']);

$sql 			= "SELECT * FROM tbl_categories WHERE category_id = '".$sub_cate_id."'";
$subcat_result 	= $db->get_results($sql,ARRAY_A);
$sub_cate_name 	= $subcat_result[0]['category_name'];
$sub_cate_name 	= addslashes($sub_cate_name); 

$sql_query 		= "SELECT * FROM tbl_categories WHERE category_id = '".$parent_id."'";
$user_result 	= $db->get_results($sql_query,ARRAY_A);
$parent_cate 	= $user_result[0]['category_name'];
$parent_id 		= $user_result[0]['parent_id']; 

$sel_email 		= "SELECT * FROM tbl_users WHERE id = '".$user_id."'";
$user_email 	= $db->get_results($sel_email,ARRAY_A);
$users_email 	= $user_email[0]['email'];  
$user_fname 	= $user_email[0]['fname'];
$user_lname 	= $user_email[0]['lname'];
$user_password 	= $user_email[0]['password']; 
$id 			= $user_email[0]['id']; 

$sel_admin_email = "SELECT  email,name FROM tbl_admin WHERE id = '1'";
$admin_email 	 = $db->get_results($sel_admin_email,ARRAY_A);
$ad_email 		 = $admin_email[0]['email']; 
$ad_name 		 = $admin_email[0]['name']; 

$message		 = str_replace("{{FirstName}}", $user_fname, $txtData);
$message		 = str_replace("{{LastName}}", $user_lname, $message); 
$message		 = str_replace("{(UserEmail)}", $users_email, $message);
$message		 = str_replace("{(CourseTitle)}", $course_title, $message);
$message		 = str_replace("{(ParentCategory)}", $parent_cate, $message);
$message		 = str_replace("{(SubCategory)}", $sub_cate_name, $message);
$message		 = html_entity_decode($message);

$sent_email 	 = sendemailings($users_email,'',$ad_email,$subject,$message,'',''); 

if($sent_email == 1 ){
	
	mysql_query("UPDATE tbl_orders SET payment_email_byadmin = 1 WHERE id = '".$oid."'");
	
	$sql_qry 	 = "SELECT count(*) as total FROM tbl_adminpayment WHERE user_id = '".$id."'";
	$user_record = $db->get_results($sql_qry,ARRAY_A);
	$count_total = $user_record[0]['total'];
	
	$sql 			= "SELECT duplicate_email FROM tbl_adminpayment WHERE user_id = '".$id."'";
	$duplicate_email= $db->get_results($sql,ARRAY_A);
	$repeated_email = $duplicate_email[0]['duplicate_email'];
	$repeated_email = $repeated_email + 1;
	
	if($count_total > 0){
		mysql_query("UPDATE tbl_adminpayment SET duplicate_email = '".$repeated_email."' WHERE user_id = '".$id."'");
	}
	else
	{
		mysql_query("INSERT INTO tbl_adminpayment (fname,lname,email,password,parent_cat,sub_cat,parent_id,subcat_id,email_template,email_content,user_id,add_date) value('".$user_fname."','".$user_lname."','".$users_email."','".$user_password."','".$parent_cate."','".$sub_cate_name."','".$parent_id ."','".$sub_cate."','".$subject."','".$message."','".$id."','".$current_date."')");
	}
}
	
$_SESSION['msg']='Email Send Successfully !'; 
header("location: home.php?mod=order&p=orderlist");	
?>