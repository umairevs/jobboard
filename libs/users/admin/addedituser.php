<?php
//Check access of module
include("security_module.php");
?>
<script src="js/ajax.js" type="text/javascript" ></script>
<?php 
if(isset($_GET['u']))
{
	$sql = "select * from tbl_users where id='".$_GET['u']."'";
	$rsUserEdit= mysql_query($sql) or die(mysql_error());
	$rowUserEdit = mysql_fetch_array($rsUserEdit);
	
	$userId 	= $rowUserEdit['id'];
	$full_name 	= stripslashes($rowUserEdit['fname']);
	$username 	= stripslashes($rowUserEdit['lname']);
	$phone 		= stripslashes($rowUserEdit['phone']);	
	$birth_date = stripslashes($rowUserEdit['birth_date']);
	$useremail 	= stripslashes(trim($rowUserEdit['email']));
	/*$userpass = stripslashes($rowUserEdit['password']);*/
	$userstatus = stripslashes($rowUserEdit['status']);
	
	$address_type 	= stripslashes($rowUserEdit['address_type']);
	$building_name 	= stripslashes($rowUserEdit['building_name']);
	$unit_number 	= stripslashes($rowUserEdit['unit_number']);
	$address 		= stripslashes($rowUserEdit['address']);
	$city 			= stripslashes($rowUserEdit['city']);
	$zipcode		= stripslashes($rowUserEdit['zipcode']);
	$state 			= stripslashes($rowUserEdit['state']);
	$country 		= stripslashes($rowUserEdit['country']);
	
}
?>

<table width="100%" >
	<tr>
		<td class="top-bar"><div style="float:left">Update User</div>
			<div style="float:right; text-align:right; width:100px;  padding-right:20px;">
				<label onclick="history.go(-1)" title="Click here to Back">Back</label>
			</div></td>
	</tr>
	<?php if ( isset ($_SESSION['msgUpdate'] ) ) {?>
	<tr>
		<td class="msg" align="center"><?php echo  $_SESSION['msgUpdate']; unset($_SESSION['msgUpdate']); ?></td>
	</tr>
	<?php } ?>
