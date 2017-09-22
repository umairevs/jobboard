<?php 
    defined('_JEVS') or die('Restricted access');

	createTable('meta'); // create table if not exist
    
	
	$qry	= "Select * from tbl_admin";
	$rs		= mysql_query( $qry );
	$row	= mysql_fetch_array($rs); 
	
	$hid_logo	= mysql_query("Select * from tbl_metaInfo");
	$row_hid	= mysql_fetch_array($hid_logo);
	
	$qry_link 	= "Select * from tbl_links";
	$rs_link	= mysql_query( $qry_link );
	$row_link	= mysql_fetch_array($rs_link); 
	
?>

<table width="100%" >
	<tr class="rowtitle">
		<td class="top-bar" ><div style="float:left">Update Admin Preference</div>
			<div style="width:300px; color:#98F0FF; float:left; padding-left:150px;">
				<?php if ( isset ($_SESSION['msgUpdate'] ) ) 
{
echo  $_SESSION['msgUpdate']; unset($_SESSION['msgUpdate']); 
} 
?>
			</div></td>
	</tr>
	<tr>
		<td class="msg" align="center"></td>
	</tr>
</table>
<div class="tracking_box" style="padding-top:0px">
	<form method="post" name="f2" action="updateadmin.php" >
		<table cellpadding="0" cellspacing="5" border="0"   width="100%" >
			<TR class="rowtitle">
				<TD colspan="3" class="top-bar"> Admin Profile</TD>
			</TR>
			<TR>
				<td width="117">&nbsp;</td>
				<TD width="193" ><span class="style3">First&nbsp;Name&nbsp;</span></TD>
				<TD width="884"><INPUT   maxLength="50" size="45" name="pf_fn" id="pf_fn" class="text_box2"  value="<?php echo $row[fname]?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';"/></TD>
			</TR>
			<TR>
				<td width="117">&nbsp;</td>
				<TD height="23" ><span class="style3"> Last&nbsp;Name</span></TD>
				<TD  class=tableCellTwo  ><INPUT   maxLength="50" size="45"  class="text_box2"  name="pf_ln" id="pf_ln"  value="<?php echo $row[lname]?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" /></TD>
			</TR>
			<TR>
				<td width="117">&nbsp;</td>
				<TD height="23"  ><span class="style3"> Email&nbsp;Address</span></TD>
				<TD  class=tableCellTwo  ><INPUT   maxLength="50" class="text_box2"  size="45" name="pf_email" id="pf_email"  value="<?php echo $row[email]?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" /></TD>
			</TR>
			<TR style="display:none;">
				<td width="117">&nbsp;</td>
				<TD height="23"  ><span class="style3"> Stripe Key&nbsp;</span></TD>
				<TD  class=tableCellTwo  ><INPUT  class="text_box2"   maxLength="50" size="45" name="papal_id" id="papal_id"  value="<?php echo $row[papal_id]?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" /></TD>
			</TR>

			<TR>
				<td width="117">&nbsp;</td>
				<TD  class=tableCellTwo    ></TD>
				<td><INPUT  type="image" src="img/Copy of btn_save.gif"   name="save" value="   Save  "  border="0" style="border:none;"	 	></TD>
			</TR>
		</table>
	</form>
