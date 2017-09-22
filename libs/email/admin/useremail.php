<?php 
	
	defined('_JEVS') or die('Restricted access'); 
	$cid 		= $_GET['cid'];
	$oid 		= $_GET['oid'];
	$user_id 	= $_GET['id'];
	$parent_id 	= $_GET['par_cat'];
	$sub_cat_id	= $_GET['sub_cat'];
	createTable('emailTemp'); // for create table if not exist;
	$type 		= $_GET['type']; 
    $type 		= ($type)?$type:"sucessfullpaymentbyadmin";
	$where 		= "type='".$type."'";
	$qry		= "select * from  tbl_emails where ".$where;
	$rs			= mysql_query($qry);
	$row 		= mysql_fetch_array($rs);
	$adminName  = stripslashes($row['adminname']);
	$toadmin    = stripslashes($row['toadmin']);
	$touser     = stripslashes($row['touser']);
	$subject    = stripslashes($row['subject']);
	$htmlData   = stripslashes($row['body']);
	$htmlData 	= stripslashes($htmlData);
	
	if(isset($_GET['cid']) && $_GET['cid']!= ''){
		$sql_course 		= "SELECT course_title FROM tbl_courses where id = $cid ";
		$course_result 	= $db->get_row($sql_course,ARRAY_A);
	}
?>
<script language="javascript" type="text/javascript">
			function mailcontent()
			{
				var type = document.getElementById('type').value;
				window.location = "home.php?mod=<?php echo $mod;?>&p=useremail&type="+type;
			}
</script>
<script type="text/javascript">
function sele_sub(value)
{
            $.ajax({
			type: "POST",
			url:  "../../../learnsmart/admin/ajax_php/ajax.php",
			data: "type="+value,
			beforeSend: null,
			success: function(data){
				if(data == 'Error'){
					alert('Regions not found');
					return false;
				}else{
					$('#results').html(data);
				}
			},
			
		   });
}
</script>

<table width="100%" class="top-bar">
  <tr>
    <td ><div style="float:left">User E-Mail Management</div>
      <div class="message" style="color:#ffffff">
        <?php if ( isset ($_SESSION['msgText'] ) ) { echo $_SESSION['msgText']; unset($_SESSION['msgText']);}?>
      </div></td>
  </tr>
  

</table>
<form   method="post" action="home.php?mod=<?php echo $mod;?>&p=emailtouser" name="testfrm" id="testfrm" >
	<input type="hidden" name="course_title" value="<?php echo $course_result['course_title'];?>" />
    <input type="hidden" name="oid" value="<?php echo $oid;?>" />
  <table border="0" width="100%" cellpadding="0" cellspacing="2">
    <tr>
      <td width="100" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold; ">Select user</td>
      <td><select class="normal" name="user" id="user"  style="width:350px;">
      <option value="0">TOP</option>
      <?php
	 
	  $sql_query = "SELECT * FROM tbl_users where status = 'a' ";
	  $user_result = $db->get_results($sql_query,ARRAY_A);
	  foreach($user_result as $result)
	  {
		  if($result['id'] == $user_id){
			  $selected = "selected";
		  }else{
			  $selected = "";
		  }
	  ?>
	  <option value="<?php echo $result['id'];  ?>" <?php echo $selected; ?>><?php echo $result['fname'];  ?></option>
	  <?php 
	  }
	   ?>
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle"> Select Main Category</td>
      <td><select class="normal" name="parent_cate" id="parent_cate" onchange="sele_sub(this.value)" style="width:350px;">
      <option value="0">TOP</option>
      <?php
	  $sql_query1 = "SELECT * FROM tbl_categories where parent_id = 0 ";
	  $user_result1 = $db->get_results($sql_query1,ARRAY_A);
	  //echo "<pre>"; print_r($user_result1); exit;
	  $main_category = count($user_result1); 
	  foreach($user_result1 as $result)
	  { 
	    if($result['category_id'] == $parent_id){
			  $selected = "selected";
		  }else{
			  $selected = "";
		  }
	  ?>
	  <option value="<?php echo $result['category_id'];  ?>" <?php echo  $selected; ?>><?php echo $result['category_name'];  ?></option>
	  <?php 
	  }
	   ?>
      </select>
      </td>
    </tr>
 <tr id="results">
      <?php if(isset($_GET['par_cat']) && $_GET['par_cat'] != ''){ ?>
      		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle"> Select Sub Category</td>
      <td><select class="normal" name="sub_cate" id="sub_cate" style="width:350px;">
      <option value="0">TOP</option>
      <?php
		  $sql_sub_cat 	= "SELECT * FROM tbl_categories where parent_id = '".$_GET['par_cat']."' ";
		  $rs_sub_cat = $db->get_results($sql_sub_cat,ARRAY_A);
		  //echo "<pre>"; print_r($user_result1); exit;
		  $sub_category = count($rs_sub_cat); 
		  foreach($rs_sub_cat as $results)
		  { 
			if($results['category_id'] == $sub_cat_id){
				  $selected = "selected";
			  }else{
				  $selected = "";
			 }
		  ?>
		  <option value="<?php echo $results['category_id'];  ?>" <?php echo  $selected; ?>><?php echo $results['category_name'];  ?></option>
		  <?php 
		  }
		   ?>
		  </select>
		  </td>
		  <?php } ?>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle"> Select Email</td>
      <td colspan="2">
     <select class="normal" name="type" id="type" onchange="" style="width:350px;">
      <?php
	  $sql_query1 = "SELECT * FROM tbl_emails where type='sucessfullpaymentbyadmin' ";
	  $user_result1 = $db->get_results($sql_query1,ARRAY_A); 
	  //echo "<pre>"; print_r($user_result1); exit; ?>
<option value="<?php echo $user_result1[0]['subject'];  ?>" selected="selected"><?php echo $user_result1[0]['subject'];  ?></option>

		
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:30px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;" valign="top"> Variables</td>
      <td colspan="2"><span class="msg">
        <?php if($type == "sucessfullpaymentbyadmin"){ ?>
        {{FirstName}} , {{LastName}} , {{UserName}} , {{ParentCategory}} , {{SubCategory}}
        <?php } ?>
        <?php if($type == "forgetpassword"){ ?>
        {{FirstName}} , {{LastName}} , {{Password}} , {{UserName}} , {{Email}}
        <?php } ?>
        <?php if($type == "changepassword"){ ?>
        {{FirstName}} , {{LastName}} , {{Password}} , {{UserName}} , {{Email}}
        <?php } ?>
         <?php if($type == "registrationcomplete"){ ?>
        {{FirstName}} , {{LastName}} , {{LoginLink}}
        <?php } ?>
         <?php if($type == "ordersubmission"){ ?>
        {{FirstName}} , {{LastName}},{{OrdersLink}}, {{OrderUrl}}
        <?php } ?>
       
        </span></td>
    </tr>
    <tr>
      <td colspan="1" style="color:#666666;padding:4px;height:30px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;" valign="top"><br />
        Email&nbsp;Body</td>
      <td colspan="2">
      	<?php
	        include("../fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor('txtData');
			$oFCKeditor->BasePath = '../fckeditor/';
			
			//$oFCKeditor->Value =  stripslashes($f_Name);
			$oFCKeditor->Value =  stripslashes($htmlData);
			$oFCKeditor->Create() ;
		?>
      </td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="right" style="padding-top:5px; padding-right:22px;"><input  type="submit" value="Send" name="SaveTextData" style="margin-right:340px;"/></td>
    </tr>
  </table>
</form>	
