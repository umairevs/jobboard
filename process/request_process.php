<?php
include("common/topfile.php");
include("common/upload.php");
if(isset($_REQUEST['calling']) && !empty($_REQUEST['calling']) && $_REQUEST['calling']!="")
{
	switch($_REQUEST['calling'])
	{
		case '1':

			include(dirname(__FILE__)."/process/get_states_process.php");

		break;

		case '2':

			include(dirname(__FILE__)."/process/get_cities_process.php");

		break;		

		

		case '3':

			include(dirname(__FILE__)."/process/register_jobSeeker_process.php");

		break;	

		

		case '4':

			include(dirname(__FILE__)."/process/add_crm_manager_process.php");

		break;	

		

		case '5':

			include(dirname(__FILE__)."/process/js_validation_code_process.php");

		break;	

		

		case '6':

			include(dirname(__FILE__)."/process/js_resend_validation_code_process.php");

		break;

		

		

		case '7':

			include(dirname(__FILE__)."/process/crm_validation_code_process.php");

		break;	

		

		case '8':

			include(dirname(__FILE__)."/process/crm_resend_validation_code_process.php");

		break;

		

		case '9':

			include(dirname(__FILE__)."/process/js_login_process.php");

		break;

		

		case '10':

			include(dirname(__FILE__)."/process/crm_login_process.php");

		break;

		

		case '11':

			include(dirname(__FILE__)."/process/contact_us_process.php");

		break;

		

		case '12':

			include(dirname(__FILE__)."/process/add_js_contact_process.php");

		break;

		

		case '13':

			include(dirname(__FILE__)."/process/add_job_process.php");

		break;

		

		case '14':

			include(dirname(__FILE__)."/process/js_del_contact_process.php");

		break;

		

		case '15':

			include(dirname(__FILE__)."/process/crm_del_contact_process.php");

		break;

		

		case '16':

			include(dirname(__FILE__)."/process/add_crm_contact_process.php");

		break;

		

		case '17':

			include(dirname(__FILE__)."/process/save_question_temp_options_process.php");

		break;

		

		case '18':

			include(dirname(__FILE__)."/process/delete_question_temp_options_process.php");

		break;

		

		case '19':

			include(dirname(__FILE__)."/process/edit_crm_manager_process.php");

		break;	

		

		case '20':

			include(dirname(__FILE__)."/process/add_js_resume_process.php");

		break;	

		

		case '21':

			include(dirname(__FILE__)."/process/delete_question_options_process.php");

		break;	

		

		case '22':

			include(dirname(__FILE__)."/process/js_del_resume_process.php");

		break;

		

		case '23':

			include(dirname(__FILE__)."/process/js_default_resume_process.php");

		break;

		

		case '24':

			include(dirname(__FILE__)."/process/delete_complete_question_process.php");

		break;

		

		case '25':

			include(dirname(__FILE__)."/process/save_question_options_process.php");

		break;

		

		case '26':

			include(dirname(__FILE__)."/process/js_forgot_password_process.php");

		break;

		

		case '27':

			include(dirname(__FILE__)."/process/change_job_status_process.php");

		break;

		

		case '28':

			include(dirname(__FILE__)."/process/change_job_status_frm_process.php");

		break;

		

		case '29':

			include(dirname(__FILE__)."/process/job_apply_process.php");

		break;

		

		case '30':

			include(dirname(__FILE__)."/process/add_basket_process.php");

		break;

		

		case '31':

			include(dirname(__FILE__)."/process/invite_friends_process.php");

		break;

		

		case '32':

			include(dirname(__FILE__)."/process/invite_friend_for_job_process.php");

		break;

		

		case '33':

			include(dirname(__FILE__)."/process/js_del_basket_process.php");

		break;

		

		case '34':

			include(dirname(__FILE__)."/process/js_del_applied_job_process.php");

		break;

		

		case '35':

			include(dirname(__FILE__)."/process/add_basket_multiple_process.php");

		break;

		

		case '36':

			include(dirname(__FILE__)."/process/job_multiple_apply_process.php");

		break;

		

		case '37':

			include(dirname(__FILE__)."/process/job_duration_process.php");

		break;

		

		case '38':

			include(dirname(__FILE__)."/process/emp_post_job_extend_expiry_process.php");

		break;

		

		case '39':

			include(dirname(__FILE__)."/process/emp_resume_url_process.php");

		break;

		

		case '40':

			include(dirname(__FILE__)."/process/emp_resume_url_validate_process.php");

		break;

		

		case '41':

			include(dirname(__FILE__)."/process/emp_del_resume_process.php");

		break;

		

		case '42':

			include(dirname(__FILE__)."/process/emp_delete_all_resumes_process.php");

		break;

		

		case '43':

			include(dirname(__FILE__)."/process/emp_hire_jobseeker_process.php");

		break;

		

		case '44':

			include(dirname(__FILE__)."/process/emp_reject_jobseeker_process.php");

		break;

		

		case '45':

			include(dirname(__FILE__)."/process/emp_shortlist_jobseeker_process.php");

		break;

		

		case '46':

			include(dirname(__FILE__)."/process/update_jobSeeker_process.php");

		break;

		

		case '47':

			include(dirname(__FILE__)."/process/emp_interview_process.php");

		break;

		

		case '48':

			include(dirname(__FILE__)."/process/js_emailto_contact_process.php");

		break;

		

		case '49':

			include(dirname(__FILE__)."/process/update_job_review_process.php");

		break;

		

		case '50':

			include(dirname(__FILE__)."/process/emp_emailto_contact_process.php");

		break;

		

		case '51':

			include(dirname(__FILE__)."/process/js_interview_answer_process.php");

		break;

		

		case '52':

			include(dirname(__FILE__)."/process/search_js_contacts_process.php");

		break;

		

		case '53':

			include(dirname(__FILE__)."/process/search_emp_contacts_process.php");

		break;

		

		case '54':

			include(dirname(__FILE__)."/process/js_follow_company_process.php");

		break;

		

		case '55':

			include(dirname(__FILE__)."/process/js_unfollow_company_process.php");

		break;

		

		case '56':

			include(dirname(__FILE__)."/process/js_add_cart_process.php");

		break;

		

		case '57':

			include(dirname(__FILE__)."/process/js_contacts_sorting.php");

		break;

		

		case '58':

			include(dirname(__FILE__)."/process/js_add_contact_note_process.php");

		break;

		

		case '59':

			include(dirname(__FILE__)."/ordering_process/js_saved_company_ordering.php");

		break;

		

		case '60':

			include(dirname(__FILE__)."/process/crm_manager_add_team_process.php");

		break;

		

		case '61':

			include(dirname(__FILE__)."/process/crm_manager_edit_team_process.php");

		break;	

		

		case '62':

			include(dirname(__FILE__)."/process/emp_change_member_status_process.php");

		break;	

		

		case '63':

			include(dirname(__FILE__)."/process/emp_change_member_password_process.php");

		break;

		

		case '64':

			include(dirname(__FILE__)."/process/get_search_states_process.php");

		break;

		case '65':

			include(dirname(__FILE__)."/process/get_search_cities_process.php");

		break;	

		

		case '66':

			include(dirname(__FILE__)."/process/emp_rights_team_process.php");

		break;

		

		case '67':

			include(dirname(__FILE__)."/process/js_message_logs_process.php");

		break;

		

		case '68':

			include(dirname(__FILE__)."/process/emp_message_logs_process.php");

		break;

		

		case '69':

			include(dirname(__FILE__)."/process/emp_add_contact_note_process.php");

		break;

		

		case '70':

			include(dirname(__FILE__)."/process/emp_add_job_notes_process.php");

		break;

		

		case '71':

			include(dirname(__FILE__)."/process/js_email_alert_process.php");

		break;

		

		case '72':

			include(dirname(__FILE__)."/process/js_sent_email_process.php");

		break;

		

		case '73':

			include(dirname(__FILE__)."/process/inbox_message_delete_process.php");

		break;

		

		case '74':

			include(dirname(__FILE__)."/process/outbox_message_delete_process.php");

		break;

		

		case '75':

			include(dirname(__FILE__)."/process/emp_sent_email_process.php");

		break;

		

		case '76':

			include(dirname(__FILE__)."/process/feedback_users_admin_process.php");

		break;

		

		case '77':

			include(dirname(__FILE__)."/process/emp_current_member_password_process.php");

		break;

		

		case '78':

			include(dirname(__FILE__)."/process/add_js_reminder_process.php");

		break;

		

		case '79':

			include(dirname(__FILE__)."/process/set_job_prority_process.php");

		break;

		

		case '80':

			include(dirname(__FILE__)."/process/add_referrals_process.php");

		break;

		

		case '81':

			include(dirname(__FILE__)."/process/get_local_search_cities.php");

		break;

		

		case '82':

			include(dirname(__FILE__)."/process/get_local_search_state.php");

		break;

		

		case '83':

			include(dirname(__FILE__)."/process/unset_local_search_cities.php");

		break;

		

		case '84':

			include(dirname(__FILE__)."/process/unset_local_search_state.php");

		break;

		case '85':

			include(dirname(__FILE__)."/process/post_draft_job_process.php");

		break;

		

		case '86':

			include(dirname(__FILE__)."/process/update_job_prority_process.php");

		break;

	}

}
exit;
?>