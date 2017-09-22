<?php
//Check access of module
include("security_module.php");

if(isset($_GET['u']))
{
	$sql = "select * from tbl_employer where id='".$_GET['u']."'";
	$rsUserEdit= mysql_query($sql) or die(mysql_error());
	$rowUserEdit = mysql_fetch_array($rsUserEdit);
	
	
	$userId 		= stripslashes($rowUserEdit['id']);
	$company_name 		= stripslashes($rowUserEdit['company_name']);
	$industry 			= stripslashes($rowUserEdit['industry']);
	
	$phone 			= stripslashes($rowUserEdit['mobile_no']);
	$useremail 		= stripslashes($rowUserEdit['email']);
	
	$father_name 		= stripslashes($rowUserEdit['father_name']);
	
	$posted_date		= stripslashes($rowUserEdit['posted_date']);
	$userstatus 	= stripslashes($rowUserEdit['status']);
	
	$address 	= stripslashes($rowUserEdit['address']);
	$last_login_date 	= stripslashes($rowUserEdit['last_login_date']);
	$image 	= stripslashes($rowUserEdit['image']);
	
	$added_data 			= stripslashes($rowUserEdit['added_date']);
	
	 
	//$address 		= Get_Locations($address);
}
?>

<table width="100%" >
	<tr>
		<td class="top-bar"><div style="float:left">View User Profile</div>
			<div style="float:right; text-align:right; width:100px;  padding-right:20px;">
				<label onclick="history.go(-1)" title="Click here to Back">Back</label>
			</div></td>
	</tr>
</table>
<form method="post" action="home.php?p=addedituser&mod=<?php echo $mod;?>&u=<?php echo $_GET['u']; ?>" enctype="multipart/form-data">
	<input type="hidden" name="userid" value="<?php echo $userId;?>">
	<table width="100%" class="mytable1" border="0" cellpadding="3" cellspacing="1" >
		<tr  >
			<th>Company Name:</th>
		  <td style="width:75%" ><?php echo $company_name;?></td>
		</tr>
		
        <tr>
			<th>User Email:</th>
			<td><?php echo $useremail;?></td>
		</tr>
		
        <tr>
			<th>Industry:</th>
			<td><?php echo $industry;?></td>
		</tr>
	
    
		<tr>
			
            <th>Mobile Number:</th>
			<td><?php echo $phone;?></td>
		</tr>
		
	
    <tr>
			<th>Address:</th>
			<td>
			<?php			
				echo $address;
			?>
			</td>
		</tr>
        
         <tr>
			<th>Status:</th>
			<td>
			<?php			
				if($userstatus == "1"){ echo "Active"; }
				if($userstatus == "0"){ echo "Suspended";} 
				if($userstatus == "p"){echo "Pending"; }
			?>
			</td>
		</tr>
        
        
       <?php
	   if($image!='')
		{
		?> 
          <tr>
			<th>Image:</th>
			<td><?php 
		if($image!='')
		{
			?>
			<img src="<?php echo $ru;?>media/emp_images/<?php echo $image;?>" style="width:95px;">
			<?php 
		}
		?></td>
		</tr>
        <?php
		}
		?>
        
        
          <tr>
			<th>Added Date:</th>
			<td><?php echo $added_data;?></td>
		</tr>
        
        
		<tr>
			<th>&nbsp;</th>
			<td ><input type="hidden" name="userId" value="<?php echo $userId ?>">
				
				<!--<input  type="image" src="img/btn_save.gif" name="update" />-->
			<?php
				$qry = "SELECT * FROM `tbl_job_seaker_resume` WHERE user_id = '".$userId."'";
				$arr = $db->get_row($qry,ARRAY_A); 
				?>
				<input type="button" name="bback" id="bback" value="Back" ONCLICK="history.go(-1)">
				
				<input type="button" name="bdelete" id="bdelete" value="Delete" ONCLICK="delete_emp(<?php echo $rowUserEdit["id"];?>)" ></td>
				
		</tr>
	</table>
</form>
<script>
	function delete_emp(val)
	{
		var tmp=confirm('This will Delete user. User not able to login. Are you sure!'); 
		if(tmp)
		{
			window.location.href = "home.php?p=updateemployer&mod=<?php echo $mod ?>&a=d&u="+val;
		}
	}
</script>
<?php
unset($_SESSION['updatemsg']);
unset($_SESSION['sesErr']);
unset($_SESSION['regUser']);
?>
