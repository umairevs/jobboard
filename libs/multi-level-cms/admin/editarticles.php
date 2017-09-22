<?php
//defined('_JEVS') or die('Restricted access');
include("../includes/functions/funcatlist.php");
$id=$_GET['id'];
$qry="select * from tbl_articles where id='".$id."'";
$exe_qurey=mysql_query($qry);
$rec=mysql_fetch_array($exe_qurey);
?>

<table width="100%" >
<tr><td class="top-bar">Edit Page <div style="float:right"><a href="javascript:" ONCLICK="history.go(-1)"> Back </a> </div></td></tr>

<form   method="post" action="home.php?mod=<?php echo $mod;?>&p=processeditarticles" >

<table border="0" width="100%" cellpadding="0" cellspacing="2">
	
		<td height="27" colspan="1"  valign="middle"> </td>
		<td colspan="2" style="color:#CC0000;"> 
			<?php if($_SESSION["addart"]["title"]){ print_r ($_SESSION["addart"]["title"]); echo "<br />"; }?>
			<?php if($_SESSION["addart"]["orderby"]){ print_r ($_SESSION["addart"]["orderby"]); echo "<br />"; }?>
			<?php if($_SESSION["addart"]["txtData"]){ print_r ($_SESSION["addart"]["txtData"]); echo "<br />"; }?>
		</td>
	</tr>
	<tr style="display:none;">
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">CMS Group </td>
		<td colspan="2">
		<?php if(isset($_GET['pid'])){ ?> 
		<select name="parent">
		<?php
			$cms_pages = mysql_query("select * from tbl_articles where parent = '0' and status = '1'");  
			while($cms = mysql_fetch_array($cms_pages)){ 
				$parent_id = $cms['id'];
				$parent_title =stripslashes($cms['title']);			
				if($cms['id'] == $rec['parent'])
					echo "<option value=$parent_id selected>$parent_title</option>";
				else
					echo "<option value=$parent_id>$parent_title</option>";
				}	
		?>
		</select>
		<?php }else { 
		$cms_pages = mysql_query("select * from tbl_articles where parent = '0' and status = '1'"); 
		?>
		<select name="parent">
		<option value="0">Select Group</option>
		<?php while($cms = mysql_fetch_array($cms_pages)){ ?>
		<option value="<?php echo $cms['id']; ?>" ><?php echo stripslashes($cms['title']); ?></option>
		<?php } ?>
		</select>
		<?php } ?>
		</td>
	</tr>
	
	<tr>
		<td height="27" colspan="1"  valign="middle" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;">CMS Order </td>
		<td colspan="2"> 
			<!--<input type="text" name="orderby" value="<?php //if($_SESSION["addart_v"]["orderby"]!=''){ echo $_SESSION["addart_v"]["orderby"];} else { echo $rec['orderby']; } ?>" size="15">-->
            <input type="text" name="orderby" value="<?php echo $id;?>" size="15">

		</td>
	</tr>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Title </td>
		<td colspan="2"><input type="text" name="title" value="<?php if($_SESSION["addart_v"]["title"]!=''){ echo $_SESSION["addart_v"]["title"];} else { echo $rec['title']; } ?>" size="110"></td>
	</tr>
    <?php if($id != 67){ ?>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Meta Title</td>
		<td colspan="2"><input type="text" name="metatitle" value="<?php if($_SESSION["addart_v"]["metatitle"]!=''){ echo $_SESSION["addart_v"]["metatitle"];} else { echo $rec['metatitle']; } ?>" size="110"></td>
	</tr>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Meta Keywords</td>
		<td colspan="2"><input type="text" name="metakeyword" value="<?php if($_SESSION["addart_v"]["metakeyword"]!=''){ echo $_SESSION["addart_v"]["metakeyword"];} else { echo $rec['metakeyword']; } ?>" size="110"></td>
	</tr>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Meta Description</td>
		<td colspan="2"><input type="text" name="metadesc" value="<?php if($_SESSION["addart_v"]["metadesc"]!=''){ echo $_SESSION["addart_v"]["metadesc"];} else { echo $rec['metadesc']; } ?>" size="110"></td>
	</tr>
    <?php } ?>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:30px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;" valign="top">
		Content</td>
		
		<td colspan="2">
		
		<?php 
			include("../fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor('txtData');
			$oFCKeditor->BasePath = '../fckeditor/';
			if($_SESSION["addart_v"]["txtData"]!='')
				$oFCKeditor->Value = stripslashes( $_SESSION["addart_v"]["txtData"]);
			else
				$oFCKeditor->Value =  stripslashes($rec['content']);
				$oFCKeditor->Create() ;
		?>
		</td>
	</tr>
	
	<tr>
		<td></td>
		
		<td colspan="2" align="right" style="padding-top:15px; padding-right:22px;">
		<input type="hidden" name="id" value="<?php echo $id;?>">
		<input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>">
        <input name="update" value="update" type="submit" />
        <input type="hidden" name="SaveTextData" value="Save" >
		</td>
	</tr>
</table>
<?php unset($_SESSION["addart"]); unset($_SESSION["addart_v"]);?>
</form>