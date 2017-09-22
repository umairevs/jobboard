<?php 
    defined('_JEVS') or die('Restricted access');
	createTable('emailTemp'); // for create table if not exist;
	$type = $_GET['type'];
    $type = ($type)?$type:"forgetpassword";
	$where = "type='".$type."'";
	$qry="select * from  tbl_emails where ".$where;
	$rs=mysql_query($qry);
	$row =mysql_fetch_array($rs);
	$adminName  = stripslashes($row['adminname']);
	$toadmin    = stripslashes($row['toadmin']);
	$touser     = stripslashes($row['touser']);
	$subject    = stripslashes($row['subject']);
	$htmlData   = stripslashes($row['body']);
	$htmlData = stripslashes($htmlData);
?>
<script language="javascript" type="text/javascript">
			function mailcontent()
			{
				var type = document.getElementById('type').value;
				window.location = "home.php?mod=<?php echo $mod;?>&p=emailsalert&type="+type;
			}
			</script>

<table width="100%" class="top-bar">
  <tr>
    <td ><div style="float:left">E-Mail Alert Management</div>
      <div class="message">
        <?php if ( isset ($_SESSION['msgText'] ) ) { echo $_SESSION['msgText']; unset($_SESSION['msgText']);}?>
      </div></td>
  </tr>
</table>
<table width="100px">
  <tr>
    <td class="msg" align="center"></td>
  </tr>
</table>
<form   method="post" action="home.php?mod=<?php echo $mod;?>&p=savemailalert" >
  <input type="hidden" name="savepage" value="<?php echo $type; ?>">
  <input type="hidden" name="SaveTextData" value="SaveTextData" />
  <table border="0" width="100%" cellpadding="0" cellspacing="2">
    <tr>
      <td width="100" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold; ">Set email to:</td>
      <td><select class="normal" name="type" id="type" onchange="mailcontent();">
          <?php
			$qry_list="select * from  tbl_emails";
			$rs_info=mysql_query($qry_list);
			while($row_data =mysql_fetch_array($rs_info))
			{
				$db_type  =  stripslashes($row_data['type']);
				$db_subject  =  stripslashes($row_data['subject']);
			?>
            	
			<option <?php if($type == $db_type){ ?> selected="selected" <?php } ?> value="<?php echo $db_type;?>"><?php echo $db_subject;?></option>
            <?php
			}
			?>
            
           </select>
        
        <!--
			<option <?php if($type == "signup"){ ?> selected="selected" <?php } ?> value="signup">Sign Up</option>
			<option <?php if($type == "registrationcomplete"){ ?> selected="selected" <?php } ?> value="registrationcomplete">Order Added</option>
			<option <?php if($type == "changepassword"){ ?> selected="selected" <?php } ?> value="changepassword">Change Password</option>
			--></td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle"> Admin Name</td>
      <td colspan="2"><input type="text" name="adminname" value="<?php echo $adminName; ?>" size="60">
        &nbsp;&nbsp;<span class="supporting">The admin name which            display on user's email</span></td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle"> Email to Admin</td>
      <td colspan="2"><input type="text" name="toadmin" value="<?php echo $toadmin; ?>" size="60">
        &nbsp;&nbsp;<span class="supporting">Where admin receive emails            from users</span></td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle"> Email to User</td>
      <td colspan="2"><input type="text" name="touser" value="<?php echo $touser; ?>" size="60">
        &nbsp;&nbsp;<span class="supporting">Where users receive emails            from admin</span></td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle"> Email&nbsp;Subject</td>
      <td colspan="2"><input type="text" name="txtSubject" value="<?php echo $subject; ?>" size="110"></td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:30px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;" valign="top"> Variables</td>
      <td colspan="2"><span class="">
        <?php if($type == "artistsignup"){ ?>
        {{bandname}} , {{Email}} , {{Password}} , {{siteLink}}
        <?php } ?>
        <?php if($type == "organizersignup"){ ?>
        {{bandname}} , {{Email}} , {{Password}} , {{siteLink}}
        <?php } ?>        

        <?php if($type == "artistslotrequest"){ ?>
        {{bandname}} , {{timeslot}} , {{venue}} , {{date}} , {{siteLink}}
        <?php } ?>        

        <?php if($type == "organizerslotrequest"){ ?>
        {{bandname}} , {{timeslot}} , {{venue}} , {{date}} , {{siteLink}}
        <?php } ?>        

        <?php if($type == "escrowrequest"){ ?>
        {{bandname}} , {{timeslot}} , {{venue}} , {{date}} , {{amount}} , {{siteLink}}
        <?php } ?>

        <?php if($type == "forgetpassword"){ ?>
        {{bandname}} , {{siteLink}}
        <?php } ?>
        
         <?php if($type == "support"){ ?>
        {{name}} , {{subject}} , {{email}} , {{message}}
        <?php } ?>
        </span></td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:30px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;" valign="top"><br />
        Email&nbsp;Body</td>
      <td colspan="2">
      	<!--<textarea  name="txtData" cols="85" rows="20" ><?php //echo $htmlData; ?></textarea>-->
      	<?php
	        include("../fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor('txtData');
			$oFCKeditor->BasePath = '../fckeditor/';
			
			$oFCKeditor->Value =  stripslashes($htmlData);
			$oFCKeditor->Create() ;
		?>
      </td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="right" style="padding-top:5px; padding-right:22px;"><input  type="image" src="img/Copy of btn_save.gif" name="SaveTextData" style="margin-right:340px;"/></td>
    </tr>
  </table>
</form>
