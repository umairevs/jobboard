<?php
	session_start();
	ini_set('error_reporting', 0);
	include ('../config/conndb.php');
	defined('_JEVS') or die('Restricted access');
	include('../includes/functions/functions.php');
	createTable('admin');
	if($_SESSION['adminLogin_vt'] == 'True' )	
	{	
	 header("location:home.php");
	} else{
	   session_destroy();
	}
	if (isset($_REQUEST['msg']))  
	$msg = base64_decode( $_REQUEST['msg'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="icon" type="image/png" href="../<?php echo $mosConfig_favicon; ?>"  />
<link type="text/css" rel="stylesheet" href="css/style.css">
<style type="text/css">
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
.bg {
	/*
	background: url(../images/transpirent_bg.png) repeat;
	border: 1px solid #11255a;
	box-shadow: inset 0px 1px 1px #ffffff;
	*/
	width: 500px;
	padding: 10px;
	
	float: none;
	margin: 100px auto;
}
.table_sigin {
	background-color: #ffffff;
	border-radius: 0;
	;
 background-image:;
	background-position: bottom left;
	background-repeat: repeat-x;
}
.inputs {
	border-radius: 0px;
	border: 1px solid #cacaca;
	padding: 6px;
	background-color: transparent;
	width: 210px;
	/*border:none;*/
	/*border:1px solid #CCC;*/
	color: #cacaca;
	height: 20px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	-webkit-transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out;
	-o-transition: all 0.5s ease-in-out;
	transition: all 0.5s ease-in-out;/*border:1px solid  #CCCCCC;*/
}
.inputs:focus {
	border: 1px solid #2771B7;
	color: #2771B7;
	-webkit-transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out;
	-o-transition: all 0.5s ease-in-out;
	transition: all 0.5s ease-in-out;
}
.centered {
	position: absolute;
}
</style>
<head>
<title>Admin Control Panel</title>
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff" >
<div class="bg">
	<div align="center">
		<table width="500px" border="0" cellspacing="0" cellpadding="2" class="table_sigin">
			<tr>
				<td valign="top" align="center">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" valign="top"><!--# Login Page Starts Here-->
					
					<table width="300"  border="0" cellspacing="0" cellpadding="0" align="center">
						<tr>
							<td width="1%" align="center" valign="top" style=""><table width="420" border="0" cellspacing="0" cellpadding="0" align="center">
									
									<tr>
										<td align="right" >&nbsp;</td>
										<td align="left" valign="top"><!--# Form Starts Here-->
											<form method="post" action="dologin.php"  enctype="multipart/form-data">
												<input  type="hidden" name="login" value="login" />
												<table width="100%" border="0" cellspacing="0" cellpadding="2">
													<tr>
														<td height="28" colspan="3" align="center" valign="middle" class=""><img src="img/logo1.png" height="100"></td>
													</tr>
													<tr>
														<td height="28" colspan="3" align="center" valign="middle" class="txt"  style="color:#a60606"><strong> <span style="font-size:18px; font-family:Arial; color:#2771B7">Welcome To  Admin Control Panel</span> 
														<!--<img border="0" src="../images/logo.png">--><br>
															<br>
															<?php
	if(isset($_GET['msg'])){
		echo $msg; 
	}else{
	?>
															<?php
	}
	?>
															</strong></td>
												  </tr>
													<tr>
														<td width="7%" height="28" align="right" valign="middle" class="txt" style="color:#fff ; padding-left:10px;">&nbsp;</td>
														<td width="28%" align="left" valign="middle" class="txt" style="color:#fff ; padding-left:10px;"><span class="txt" style="color:#000 ; padding-left:10px;">Username:</span></td>
														<td width="65%" height="28" align="left" valign="middle"><input name="name" type="text" class="fields inputs" id="name" tabindex="2"></td>
													</tr>
													<tr>
														<td height="28" align="right" valign="middle" class="txt" style="color:#fff; padding-left:10px;">&nbsp;</td>
														<td height="28" align="left" valign="middle" class="txt" style="color:#fff; padding-left:10px;"><span class="txt" style="color:#000; padding-left:10px;">Password:</span></td>
														<td height="28" align="left" valign="middle"><input name="password" type="password"  class="fields inputs" id="password" tabindex="2" value=""></td>
													</tr>
													<tr style="display:none;">
														<td width="7%" height="28" align="right" valign="middle" class="txt" style="color:#fff ; padding-left:10px;">&nbsp;</td>
														<td width="28%" align="left" valign="middle" class="txt" style="color:#fff ; padding-left:10px;"><span class="txt" style="color:#000 ; padding-left:10px;">Security code:</span></td>
														<td width="65%" height="28" align="left" valign="middle"><img src="../includes/CaptchaSecurityImages.php?width=200&height=30&character=5" style="border: 1px dotted #808080" /></td>
													</tr>
													<!--<tr>
                        <!--<td height="28" align="right" valign="middle" class="txt" style="color:#fff; padding-left:10px;">&nbsp;</td>-->
													
													<tr style="display:none;">
														<td width="7%" height="28" align="right" valign="middle" class="txt" style="color:#fff ; padding-left:10px;">&nbsp;</td>
														<td width="28%" align="left" valign="middle" class="txt" style="color:#fff ; padding-left:10px;"><span class="txt" style="color:#000 ; padding-left:10px;">Verify code:</span></td>
														<td width="65%" height="28" align="left" valign="middle"><input name="pincode" type="text" class="fields inputs" id="pincode" tabindex="2" value=""></td>
													</tr>
													<tr>
														<td height="28" colspan="2">&nbsp;</td>
														<td height="38" align="left" ><input name="mode" type="hidden" id="mode" value="login">
															<input type="image"  name="login" value="Login" class="readmore_btn">
															&nbsp;&nbsp; <a href="forgot_password.php" style="text-decoration:none; float:left; vertical-align:text-top; color:#000;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px; margin-top: 2px; font-weight:bold; display:"> &nbsp;&nbsp;Forget Password?</a></td>
													</tr>
												</table>
											</form>
											
											<!--# Form Ends Here--></td>
										<td align="left">&nbsp;</td>
									</tr>
									<tr>
										<td align="right"></td>
										<td align="left" >&nbsp;</td>
										<td align="left"></td>
									</tr>
									<tr>
										<td align="right"></td>
										<td align="left" >&nbsp;</td>
										<td align="left"></td>
									</tr>
								</table></td>
						</tr>
					</table>
					
					<!--# Login Page Ends Here--></td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>