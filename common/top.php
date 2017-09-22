<?php 
//ob_start(sanitize_output);
@session_start();
error_reporting(0);

header("Pragma: no-cache");
header("Cache-Control: no-cahce");
header( "Expires: Mon, 08 Oct 1997 03:00:00 GMT" );
header( "Cache-Control: no-store,no-cache, must-revalidate" );
header( "Cache-Control: post-check=0, pre-check=0", FALSE);
header( "Pragma: no-cache" );


	
// Configuration file //
	include_once(dirname(__FILE__).'/config.php');
	
// Common connection class //
	include_once(dirname(__FILE__).'/conn.php');
	// encryption code file //

	include_once(dirname(__FILE__).'/libmail.php');

	///functions///
//	include_once(dirname(__FILE__).'/functions.php');

$current_File = $_SERVER["SCRIPT_NAME"];
$file_parts = Explode('/', $current_File);
$current_File = $file_parts[count($file_parts) - 1];
$site_name = $file_parts[1];

if($current_File!='job-list.php')
{
	unset($_SESSION['search']);
	unset($_SESSION['search_query']);
	unset($_SESSION['search_query_left']);
}
?>