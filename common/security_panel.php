<?php
if($_SESSION[LOGIN_SESSION_ARRAY]['USER_ID']=='')
{
	?>
  <script type="text/javascript">
	alert("Please login to your account panel first");
	window.location.href  = "<?php echo SERVER_ROOTPATH;?>login";
  </script>
<?php		
	exit;	
}
?>
