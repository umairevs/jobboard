<?php
//have to set the code status equal to 25
date_default_timezone_set("America/New_York"); 
$set_error = 0;
if($set_error=="0"){
	error_reporting(E_ALL);
	ini_set('display_errors', FALSE);
	ini_set('display_startup_errors', FALSE);
}else{
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
}
// Database Info
$mosConfig_host 			=	'localhost';
$mosConfig_user 			=	'';
$mosConfig_db 				=	'';
$mosConfig_password 		=	'';


// URl and Path var
$mosConfig_docroot 			=	$_SERVER['DOCUMENT_ROOT'];
$mosConfig_live_site 		=	'http://'.$_SERVER['HTTP_HOST'].'/jobboard/';
$mosConfig_live_site_admin 	=	'http://'.$_SERVER['HTTP_HOST'].'/jobboard/admin/';
$mosConfig_cur_url 			=	'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$ru					 		=	'http://'.$_SERVER['HTTP_HOST'].'/jobboard/';
//$mosConfig_absolute_path 	=	'/opt/lampp/htdocs/projects/';
$mosConfig_absolute_path 	=	'';

// Upload files directories
$retailer_images 			= "media/retailer_images/";
$agreement_files 			= "media/agreement_files/";
$proof_lease_files 			= "media/proof_lease_files/";
$users_images 				= "media/users_images/";

define('SERVER_PATH',$mosConfig_live_site);
define('PRAYER_ADMIN_SERVER_PATH', $mosConfig_live_site_admin);
define( '_JEVS', 1 );
$ruAdmin					=	$mosConfig_live_site_admin;

// Default date & time
$cur_date 		= date('Y-m-d');
$cur_time 		= date('H:i:s a');
$cur_day 		= strtolower( date('D') );
$cur_day_c 		= ucfirst( date('l') );

$curr_date_time = date("Y-m-d H:i:s");

$site_title 		= "jobboard";
$mosConfig_limit 	=	'10'; // for default page limit
$currency_symble 	= '$';

$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December',);

// Escrow.com setting
$PartnerID 			= '11003';
$escrow_userpwd 	= "tolga.habip@inflectioncapital.net:escrowth1234A";
?>
