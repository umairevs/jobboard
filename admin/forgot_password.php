<?php
	session_start();	
	ini_set('error_reporting', 0);
	if (  $_SESSION['adminLogin_vt'] == 'True' )	{	
 		
		header("location:home.php");
	} else{
		session_destroy();
	}
	
	
	if (isset ( $_REQUEST['msg']))  
	$msg = base64_decode( $_REQUEST['msg'] );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
.style2 {
	font-size: 12px;
	color: #BC1F03;
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
}
.style3 {
	font-size: 12px;
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#errormsg {
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size : 14px;
	color : #c30;
	text-align: center;
}
.readmore_btn {
	text-transform: uppercase;
	color: #fff;
	background: none;
	font-size: 14px;
	background: #2771B7;
	padding: 10px;
	width: 100px;
	margin-top: 6px;
	float: left;
	text-align: center;
	-webkit-transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out;
	-o-transition: all 0.5s ease-in-out;
	transition: all 0.5s ease-in-out;
}
.readmore_btn:hover {
	background: #7F7F7F;
	-webkit-transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out;
	-o-transition: all 0.5s ease-in-out;
	transition: all 0.5s ease-in-out;
	cursor: pointer;
}
-->
</style>
<link type="text/css" rel="stylesheet" href="css/style.css">
<head>
<title>EVS Admin Control Panel</title>
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff" style="height:100%">
<Div style="height:100px;"></Div>
<table width="571" border="0" cellspacing="0" cellpadding="0" align="center" >
	
	<tr>
		<td align="right" >&nbsp;</td>
		<td align="left" valign="top" style=" border:2px solid #333" ><table  width="100%" height="157" align="center" bgcolor="#ffffff">
				<tr  >
					<td colspan="4" align="center" id="errormsg"><?php echo $msg; ?></td>
				</tr>
				<form name="sendpassword" method="post" action="forget_authenticate.php" >
					<tr>
						<td>&nbsp;</td>
						<td align="center" colspan="3"><span style="font-size:18px; font-weight:bold; font-family:Arial; color:#333333">Welcome To  Admin Control Pannel</span><br>
							<span style="color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;" >Forgot Password </span></td>
					</tr>
					<tr >
						<td></td>
						<td >&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td width="7" height="37" align="center">&nbsp;</td>
						<td width="129" align="center" ><span class="style2" style="color:#000000">Email:</span></td>
						<td width="170"><input name="name" type="text" class="style3" id="name" style="width:180px; border:1px solid #CCCCCC" maxlength="50" ></td>
						<td width="111"></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td align="center"><a href="index.php" style="color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px;">Back</a></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td align="center">
						<input type="image" name="sendpassword" value="Send" class="readmore_btn">
						<input name="mode" type="hidden" id="mode" value="forgetpassword">
						</td>
						<td></td>
					</tr>
					<tr height="25" >
						<td colspan="4" ></td>
					</tr>
				</form>
			</table>
			
			<!--# Form Ends Here--></td>
		<td align="left" >&nbsp;</td>
	</tr>
	
</table>
</body>
</html>