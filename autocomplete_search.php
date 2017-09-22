<?php
include("common/top.php");


/*
    $host = 'localhost';
$username = 'evsof3_evs';
$pass = 'evs@2o11';
$Dbname = 'jobboard';
//connect with the database
$db = new mysqli($host,$username,$pass,$Dbname);   */
//get search term

$searchTerm = $_GET['term'];
	$query = "SELECT * FROM tbl_jobs WHERE job_title LIKE '%".$searchTerm."%' group by job_title";
$list_jobs	=	$db->get_results($query,ARRAY_A);
	


if($list_jobs)
				 {   					
					foreach($list_jobs as $row_info)
					{
						 $data[] = $row_info['job_title'];
					}
					}
	
//return json data
echo json_encode($data);
	
?>