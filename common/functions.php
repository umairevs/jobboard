<?php
$sums = 0;
$vs = 0;
$counter_star = 0;
$info_paragraph_new	= '';
function get_user_by_email($email)
{
	 global $db;
     $user_query		=	"Select * from tbl_job_seaker where  email = '".$email."'";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);		
	 return $user_arr;
	
}
// Email template for employer
function get_user_by_employer($email)
{
	 global $db;
	 $user_query		=	"Select * from tbl_employer where  email = '".$email."'";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);
	 return $user_arr;
	
}

// Gets jobs listing
function jobs_list($emp_id)
{
	 global $db;
	 $user_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND j.employer_id = '$emp_id' order by id desc";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 		
	 return $user_arr;
}

// Gets jobs seeker applied jobs
function jobs_list_applied_jobs()
{
	 global $db;
	 $user_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j, tbl_jobs_applied a where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND a.job_id = j.id ANd e.id = a.emp_id AND a.seeker_id = '".$_SESSION['jobseeker']['id']."' order by a.id desc";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 		
	 return $user_arr;
}

// Gets jobs seeker applied jobs
function jobs_list_bookmark_jobs()
{
	 global $db;
	 $user_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j, tbl_jobs_bookmark a where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND a.job_id = j.id ANd e.id = a.emp_id AND a.seeker_id = '".$_SESSION['jobseeker']['id']."' order by a.id desc";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 		
	 return $user_arr;
}

// Gets jobs seeker applied jobs for employers
function jobs_list_applicants()
{
	  global $db;
	 $user_query		=	"Select a.seeker_id as resume_user_id, e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j, tbl_jobs_applied a where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND a.job_id = j.id ANd e.id = a.emp_id AND a.emp_id = '".$_SESSION['employer']['id']."' order by a.id desc";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 		
	 return $user_arr;
}

// Gets jobs listing
function jobs_list_all()
{
	 global $db;
	 $user_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 order by id desc";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 		
	 return $user_arr;
}

// Gets jobs listing
function company_list()
{
	 global $db;
	 $user_query		=	"Select e.company_name,  e.image, j.employer_id from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 group by j.employer_id order by e.company_name asc";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 		
	 return $user_arr;
}

// Gets jobs listing
function jobs_detail($job_id)
{
	 global $db;
	 $user_query		=	"Select e.company_name, e.image, e.industry, e.mobile_no, e.address,  j.* from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND j.id = '$job_id' ";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);	 		
	 return $user_arr;
}

function jobs_list_count($emp_id)
{
	 global $db;
	 $user_query		=	"Select e.company_name, j.* from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND j.employer_id = '$emp_id' order by id desc";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 
	 $count_record = count($user_arr);		
	 return $count_record;
	 
	
}

// Email employer by id
function get_employer_by_id($id)
{
	 global $db;
	 $user_query		=	"Select verify_code, id, email, status from tbl_employer where  id = '".$id."'";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);
	 		
	 return $user_arr;
	
}

// Email template
function get_emailtemp($type)
{
	 global $db;
	 $user_query		=	"Select * from tbl_emails where type = '$type'";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);		
	 return $user_arr;
	
}

function get_admininfo()
{
	 global $db;
	 $user_query		=	"Select * from tbl_admin where Id= 1";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);		
	 return $user_arr;
	
}

function get_job_main_categories($parent_id)
{
	 global $db;
	 $query		=	"select * from tbl_categories where parent_id=$parent_id AND active_status = 1 order by  sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 return $list_arr;
	
}