</div>
<div class="tracking_box" style="padding-top:0px">
	<table width="100%" >
		<tr class="rowtitle">
			<td class="top-bar" ><div style="float:left">Update Admin Password</div>
				<div style="width:300px; color:#98F0FF; float:left; padding-left:150px;">
					<?php if (isset ($_SESSION['msgPass'] ) ) 
{
 echo  $_SESSION['msgPass']; unset($_SESSION['msgPass']); 
 } 
 ?>
				</div></td>
		</tr>
		<tr>
			<td class="msg" align="center"></td>
		</tr>
	</table>
	<form method="post" action="updateadmin.php" >
		<table cellpadding="0" cellspacing="5" border="0" width="100%"   >
			<TR>
				<td width="116">&nbsp;</td>
				<TD width="197"   ><span class="style3">Current Password</span></TD>
				<TD width="881"><INPUT   type="password" maxLength="20" size="20" class="text_box2" name="current" id="current"  onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';"/></TD>
			</TR>
			<TR>
				<td width="116">&nbsp;</td>
				<TD height="23"    ><span class="style3"> New Password </span></TD>
				<TD  class=tableCellTwo  ><INPUT   type="password"  maxLength="20" size="20" class="text_box2"  name="new" id="new"  onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" /></TD>
			</TR>
			<TR>
				<td width="116">&nbsp;</td>
				<TD height="23"><span class="style3"> Confirm Password </span></TD>
				<TD  class=tableCellTwo  ><INPUT   type="password"  maxLength="20" size="20" class="text_box2"  name="confirm" id="confirm"  onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" />
					<input type="hidden" name="hid_email" value="<?php echo $row['email ']; ?>" /></TD>
			</TR>
			<TR>
				<td width="116">&nbsp;</td>
				<TD  class=tableCellTwo    ></TD>
				<td><INPUT  type="image" src="img/Copy of btn_save.gif"   name="save" value="   Save  " 
 border="0" style="border:none;"	 ></TD>
			</TR>
		</table>
	</form>
</div>
<div class="tracking_box" style="padding-top:0px; display:none;">
	<table width="100%" >
		<tr class="rowtitle">
			<td class="top-bar" ><div style="float:left">Social Network Links</div>
				<div style="width:300px; color:#98F0FF; float:left; padding-left:150px;">
					<?php if ( isset ($_SESSION['links'] ) ) 
{
 echo  $_SESSION['links']; unset($_SESSION['links']); 
 } 
 ?>
				</div></td>
		</tr>
		<tr>
			<td class="msg" align="center"></td>
		</tr>
	</table>
	<form method="post" action="updateadmin.php" >
		<table cellpadding="0" cellspacing="5" border="0" width="100%"   >
			<TR>
				<td width="116">&nbsp;</td>
				<TD width="197"   ><span class="style3">Facebook link</span></TD>
				<TD width="881"><INPUT   type="text" size="40" class="text_box_link" name="facebook" id="facebook" value="<?php echo $row_link['facebook']?>"  /></TD>
			</TR>
			<TR>
				<td width="116">&nbsp;</td>
				<TD height="23"    ><span class="style3">Twitter Link</span></TD>
				<TD  class=tableCellTwo  ><INPUT   type="text" size="40" class="text_box_link" name="twitter" id="twitter"  value="<?php echo $row_link['twitter']?>"  /></TD>
			</TR>
			<TR style="display:none">
				<td width="116">&nbsp;</td>
				<TD height="23"     ><span class="style3">Email</span></TD>
				<TD  class=tableCellTwo  ><INPUT   type="text" size="40" class="text_box_link" name="digg" id="digg"  value="<?php echo $row_link['digg']?>"  /></TD>
			</TR>
			<TR style="display:none">
				<td width="116" >&nbsp;</td>
				<TD height="23"     ><span class="style3">Linkedin Link</span></TD>
				<TD  class=tableCellTwo  ><INPUT   type="text" size="40" class="text_box_link" name="linkedin" id="linkedin"  value="<?php echo $row_link['linkedin']?>"  /></TD>
			</TR>
			<TR  style="display:none">
				<td width="116">&nbsp;</td>
				<TD height="23"     ><span class="style3">Google Plus Link</span></TD>
				<TD  class=tableCellTwo  ><INPUT   type="text" size="40" class="text_box_link" name="youtube" id="youtube"  value="<?php echo $row_link['youtube']?>"  /></TD>
			</TR>
			<TR>
				<td width="116">&nbsp;</td>
				<TD height="23"     ><span class="style3">Instagram Link</span></TD>
				<TD  class=tableCellTwo  ><INPUT   type="text" size="40" class="text_box_link" name="digg" id="digg"  value="<?php echo $row_link['digg']?>"  /></TD>
			</TR>
			<TR>
				<td width="116">&nbsp;</td>
				<TD  class=tableCellTwo    ></TD>
				<td><input type="hidden" name="linkid" id="linkid" value="1" />
					<INPUT  type="image" src="img/Copy of btn_save.gif"   name="updatelinks" value="Save"  border="0" style="border:none;"></TD>
			</TR>
		</table>
	</form>
