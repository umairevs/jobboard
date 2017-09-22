<?php
//Check access of module
include("security_module.php");

if(isset($_GET['u']))
{
	$sql = "select * from tbl_job_seaker where id='".$_GET['u']."'";
	$rsUserEdit= mysql_query($sql) or die(mysql_error());
	$rowUserEdit = mysql_fetch_array($rsUserEdit);
	
	
	$userId 		= stripslashes($rowUserEdit['id']);
	$full_name 		= stripslashes($rowUserEdit['name']);
	
	$phone 			= stripslashes($rowUserEdit['mobile_number']);
	$useremail 		= stripslashes($rowUserEdit['email']);
	$city 			= stripslashes($rowUserEdit['city']);
	$state 			= stripslashes($rowUserEdit['state']);
	$country 		= stripslashes($rowUserEdit['country']);
	
	$father_name 		= stripslashes($rowUserEdit['father_name']);
	
	$posted_date		= stripslashes($rowUserEdit['posted_date']);
	$userstatus 	= stripslashes($rowUserEdit['status']);
	
	$file 	= stripslashes($rowUserEdit['file']);
	$last_login_date 	= stripslashes($rowUserEdit['last_login_date']);
	$image 	= stripslashes($rowUserEdit['image']);
	
	
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
			<th> Name:</th>
		  <td style="width:75%" ><?php echo $full_name;?></td>
		</tr>
		
        <tr  >
			<th>User Email:</th>
			<td><?php echo $useremail;?></td>
		</tr>
		<tr  style="display:none" >
			<th>Birth Date:</th>
			<td><?php echo $birth_date;?></td>
		</tr>
		<tr  >
			<th>Mobile Number:</th>
			<td><?php echo $phone;?></td>
		</tr>
		
		<?php
	if($country!=0)
	{
	?>
     	<tr  >
			<th>Country:</th>
			<td><?php 
			$country_list	=	get_country($country);
			echo stripslashes($country_list['Country']);?></td>
		</tr>
     
      <?php
	}
	
	if($state!=0)
	{
	?>
    <tr  >
			<th>State:</th>
			<td><?php 
			$state_list	=	get_state($state);
			echo stripslashes($state_list['Region']);?></td>
		</tr>
      <?php
	}
	 
	if($city!=0)
	{
	?>
        <tr  >
			<th>City:</th>
			<td><?php
			$city_list	=	get_city($city);
			echo stripslashes($city_list['City']);
			
			?></td>
		</tr>
	<?php
	}
	?>
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
			<img src="<?php echo $ru;?>media/user_images/<?php echo $image;?>" style="width:95px;">
			<?php 
		}
		?></td>
		</tr>
        <?php
		}
		?>
        
        
          <tr>
			<th>Resume Document:</th>
			<td><a href="<?php echo $ru;?>media/category/<?php echo $file;?>" style="color:#1184D2; font-weight:bold;font-size:12px; 			font-family:Arial;"><?php echo $file;?></a></td>
		</tr>
        
        
		<tr>
			<th>&nbsp;</th>
			<td ><input type="hidden" name="userId" value="<?php echo $userId ?>">
				
				<!--<input  type="image" src="img/btn_save.gif" name="update" />-->
			<?php
				$qry = "SELECT * FROM `tbl_job_seaker_resume` WHERE user_id = '".$userId."'";
				$arr = $db->get_row($qry,ARRAY_A);
	
	
				if($arr)
				{
			?>	
				<a href="<?php echo $ru;?>resume/<?php echo base64_encode($userId);?>" target="_blank" style="color:#1184D2; font-size:12px;  font-family:Arial;">View Resume</a>
				&nbsp;&nbsp;
                <?php
				}
				else
				{
					?>
                    <a target="_blank" style="padding:10px;color:#1184D2; font-weight:bold;font-size:12px; 			font-family:Arial;">Resume do not create</a>
                    <?php
				}
				?>
				<input type="button" name="bback" id="bback" value="Back" ONCLICK="history.go(-1)"></td>
		</tr>
	</table>
</form>
<?php
unset($_SESSION['updatemsg']);
unset($_SESSION['sesErr']);
unset($_SESSION['regUser']);
?>
