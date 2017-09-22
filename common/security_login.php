<?php
	if(!isset($_SESSION['employer']))
	{
		?>
        <script type="text/javascript">
			window.location.href  = "<?php echo SERVER_ROOTPATH;?>welcome";
		</script>
		<?php				
		exit;
	}
?>