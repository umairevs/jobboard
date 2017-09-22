<?php
    defined('_JEVS') or die('Restricted access');
	include("../includes/functions/funcatlist.php");
 ?>

<table width="100%" >
<tr><td class="top-bar">Add Page <div style="float:right;" >
<a href="javascript:" ONCLICK="history.go(-1)" style=" color:#FFFFFF"> Back </a> </div></td></tr>
<?php  if ( isset ($_SESSION['msgMember'] ) ) { 
?>
<tr><td class="msg" align="center">
 <?php  echo $_SESSION['msgMember']; unset($_SESSION['msgMember']);?>
</td></tr>
 <?php  }?>



<form   method="post" action="home.php?mod=<?php echo $mod;?>&p=savearticls" >

<table border="0" width="100%" cellpadding="0" cellspacing="2">
	<?php 
		$id= $_GET['id'];
		if(isset($_GET['pid']))
		{
			$pid= $_GET['pid'];
			$cms_pages = mysql_query("select * from tbl_articles where parent = '".$pid."' and status = '1'"); 
		}else 
		{
			$cms_pages = mysql_query("select * from tbl_articles where parent = '0' and status = '1'"); 
		}
	?>
	
	<tr>
		<td height="27" colspan="1"  valign="middle"> </td>
		<td colspan="2" style="color:#CC0000;"> 
			<?php if($_SESSION["addart"]["title"]){ print_r ($_SESSION["addart"]["title"]); echo "<br />"; }?>
			<?php if($_SESSION["addart"]["orderby"]){ print_r ($_SESSION["addart"]["orderby"]); echo "<br />"; }?>
			<?php if($_SESSION["addart"]["txtData"]){ print_r ($_SESSION["addart"]["txtData"]); echo "<br />"; }?>
		</td>
	</tr>
	
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">CMS Group </td>
		<td colspan="2"> 
		<select name="parent" id="parent" class="combolist bord"   >
			<option value="0" >TOP</option>
				<?php 				
				  $queryselopt="select * from tbl_articles where parent = '0' and status = '1'";
				  $arrselopt=$db->get_results($queryselopt,ARRAY_A)	;
				  if(isset($arrselopt))
					foreach($arrselopt as $rowselopt)
					{
					if($rowselopt[id]==$id)
					{
					echo '<option value="'.$rowselopt[id].'" selected="selected" >'.stripslashes($rowselopt[title]).'&nbsp;&nbsp;</option>';
					}
					else
					{
					echo '<option value="'.$rowselopt[id].'" >'.stripslashes($rowselopt[title]).'&nbsp;&nbsp;</option>';
					}
				echo addcategorylist($rowselopt[id]);
			}
			?>
        </select>
		
		</td>
	</tr>
	<tr>
		<td height="27" colspan="1"  valign="middle" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;">CMS Order </td>
		<td colspan="2"> 
			<input type="text" name="orderby" class="bord" value="<?php echo $_SESSION["addart_v"]["orderby"]?>" size="15">
		</td>
	</tr>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Title </td>
		<td colspan="2"><input type="text" name="title"  class="bord"  value="<?php echo $_SESSION["addart_v"]["title"]?>" size="110"></td>
	</tr>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Meta Title</td>
		<td colspan="2"><input type="text" name="metatitle" class="bord"  value="<?php echo $_SESSION["addart_v"]["metatitle"]?>" size="110"></td>
	</tr>
    <tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Meta Keywords</td>
		<td colspan="2"><input type="text" name="metakeyword" class="bord"  value="<?php echo $_SESSION["addart_v"]["metakeyword"]?>" size="110"></td>
	</tr>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:20px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;"  valign="middle">Meta Description</td>
		<td colspan="2"><input type="text" name="metadesc" class="bord"  value="<?php echo $_SESSION["addart_v"]["metadesc"]?>" size="110"></td>
	</tr>
	<tr>
		<td colspan="1" style="color:#666666;padding:4px;height:30px;font-family: Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;" valign="top">
		Content</td>
		
		<td colspan="2">
		
		       <?php include("../fckeditor/fckeditor.php");
				$oFCKeditor = new FCKeditor('txtData');
				$oFCKeditor->BasePath = '../fckeditor/';
				if($_SESSION["addart_v"]["txtData"]!='')
					$oFCKeditor->Value = $_SESSION["addart_v"]["txtData"];
				else
					$oFCKeditor->Value = $htmlData;
					$oFCKeditor->Create() ;
		?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2" align="right" >
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="image" name="SaveTextData" value="Save" src="img/btn_save.gif"></td>
	</tr>
</table>
<?php unset($_SESSION["addart"]); unset($_SESSION["addart_v"]);?>
</form>