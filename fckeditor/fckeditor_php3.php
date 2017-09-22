<?php 


	include("../config/conndb.php");


	

	$query = mysql_query("SELECT * FROM tbl_admin");  
	$row = mysql_fetch_array($query);
	echo $row['name'];
	echo $row['pass'];



?>