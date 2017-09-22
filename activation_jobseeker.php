<?php
include("common/top.php");
include("common/functions.php");



$user_id 	= base64_decode($_REQUEST['user_id']);
$verify_code	= $_REQUEST['code'];

$show_seeker_info	=	get_seeker_by_id($user_id);


if(isset($show_seeker_info))
{
	
	if($show_seeker_info['verify_code']==$verify_code)
	{
		 $sql_qry="update  tbl_job_seaker set  verify_code = '', status = '1' where id = '$user_id' AND verify_code = '$verify_code'";			
		 $db->query($sql_qry);	// Query execute
		
		?>
        <script type="text/javascript">
			alert("Your account activated successfully. Please login to your job seeker account");
			window.location.href = "<?php echo SERVER_ROOTPATH;?>signin";
		</script>
        <?php
		exit;
	}
	else
	if($show_seeker_info['verify_code']=='')
	{
		?>
        <script type="text/javascript">
			alert("You already activate your account");
			window.location.href = "<?php echo SERVER_ROOTPATH;?>signin";
		</script>
        <?php
		exit;
	}
	else
	if($show_seeker_info['verify_code']!=$verify_code)
	{
		?>
        <script type="text/javascript">
			alert("Account verification code is not valid");
			window.location.href = "<?php echo SERVER_ROOTPATH;?>signin";
		</script>
        <?php
		exit;
	}
	
	
}
else
{
	?>
        <script type="text/javascript">
			window.location.href = "<?php echo SERVER_ROOTPATH;?>signin";
		</script>
        <?php
}
?>