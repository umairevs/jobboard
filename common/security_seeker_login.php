<?php
	
	if(!isset($_SESSION['jobseeker']))
	{
		?>
        <script type="text/javascript">
			window.location.href  = "<?php echo SERVER_ROOTPATH;?>";
		</script>
		<?php				
		exit;
	}
?>