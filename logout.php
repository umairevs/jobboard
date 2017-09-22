<?php 
include("common/top.php");
unset($_SESSION['employer']);
unset($_SESSION['jobseeker']);
header("location:".SERVER_ROOTPATH);
exit;
?>