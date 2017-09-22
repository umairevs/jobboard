<?php 	
		session_start();
		session_destroy();
		$msg=base64_encode('Admin logged out successfully !');
		header('location:index.php?msg='.$msg);
?>