function get_job_main_categories_list()
{
	 global $db;
	 $query		=	"select c.category_name, c.category_id, c.category_image from tbl_categories c, tbl_jobs j where c.category_id = j.job_category AND c.active_status = 1 AND j.job_status = 1 group by c.category_id order by  c.sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function get_job_main_sub_categories_list($id)
{
	 global $db;
	 $query		=	"select * from tbl_categories where parent_id=$id AND active_status = 1 group by category_id order by  sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function get_job_category_details($cat_id)
{
	 global $db;
	 $query		=	"select * from tbl_categories where 1=1 AND category_id = '$cat_id' order by  sortorder asc";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

// Get Expeience Level 
function get_job_expeience_level()
{
	 global $db;
	 $query		=	"select * from tbl_experience where status = 1 order by  sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

// Get Expeience Level 
function get_job_expeience_level_info($id)
{
	 global $db;
	 $query		=	"select * from tbl_experience where status = 1 AND exp_id = '$id'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function get_edit_job($id, $employer)
{
	 global $db;
	 $query		=	"select * from tbl_jobs where job_status = 1 AND id = '$id' AND employer_id = '$employer'";	
	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 
	 return $list_arr;
	
}

function get_job_salary_type()
{
	 global $db;
	 $query		=	"select * from tbl_jobs_salary_type where status = 1 order by  sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}


function get_emp_type()
{
	 global $db;
	 $query		=	"select * from tbl_emp_type where status = 1 order by  sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function get_emp_type_name($type)
{
	 global $db;
	 $query		=	"select * from tbl_emp_type where status = 1 AND emp_id = '$type'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function country_list()
{
	 global $db;
	 $query		=	"select * from tbl_countries where status = 1 order by  ordering asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function country_list_job()
{
	 global $db;
	 $query		=	"select c.* from tbl_countries c, tbl_jobs j where c.status = 1 AND j.job_status= 1 AND c.CountryId = j.job_country group by c.CountryId order by  c.ordering asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function country_name($country_id)
{
	 global $db;
	 $query		=	"select * from tbl_countries where status = 1 AND CountryId = '$country_id'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function job_country_list()
{
	 global $db;
	 $query		=	"select c.CountryId, c.Country from tbl_countries c, tbl_jobs j where c.status = 1 AND c.CountryId = j.job_country AND c.status = 1 AND j.job_status = 1 group by c.Country order by c.Country Asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function state_list($c_id)
{
	 global $db;
	 $query		=	"select * from tbl_state where CountryID = $c_id AND status = 1 order by  Region asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function job_state_list($c_id)
{
	 global $db;
	 $query		=	"select s.* from tbl_state s, tbl_jobs j where s.CountryID = $c_id AND s.status = 1 AND s.RegionID = j.job_state AND j.job_status = 1 group by s.RegionID  order by  s.Region asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function state_name($country_id, $state_id)
{
	 global $db;
	 $query		=	"select * from tbl_state where status = 1 AND CountryId = '$country_id' AND RegionID = '$state_id'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function city_list($s_id, $c_id)
{
	 global $db;
	 $query		=	"select * from tbl_city where CountryID = $c_id AND RegionID = '$s_id' order by  City asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function jobs_city_list($s_id, $c_id)
{
	 global $db;
	 $query		=	"select c.* from tbl_city c, tbl_jobs j where c.CountryID = $c_id AND c.RegionID = '$s_id' AND c.status = 1 AND c.CityId = j.job_city group by c.CityId  order by  c.City asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		 
	 
	 return $list_arr;
	
}


function city_name($country_id, $state_id, $city_id)
{
	 global $db;
	 
	 $query		=	"select * from tbl_city where CountryID = $country_id AND RegionID = '$state_id' AND CityId = '$city_id'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

// Insert Employer Job

function insert_job($emp_id, $jobs_list)
{
	 
	 global $db;
	  $sql_qry="insert into tbl_jobs set  employer_id = '".addslashes($emp_id)."', job_category = '".addslashes($jobs_list['job_category'])."', job_subcategory = '".addslashes($jobs_list['job_subcategory'])."', job_type = '".addslashes($jobs_list['jobtype'])."', job_title = '".addslashes($jobs_list['job_title'])."', job_description = '".addslashes($jobs_list['job_description'])."', job_country = '".addslashes($jobs_list['job_country'])."', job_state = '".addslashes($jobs_list['job_state'])."', job_city = '".addslashes($jobs_list['job_city'])."', job_salary_min = '".addslashes($jobs_list['job_salary_min'])."', job_salary_max = '".addslashes($jobs_list['job_salary_max'])."', negotiable = '".addslashes($jobs_list['negotiable'])."', job_salary_type = '".addslashes($jobs_list['job_salary_type'])."', job_experience_level = '".addslashes($jobs_list['job_experience_level'])."', job_function = '".addslashes($jobs_list['job_function'])."', job_status = 1, posted_date = '".date("Y-m-d H:i:s")."', expiry_date = '".$jobs_list['expiry_date']."'";		
		
	$sql =  $db->query($sql_qry);	// Query execute
	return $sql;	 
}

// Update Employer Job

function update_job($emp_id, $edit_id, $jobs_list)
{
	 
	 global $db;
	 $sql_qry="update  tbl_jobs set  job_category = '".addslashes($jobs_list['job_category'])."', job_subcategory = '".addslashes($jobs_list['job_subcategory'])."', job_type = '".addslashes($jobs_list['jobtype'])."', job_title = '".addslashes($jobs_list['job_title'])."', job_description = '".addslashes($jobs_list['job_description'])."', job_country = '".addslashes($jobs_list['job_country'])."', job_state = '".addslashes($jobs_list['job_state'])."', job_city = '".addslashes($jobs_list['job_city'])."', job_salary_min = '".addslashes($jobs_list['job_salary_min'])."', job_salary_max = '".addslashes($jobs_list['job_salary_max'])."', negotiable = '".addslashes($jobs_list['negotiable'])."', job_salary_type = '".addslashes($jobs_list['job_salary_type'])."', job_experience_level = '".addslashes($jobs_list['job_experience_level'])."', job_function = '".addslashes($jobs_list['job_function'])."', expiry_date = '".$jobs_list['expiry_date']."' where id = '$edit_id' AND employer_id = '$emp_id'";	
			
	$sql = $db->query($sql_qry);	// Query execute
	return $sql;
		 
}

// Delete employer job
function delete_job($emp_id, $id)
{
	 
	 global $db;
	  $sql_qry="delete from tbl_jobs where id = '$id' AND employer_id = '$emp_id'";	
	
			
	$sql = $db->query($sql_qry);	// Query execute
	return $sql;
		 
}

function delete_bookmark($seeker_id, $id)
{
	 
	 global $db;
	  $sql_qry="delete from tbl_jobs_bookmark where job_id = '$id' AND seeker_id = '$seeker_id'";	
	
			
	$sql = $db->query($sql_qry);	// Query execute
	return $sql;
		 
}



function date_time()
{
	$date  = date("Y-m-d H:i:s");
	return $date;
}

function change_dateformat($date)
{
	$date  = date("m-d-Y H:i A", strtotime($date));
	return $date;
}

// get job seeker by id
function get_seeker_by_id($id)
{
	 global $db;
	 $user_query		=	"Select * from tbl_job_seaker where  id = '".$id."'";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);
	 		
	 return $user_arr;
	
}

// get job seeker by id
function get_seeker_resume($id)
{
	 global $db;
	 $user_query		=	"Select * from tbl_job_seaker_resume where  user_id = '".$id."'";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);
	 		
	 return $user_arr;
	
}

function get_year($date)
{
	$date = strtotime($date);
	
	$year =  date("Y", $date);
	return $year;
}
	
// get job seeker work history
function get_seeker_working_history($id)
{
	 global $db;
	 $user_query		=	"Select * from tbl_job_seaker_work_history where  user_id = '".$id."'";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);
	 		
	 return $user_arr;
	
}


// get job seeker work history
function get_seeker_education_background($id)
{
	 global $db;
	 $user_query		=	"Select * from tbl_job_seaker_edu_background where  user_id = '".$id."'";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);
	 		
	 return $user_arr;
	
}

// get job seeker work history
function get_seeker_lanugage($id)
{
	 global $db;
	 $user_query		=	"Select * from tbl_job_seaker_language where  user_id = '".$id."'";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);
	 		
	 return $user_arr;
	
}

// get job seeker work history
function delete_record($user_id, $tbl_name)
{
	 global $db;
	 $user_query		=	"Delete from $tbl_name where  user_id = '".$user_id."'";	
	 $user_arr			=	$db->query($user_query);
	 return $user_arr;
	
}


// Delete seeker account
function delete_job_seeker()
{
	 
	 global $db;
	 $sql_qry="update  tbl_job_seaker set status = '2' where  id = '".$_SESSION['jobseeker']['id']."'";				
	 $sql = $db->query($sql_qry);	// Query execute
	 return $sql;
		 
}
// get social links by id
function get_social($id)
{
	 global $db;
	 $user_query		=	"Select facebook, twitter, linkedin, youtube from tbl_links where  	Id = '".$id."'";	
	 $user_arr			=	$db->get_row($user_query,ARRAY_A);
	 return $user_arr;
	
}

//get total jobs, company, candidates
function get_resources(){

	 global $db;
	 //total jobs
	$job_query =	"SELECT count(tbl_jobs.id) as total_jobs FROM `tbl_jobs`,`tbl_employer` WHERE tbl_employer.id=tbl_jobs.	employer_id and tbl_employer.status = 1 and tbl_jobs.job_status = 1";	
	 $job_count	=	$db->get_row($job_query,ARRAY_A);
	 $total[] = $job_count['total_jobs'];

	 //total employer
	 $employer_query =	"SELECT count(id) as total_employer FROM `tbl_employer` WHERE status = 1";	
	 $employer_count	=	$db->get_row($employer_query,ARRAY_A);
	 $total[] = $employer_count['total_employer'];
	 
	 //total jobseeker
	 $seekers_query =	"SELECT count(id) as total_seekers FROM `tbl_job_seaker` WHERE status = 1";	
	 $seekers_count	=	$db->get_row($seekers_query,ARRAY_A);
	 $total[] = $seekers_count['total_seekers'];	 
	
	return $total;	
}

//number format
function numberformat($value){
	return number_format($value,0,",",",");
}

//get cms pages
function get_cms($id){

	 global $db;
	 $query =	"SELECT * FROM `tbl_articles` WHERE id = '".$id."'";	
	 $arr	=	$db->get_row($query,ARRAY_A);
	return $arr;	
}

//get job exist
function job_applied_check($job_id){

	 global $db;
	 $query =	"SELECT * FROM `tbl_jobs_applied` WHERE job_id = '".$job_id."' AND seeker_id = '".$_SESSION['jobseeker']['id']."'";	
	 $arr	=	$db->get_row($query,ARRAY_A);
	return $arr;	
}

//get job exist
function job_applied_count($job_id){

	 global $db;
	 $query =	"SELECT * FROM `tbl_jobs_applied` WHERE job_id = '".$job_id."'";	
	 $arr	=	$db->get_results($query,ARRAY_A);
	return $arr;	
}


//get job exist
function job_bookmark_check($job_id){

	 global $db;
	 $query =	"SELECT * FROM `tbl_jobs_bookmark` WHERE job_id = '".$job_id."' AND seeker_id = '".$_SESSION['jobseeker']['id']."'";	
	 $arr	=	$db->get_row($query,ARRAY_A);
	return $arr;	
}

function get_faq()
{
	 global $db;
	 $user_query		=	"SELECT * FROM `tbl_faq` where faq_status = 1 order by sortorder ASC";	
	 $user_arr			=	$db->get_results($user_query,ARRAY_A);	 		
	 return $user_arr;
}

function get_min_price()
{
	 global $db;
	$query		=	"select MIN(j.job_salary_min) as minprice from tbl_categories c, tbl_jobs j where c.category_id = j.job_category AND c.active_status = 1 AND j.job_status = 1 group by c.category_id order by  c.sortorder asc";	
	 
	 $arr	=	$db->get_row($query,ARRAY_A);
	return $arr['minprice'];
}	


function get_max_price()
{
	 global $db;
	$query		=	"select MAX(j.job_salary_max) as maxprice from tbl_categories c, tbl_jobs j where c.category_id = j.job_category AND c.active_status = 1 AND j.job_status = 1 group by c.category_id order by  c.sortorder asc";	
	 
	 $arr	=	$db->get_row($query,ARRAY_A);
	return $arr['maxprice'];
}	
?>