</table>
<form method="post" action="home.php?p=process&q=adduser&action=update&mod=<?php echo $mod;?>" enctype="multipart/form-data">
	<input type="hidden" name="userid" value="<?php echo $userId;?>">
	<table width="85%"  border="0" cellpadding="5" cellspacing="5">
		<?php if ( isset ($_SESSION['sesErr']) ) {?>
		<tr>
			<th colspan="4" style="color:red; padding-left:180px;"> <div class="notification_error1" style="color:red;" align="left">
					<?php foreach ($_SESSION['sesErr'] as $k => $v) { echo $v ."<br>";} 
		?>
				</div>
			</th>
		</tr>
		<?php }if ( isset ($_SESSION['addmsg']) ) { ?>
		<tr>
			<th colspan="4" style="color:red;" ><span class="notification_error1" style="color:red;"><?php echo $_SESSION['addmsg']?> </span></th>
		</tr>
		<?php }?>
		<tr>
			<td align="right" width="22%" class="td">First Name:<span style="color:#FF0000">*</span></td>
			<td id="txtlebel" width="23%"><input type="text" placeholder="First Name" class="text_box2"  name="full_name" value="<?php echo $full_name; ?>"  style="width:215px; height:22px;"/></td>
			<td align="right" width="14%" class="td">Last Name:<span style="color:#FF0000">*</span></td>
			<td id="txtlebel" width="41%"><input type="text" placeholder="Last Name" class="text_box2"  name="username" value="<?php echo $username; ?>"  style="width:215px; height:22px;"/></td>
		</tr>
		<tr>
			<td align="right" class="td">Email Address:<span style="color:#FF0000">*</span></td>
			<td><input name="email"  type="text" placeholder="Email Address" class="text_box2" id="email" value="<?php echo $useremail; ?>" style="width:215px; height:22px;"/></td>
			<td align="right" class="td">&nbsp;</td>
			<td>&nbsp;</td>

		</tr>
		<tr>
			<td align="right" class="td">Mobile Number:<span style="color:#FF0000">*</span></td>
			<td><input type="text" placeholder="Mobile Number" class="text_box2"  name="phone" value="<?php echo $phone; ?>" style="width:215px; height:22px;"/></td>
			<td align="right" class="td"  style="display:none;">Date of Birth:<span style="color:#FF0000">*</span></td>
			<td id="contrydiv" style="display:none;"><input type="text" placeholder="Date of Birth (yyyy-mm-dd)" class="text_box2"  name="birth_date" value="<?php echo $birth_date; ?>" style="width:215px; height:22px;"/></td>
		</tr>
		<tr>
			<td align="right" class="td">&nbsp;</td>
			<td colspan="3">&nbsp;</td>
		</tr>
		<!--<tr>
			<td align="right" class="td">Address Types:</td>
			<td colspan="3">
				<input type="radio" name="address_type" id="address_type" value="1" <?php if($address_type == "1"){?> checked="checked" <?php }?> /> Resident 
				<input type="radio" name="address_type" id="address_type" value="2" <?php if($address_type == "2"){?> checked="checked" <?php }?> /> Business 
				<input type="radio" name="address_type" id="address_type" value="3" <?php if($address_type == "3"){?> checked="checked" <?php }?> /> Hotel 
				<input type="radio" name="address_type" id="address_type" value="4" <?php if($address_type == "4"){?> checked="checked" <?php }?> /> Other 
			</td>
		</tr>
		<tr>
			<td align="right" class="td">Block, Unit No & Lorong:<span style="color:#FF0000">*</span></td>
			<td><input type="text" placeholder="Block, Unit No & Lorong" class="text_box2"  name="building_name" value="<?php echo $building_name; ?>" style="width:215px; height:22px;"/></td>
			<td align="right" class="td">Road Name:</td>
			<td id="contrydiv"><input type="text" placeholder="Road Name" class="text_box2"  name="unit_number" value="<?php echo $unit_number; ?>" style="width:215px; height:22px;"/></td>
		</tr>
		<tr>
			<td align="right" class="td">Street Address:<span style="color:#FF0000">*</span></td>
			<td colspan="3"><input type="text" placeholder="Street Address" class="text_box2"  name="address" value="<?php echo $address; ?>" style="width:595px; height:22px;"/></td>
		</tr>-->
		<tr>
			<td align="right" class="td">City:</td>
			<td><input type="text" placeholder="City" class="text_box2"  name="city" value="<?php echo $city; ?>" style="width:215px; height:22px;"/></td>
			<td align="right" class="td">Postal Code:</td>
			<td id="contrydiv"><input type="text" placeholder="Postal Code" class="text_box2"  name="zipcode" value="<?php echo $zipcode; ?>" style="width:215px; height:22px;"/></td>
		</tr>
		<tr>
			<td align="right" class="td">State:</td>
			<td><input type="text" placeholder="State" class="text_box2"  name="state" value="<?php echo $state; ?>" style="width:215px; height:22px;"/></td>
			<td align="right" class="td">Country:</td>
			<td id="contrydiv"><input type="text" placeholder="Country" class="text_box2"  name="country" value="<?php echo $country; ?>" style="width:215px; height:22px;"/></td>
		</tr>
		<tr>
			<td align="right" class="td">Status:</td>
			<td colspan="3"><select name="status"  tabindex="11" class="topsearch input_fldsel_whole" style="width:218px; height:22px;" >
					<option <?php if($userstatus == "a"){?> selected="selected" <?php }?> value="a">Active</option>
					<option <?php if($userstatus == "s"){?> selected="selected" <?php }?> value="s">Suspended</option>
					<option <?php if($userstatus == "p"){?> selected="selected" <?php }?> value="p">Pending</option>
				</select></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><input type="hidden" name="userId" value="<?php echo $userId ?>">
				<br />
				<input  type="image" src="img/-btn_save.gif" name="update" />
				</td>
		</tr>
	</table>
</form>
<?php
				unset($_SESSION['updatemsg']);
				unset($_SESSION['sesErr']);
				unset($_SESSION['regUser']);
				?>
