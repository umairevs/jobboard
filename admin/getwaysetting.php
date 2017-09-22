<?php 
    defined('_JEVS') or die('Restricted access');

	createTable('meta'); // create table if not exist
    
	
	$qry = "Select * from tbl_admin";
	$rs=mysql_query( $qry );
	$row=mysql_fetch_array($rs); 
	$hid_logo = mysql_query("Select * from tbl_metaInfo");
	$row_hid=mysql_fetch_array($hid_logo);
	
	$qry_link = "Select * from tbl_links";
	$rs_link=mysql_query( $qry_link );
	$row_link=mysql_fetch_array($rs_link); 
	
	$qry_payment = "Select * from tbl_payment";
	$rs_payment=mysql_query($qry_payment);
	$row_payment=mysql_fetch_array($rs_payment);
	//echo "<pre>"; print_r($row_payment); exit;
   
?>

<table width="100%" >
  <tr class="rowtitle">
    <td class="top-bar" ><div style="float:left">Payment Getway Settings</div>
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
        <TD colspan="3" class="top-bar">Account Settings</TD>
      </TR>
      <TR>
        <td width="117">&nbsp;</td>
        <TD width="193" ><span class="style3">Bank&nbsp;Name&nbsp;</span></TD>
        <TD width="884"><INPUT   maxLength="50" size="45" name="bank_name" id="pf_fn" class="text_box2"  value="<?php echo $row['bant_name']?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';"/></TD>
      </TR>
      <TR>
        <td width="117">&nbsp;</td>
        <TD height="23" ><span class="style3"> Account&nbsp;Title</span></TD>
        <TD  class=tableCellTwo  ><INPUT   maxLength="50" size="45"  class="text_box2"  name="pf_ln" id="pf_ln"  value="<?php echo $row['account_title']?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" /></TD>
      </TR>
      <TR>
        <td width="117">&nbsp;</td>
        <TD height="23"  ><span class="style3">Account&nbsp;Number</span></TD>
        <TD  class=tableCellTwo  ><INPUT   maxLength="50" class="text_box2"  size="45" name="pf_email" id="pf_email"  value="<?php echo $row['account_num']?>" onchange="document.getElementById('namesave').style.color='red';document.getElementById('namesave').innerHTML='Save Changes';" /></TD>
      </TR>
      <TR style="display:none">
        <td width="117">&nbsp;</td>
        <TD height="23"  ><span class="style3"> PayPal ID&nbsp;</span></TD>
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