</div>

<div class="tracking_box" style="padding-top:0px; display:none; ">
	<table width="100%" >
		<tr class="rowtitle">
			<td class="top-bar" ><div style="float:left">Update Title & Meta Tags</div>
				<div style="width:300px; color:#98F0FF; float:left; padding-left:150px;">
					<?php if (isset ($_SESSION['meta_tag'] ) ) 
{
 echo  $_SESSION['meta_tag']; unset($_SESSION['meta_tag']); 
 } ?>
				</div></td>
		</tr>
		<tr>
			<td class="msg" align="center"></td>
		</tr>
		<?php // } ?>
	</table>
	<form name="f1" id="f1" action="updateadmin.php?act=add_dea" method="post" enctype="multipart/form-data" >
		<table width="739" border="0" cellpadding="0" cellspacing="5"  >
			<TR>
				<TD colspan="4">&nbsp;</TD>
			</TR>
			<TR>
				<td width="84">&nbsp;</td>
				<TD width="151" height="23"  ><span class="style3"> Web Site Title&nbsp;</span></TD>
				<TD width="430"  class=tableCellTwo  ><INPUT  class="text_box2"   maxLength="50" size="39" name="web_title" id="web_title"  value="<?php echo stripslashes($row_hid['website_title']);?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" /></TD>
				<TD width="49" rowspan="5" style="display:none"><img src="../images/<?php echo $row_hid['logoname'];?>" align="Logo image"  style="max-width:221px; max-height:202px"   /></TD>
			</TR>
			<TR>
				<td width="84">&nbsp;</td>
				<TD  class=tableCellTwo   valign="top"  ><span class="style3">Meta Kewords </span></TD>
				<td><textarea  name="meta_tags" cols="30" rows="5" style="border:1px solid #CCCCCC"><?php echo stripslashes($row_hid['meta_tags']);?></textarea></TD>
			</TR>
			<TR>
				<td width="84">&nbsp;</td>
				<TD  class=tableCellTwo valign="top"    ><span class="style3"> Meta Description</span></TD>
				<td><textarea name="meta_discription" cols="30" rows="5" style="border:1px solid #CCCCCC"><?php echo stripslashes($row_hid['meta_discription']); ?></textarea></TD>
			</TR>
			<TR style="display:none">
				<td width="84">&nbsp;</td>
				<TD  class=tableCellTwo valign="top"    ><span class="style3">Header Description</span></TD>
				<td><textarea name="header_desc" cols="30" rows="5" style="border:1px solid #CCCCCC"><?php echo stripslashes($row_hid['header_desc']); ?></textarea></TD>
			</TR>
			<TR style="display:none">
				<td width="84">&nbsp;</td>
				<TD  class=tableCellTwo valign="top"    ><span class="style3">Web Site Logo</span></TD>
				<td><input type="file" name="imagelogo" class=""  />
					<input type="hidden" name="hiden_logo_name" id="hiden_logo_name"	value="<?php echo $row_hid['logoname']; ?>"  /></TD>
			</TR>
			<TR>
				<td width="84">&nbsp;</td>
				<TD  class=tableCellTwo    ></TD>
				<td><INPUT  type="image" src="img/Copy of btn_save.gif"   name="filesave" value="   Save  " 
 border="0" style="border:none;"	 ></TD>
				<TD>&nbsp;</TD>
			</TR>
		</table>
	</form>
</div>
