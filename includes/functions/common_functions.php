<?php
// get country name
function get_country($id){
	global $db;
	$qry = "SELECT * FROM `tbl_countries` WHERE CountryId = '".$id."'";
	$arr = $db->get_row($qry,ARRAY_A);
	return $arr;
}


// get country list
function get_country_list(){
	global $db;
	$qry = "SELECT * FROM `tbl_countries` order by Country ASC";
	$arr = $db->get_results($qry,ARRAY_A);
	return $arr;
}


// get state
function get_state($id){
	global $db;
	$qry = "SELECT * FROM `tbl_state` WHERE RegionID = '".$id."'";
	$arr = $db->get_row($qry,ARRAY_A);
	return $arr;
}



function get_states_list($id){
	global $db;
  	$qry ="SELECT * from tbl_state  where CountryID = '".$id."' order by Code asc";
	$arr = $db->get_results($qry,ARRAY_A);
	return $arr;
}

// get city
function get_city($id){
	global $db;
	$qry = "SELECT * FROM `tbl_city` WHERE CityId = '".$id."'";
	$arr = $db->get_row($qry,ARRAY_A);
	return $arr;
}

// get site settigns
function get_site_settings($id){
	global $db;
	$qry = "SELECT * FROM `tbl_site_settings` WHERE setting_id = '".$id."'";
	$arr = $db->get_row($qry,ARRAY_A);
	return $arr;
}
// get site settigns
function get_categories($id){
	global $db;
	$qry = "SELECT * FROM `tbl_categories` WHERE category_id = '".$id."'";
	$arr = $db->get_row($qry,ARRAY_A);
	return $arr;
}

// get experience
function get_experience($id){
	global $db;
	$qry = "SELECT * FROM `tbl_experience` WHERE exp_id = '".$id."'";
	$arr = $db->get_row($qry,ARRAY_A);
	return $arr;
}
// get salary_type
function get_salary_type($id){
	global $db;
	$qry = "SELECT * FROM `tbl_emp_type` WHERE emp_id = '".$id."'";
	$arr = $db->get_row($qry,ARRAY_A);
	return $arr;
}

function get_sortorder($table_name){
	global $db;
	$qry = "SELECT max(sortorder) as sort_order FROM $table_name";
	$arr = $db->get_row($qry,ARRAY_A);
	if($arr['sort_order']=="" || $arr['sort_order']==0){
	
		$value = 1;
	
	}else{
	
		$value = $arr['sort_order']+1;
	}
	return $value;
}

function get_sortorder_subcat($table_name, $id){
	global $db;
	$qry = "SELECT max(sortorder) as sort_order FROM $table_name where parent_id = '$id'";
	$arr = $db->get_row($qry,ARRAY_A);
	if($arr['sort_order']=="" || $arr['sort_order']==0){
	
		$value = 1;
	
	}else{
	
		$value = $arr['sort_order']+1;
	}
	return $value;
}
?>