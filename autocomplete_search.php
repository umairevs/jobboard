<?php
include("common/top.php");
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
echo json_encode($data);
	
?>