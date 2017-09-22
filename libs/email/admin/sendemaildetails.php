<?php
 defined('_JEVS') or die('Restricted access');
if(isset($_GET['u']))
{
	$sql = "SELECT 
	                    tbl_users.id, 
						tbl_users.fname, 
						tbl_users.lname,
						tbl_users.username,
						tbl_users.email,
						tbl_users.password,
	                    tbl_users.status,
						tbl_adminpayment.parent_cat,
						tbl_adminpayment.sub_cat,
						tbl_adminpayment.duplicate_email,
						tbl_adminpayment.email_template,
						tbl_adminpayment.email_content,
						tbl_adminpayment.add_date
                        FROM tbl_users
                        INNER JOIN
						tbl_adminpayment
                        ON
					    tbl_users.id = tbl_adminpayment.user_id 
						where tbl_users.id='".$_GET['u']."'";
	$rsUserEdit= mysql_query($sql) or die(mysql_error());
	$rowUserEdit = mysql_fetch_array($rsUserEdit);
	$userId = $rowUserEdit['id'];
	$full_name = $rowUserEdit['fname'];
	$username = $rowUserEdit['lname'];
	$useremail = $rowUserEdit['email'];
	//$username = $rowUserEdit['email'];
	$userpass = $rowUserEdit['password'];
	$parent_cat = $rowUserEdit['parent_cat'];
	
	$sub_cat = $rowUserEdit['sub_cat'];
	$duplicate_email = $rowUserEdit['duplicate_email'];
	$email_template = $rowUserEdit['email_template'];
	$email_content = $rowUserEdit['email_content'];
	$add_date = $rowUserEdit['add_date'];
	$date_formate = strtotime($add_date);
	$today = date("F j, Y, g:i a",$date_formate); 
	$username = $rowUserEdit['username'];
}


?>

<table width="100%" >
  <tr>
    <td class="top-bar"><div style="float:left">View User Detail</div>
      <div style="float:right; text-align:right; width:100px;  padding-right:20px;">
        <label onclick="history.go(-1)" title="Click here to Back">Back</label>
      </div></td>
  </tr>
</table>
<form method="post" action="home.php?p=addedituser&mod=<?php echo $mod;?>&u=<?php echo $_GET['u']; ?>" enctype="multipart/form-data">
  <input type="hidden" name="userid" value="<?php echo $userId;?>">
  <table width="100%" class="mytable1" border="0" cellpadding="3" cellspacing="1" >
    <tr>
      <th>Username Name:</th>
      <td style="width:75%" ><?php echo $useremail;?></td>
    </tr>

    <tr>
      <th>User Email:</th>
      <td><?php echo $useremail;?></td>
    </tr>

    <tr>
      <th>Parent Category:</th>
      <td><?php echo $parent_cat;?></td>
    </tr>
    <tr>
      <th>Sub Category:</th>
      <td><?php echo $sub_cat;?></td>
    </tr>
    <tr>
      <th>Duplicate Email:</th>
      <td><?php echo $duplicate_email;?></td>
    </tr>
    
      <tr>
      	<th>Add Date:</th>
      	<td><?php echo  $today ;?></td>
    </tr>
    
    <tr >
      <th>Email Template:</th>
      <td><?php	echo $email_template;	?></td>
    </tr>
    
      <tr>
      	<th>Email Content:</th>
      	<td><?php	echo $email_content;	?></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td ><input type="hidden" name="userId" value="<?php echo $userId ?>">
        
        <!--<input  type="image" src="img/btn_save.gif" name="update" />-->
        
        <input type="submit" name="update" value="Edit">
        &nbsp;&nbsp;
        <input type="button" name="bback" id="bback" value="Back" ONCLICK="history.go(-1)"></td>
    </tr>
  </table>
</form>
<?php
unset($_SESSION['updatemsg']);
unset($_SESSION['sesErr']);
unset($_SESSION['regUser']);
?>
