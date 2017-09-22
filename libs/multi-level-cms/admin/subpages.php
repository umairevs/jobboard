<?php
/////////////////////////////////////////
     defined('_JEVS') or die('Restricted access');
			  // pagination 2 of 3 
			$query = "SELECT count(*) as COUNT from tbl_articles WHERE parent = '".$_GET['id']."' ORDER BY `tbl_articles`.`orderby` ASC ";
			$query_data = $db->get_row($query,ARRAY_A);
			$numrows = $query_data[COUNT];  
			$rows_per_page = 20;
			$lastpage= ceil($numrows/$rows_per_page);
			$pageno = (int)$pageno;
			if ($pageno < 1) 
			{
			  	$pageno = 1;
			} 
			elseif ($pageno > $lastpage)
			{
			  	$pageno = $lastpage;
			} 
			if($numrows==0)
			$limit = 'LIMIT ' .($pageno).',' .$rows_per_page;
			else
			$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
			//..............
			
			$min=$pageno;
			if(isset($min))
			if(!isset($pageno) or $pageno==1)
			$i=0;
			else
			$i=$min+1;

///////////////////////////////////////////////

	$id = $_GET['id'];
	$sql = "SELECT id, title, orderby ,status  FROM `tbl_articles` WHERE parent ='".$_GET['id']."' ORDER BY `tbl_articles`.`orderby` ASC $limit ";
	$query_sel = mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query_sel);
	$sqlparent = "SELECT * FROM `tbl_articles` WHERE id ='".$_GET['id']."'";
	$sel_parent = mysql_query($sqlparent) or die(mysql_error());
	$row = mysql_fetch_array($sel_parent);
	$page = $row['title'];
	
$t .= '<table width="100%" ><tr><td class="top-bar">
			<div style="float:left; width:98%"><div style="float:left; width:250px">'.$page.' Page Management</div>';
if(isset($_SESSION['msg']))
 {
	$t .='<div class="message"> ' .$_SESSION['msg'].'</div>';
    unset($_SESSION['msg']);
}
	$t .='<div style="float:right">Add New Page&nbsp;<img src="img/new_faq_class.png" border="0" 
				onclick="window.location=\'home.php?mod='.$mod.'&p=addarticles&id='.$id.'&pid='.$row['parent'].'\';" style="cursor:pointer" title="Add Page" /></div>';
$t .='</div></td></tr>';

$t.='</table>';

$t.='<table cellpadding="0" cellspacing="0" id="vtop" width="100%">

	
		
	<tr>
		<td>
		
		<table width="100%" border="0" cellpadding="0" class="grid" cellspacing="0"> '; 
		$t.='<tr class="rowtitle">
				<th width="5%" style="padding-left:15px;"> Sno# </th>
				<th width="18%"><b>Title</b></th>
				<th width="5%"><b>Order</b></th>
				<th width="10%"><b>action</b></th>
			</tr>';
			
	

$counter = 0;
$srn = 0;
if($num > 0){	
while($row = mysql_fetch_array($query_sel))
{
	$counter++;
	$srn++;
	if($row['status']==1)
	{
		$status="Active";
		$status1=0;
	}
	else if($row['status']==0)
	{
		$status="Inactive";
		$status1=1;
	}
	
	if ($counter % 2 == 0)
	{
	
		$bgcolor = "#FFFFFF";
	}
	else
	{
		$bgcolor = "#F5F7D9";
	}

	$t.='<tr><td class="tdborder"  style="padding-left:15px;" bgcolor="'.$bgcolor.'">'.$srn.'</td>
		  <td class="tdborder" bgcolor="'.$bgcolor.'">'.stripslashes($row["title"]).'</td>
		    <td class="tdborder" bgcolor="'.$bgcolor.'">'.$row["orderby"].'</td>				  
		  <td class="tdborder" bgcolor="'.$bgcolor.'">';
	if($status1 == 0){	
		$t.='<a href="home.php?p=savearticls&mod='.$mod.'&action=changesub&pid='.$_GET['id'].'&status='.$status1.'&id='.$row['id'].'" ><img src="img/icon_terms.gif" width="16" height="16" border="0"   style="cursor:pointer;" title="'.$status.'" /></a> ';
	}else{
		$t.='<a href="home.php?p=savearticls&mod='.$mod.'&action=changesub&pid='.$_GET['id'].'&status='.$status1.'&id='.$row['id'].'" ><img src="img/icon_terms_2.gif" width="16" height="16" border="0"   style="cursor:pointer;" title="'.$status.'" /></a> ';
	}
	$t.='<img src="img/icon_info.gif" width="16" height="16" style="cursor:pointer;" title="View Sub Pages" onclick="window.location=\'home.php?mod='.$mod.'&p=subpages&id='.$row["id"].'\';" />&nbsp;';
	$t.='<img src="img/edit.jpg" width="16" height="16" style="cursor:pointer;" title="Edit " onclick="window.location=\'home.php?mod='.$mod.'&p=editarticles&pid='.$_GET['id'].'&id='.$row["id"].'\';" />&nbsp;';
	$t.='<img src="img/delete.jpg" width="16" height="16" title="Delete " onclick="var tmp=confirm(\'This will Delete Page. Are you sure!\'); if (tmp) {	window.location=\'home.php?mod='.$mod.'&p=updatearticles&a=d&pid='.$_GET['id'].'&id='.$row["id"].'\';}" style="cursor:pointer;" />';
		
		$t.='
		</td>	

		</tr>';


		
		$x++;
} 
}else {
	$t.='<tr>
		  <td colspan="4" align="center" height="35" style="color:red" >
			 No Sub-Pages Found.
		  </td>
 		</tr>';	
	}
		$t.='</table>

		</td>
	</tr>

</table>
';

echo $t;
?> <div align="center"> <?php if($numrows >$rows_per_page)
	{
			if ($pageno == 1) 
			{
				echo " FIRST PREV ";
			} 
			else 
			{
				echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=subpages&pageno=1&id=$id'>FIRST</a> ";
				$prevpage = $pageno-1;
				echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=subpages&pageno=$prevpage&id=$id'>PREV</a> ";
			} 
			echo " ( Page $pageno of $lastpage ) ";
			if ($pageno == $lastpage) 
			{
				echo " NEXT LAST ";
			} 
			else 
			{
			$nextpage = $pageno+1;
			echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=subpages&pageno=$nextpage&id=$id'>NEXT</a> ";
			echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=subpages&pageno=$lastpage&id=$id'>LAST</a> ";
			}
	}
				

?>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </div> 