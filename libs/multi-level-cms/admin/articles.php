<?php
  defined('_JEVS') or die('Restricted access');
 //-----------------------------------------------------------------------------------
   // this will create two tables(if not exist) t
   createTable('multiLevelCms');
//-----------------------------------------------------------------------------------
			  // pagination 2 of 3 
			$query = "SELECT count(*) as COUNT from tbl_articles WHERE parent = '0'  ORDER BY `tbl_articles`.`orderby` ASC ";
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
$t .= '<table width="100%" ><tr><td class="top-bar">
<div style="float:left; width:98%"><div style="float:left; width:250px">Page Management</div>';  
if(isset($_SESSION['msg']))
 {
 	//style="width:300px; color:#99CC66; float:left; margin-left:50px;"
	$t .='<div class="message" > ' .$_SESSION['msg'].'</div>';
    unset($_SESSION['msg']);
}
$t .='<div style="float:right"> </a></div>';
$t .='</div> </td></tr>';

$t.='</table>';

$t.='<table cellpadding="0" cellspacing="0" id="vtop" width="100%">

	
		
	<tr>
		<td>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="grid"> '; 
	
		$t .='<tr >
				<th width="5%" style="padding-left:15px;"> # </th>
				<th width="22%"><b>Title</b></th>
				<th width="6%"><b>Action</b></th>
			</tr>';	
	$counter = 0;
	if($pageno == 1)
	{
		$srn = 0;
	}
	else
	{
		$srn = (($pageno -1) * $rows_per_page);
	}
	
	$sql = "SELECT id, title, orderby,status  FROM `tbl_articles` WHERE parent = '0' ORDER BY `tbl_articles`.`orderby` ASC $limit  ";
	$query_sel = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($query_sel))
	{
		$counter++;
		$srn++;

		if ($counter % 2 == 0)
		{

			$bgcolor = "";
		}
		else
		{
					$bgcolor = "";
		}

	$t.='<tr><td   style="padding-left:8px;text-align:center" bgcolor="'.$bgcolor.'">'.$srn.'</td>
		  <td  bgcolor="'.$bgcolor.'">'.stripslashes($row["title"]).'</td>
		     
		  <td  align="center" bgcolor="'.$bgcolor.'">';
		

	//$t.='<img src="img/icon_info.gif" width="16" height="16"  style="cursor:pointer;" title="View Sub Pages" onclick="window.location=\'home.php?mod='.$mod.'&p=subpages&id='.$row["id"].'\';" />&nbsp;';
	$t.='<img src="img/edit.jpg" width="16" height="16" style="cursor:pointer;" title="Edit " onclick="window.location=\'home.php?mod='.$mod.'&p=editarticles&id='.$row["id"].'\';" />&nbsp;';
	//$t.='<img src="img/delete.jpg"  width="16" height="16" title="Delete " onclick="var tmp=confirm(\'This will Delete Article. Are you sure!\'); if (tmp) {	window.location=\'home.php?mod='.$mod.'&p=updatearticles&a=d&id='.$row["id"].'\';}" style="cursor:pointer;" />';
		
		$t.='
		</td>	

		</tr>';


		
		$x++;
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
				echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=articles&pageno=1'>FIRST</a> ";
				$prevpage = $pageno-1;
				echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=articles&pageno=$prevpage'>PREV</a> ";
			} 
			echo " ( Page $pageno of $lastpage ) ";
			if ($pageno == $lastpage) 
			{
				echo " NEXT LAST ";
			} 
			else 
			{
			$nextpage = $pageno+1;
			echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=articles&pageno=$nextpage'>NEXT</a> ";
			echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=articles&pageno=$lastpage'>LAST</a> ";
			}
	}
				

?>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </div> 
