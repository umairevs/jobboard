<?php
	defined('_JEVS') or die('Restricted access');
	if($_POST['sort'])
	{
		$count_ids=count($_POST['emp_ids']); 												
		for($i=0; $i<$count_ids; $i++)
		{   
			$cat_ids= trim($_POST['emp_ids'][$i]); 
			$sortvalues= trim($_POST['sortorders'][$i]); 
			$sql_sort=mysql_query("update  tbl_emp_type set sortorder = '".$sortvalues."'	where emp_id=$cat_ids");
			if($sql_sort)
			{					
				$_SESSION['msg']="Sorting order saved successfully";
			}
		}     
	}

	foreach($_POST  as $key => $value)
	{
		$$key = $value;
	}
	foreach($_GET as $key => $value)
	{
		$$key = $value;
	}

?>

<table  width="100%" border="0" align="center" cellpadding="0"  cellspacing="0" id="maintable" class="borderclass">
	<tr>
		<td width="100%" valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="top-bar"><div style="float:left">Employment Type</div>
						<div style="width:300px; float:left; border:0; padding-left:150px;" class="msg">
							<?php if( isset ($_SESSION['msg'])) { echo $_SESSION['msg']; unset ($_SESSION['msg'] ); }?>
						</div>
						<div style="float:right; padding-right:20px;">Add New&nbsp; <img src="img/new_faq_class.png"  border="0" 
			onClick="window.location='home.php?p=addsalary_type&mod=<?php echo $mod;?>'" alt="" title="Add New" style="cursor:pointer;" /></div></td>
				</tr>
				<tr>
					<td colspan="3" align="center" id="errormsg"></td>
				</tr>
				<tr>
					<td colspan="3" align="center" valign="top"><!--home.php?p=categorylist-->
						
						<table cellpadding="0" cellspacing="0" border="0" width="100%" class="grid" >
							
							<!-- <tr class="rowtitle">-->
							<tr>
								<th width="4%" align="center">S#</th>
								<th width="30%" align="left">Title</th>
								<th width="43%">Sorting Order</th>
								<th width="23%"><div align="center">Action</div></th>
							</tr>
							<form name="sortings" action="" method="post">
								<?php 
								   if(isset($_SESSION['parent']))
									{
									$querypaging="select count(*) as COUNT from tbl_emp_type ";
									}
									elseif($filter >= 1)
									{
									$querypaging="select count(*) as COUNT from tbl_emp_type ";
									}
									elseif($filter==0 && $search=="")
									{
									$querypaging="select count(*) as COUNT  from tbl_emp_type ";
									}
									elseif($search!="")
									{
									$query="select count(*) as COUNT  from tbl_emp_type  where salary_title like '%$search%' ";
									}
									else
									{
									$querypaging="select count(*) as COUNT  from tbl_emp_type  order by  sortorder asc";
									}
								
									$query_data = $db->get_row($querypaging,ARRAY_A);
									$numrows = $query_data[COUNT];  
									$rows_per_page = 100;
									$lastpage= ceil($numrows/$rows_per_page);
									$pageno = (int)$_GET['pageno'];
						
									if ($pageno < 1) 
									  {
									   $pageno = 1;
									  } 
									elseif ($pageno > $lastpage)
									{
									 $pageno = $lastpage;
									}  
								if($numrows==0)
									{
									$limit = 'LIMIT ' .($pageno).',' .$rows_per_page;
									$i=$pageno+1;
									}
								else
									{
									$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
									$i=$rows_per_page*($pageno - 1);
									}
									//*************************************************************************	   
									if(isset($_SESSION['parent']))							   
									{
									$query_paging="select * from tbl_emp_type  ";
									$querycatlist="select * from tbl_emp_type  order by sortorder asc $limit";
									}
									elseif($filter >= 1)
									{
									$querycatlist="select * from tbl_emp_type order by sortorder asc $limit";
									$query_paging="select * from tbl_emp_type ";
									}
									else if(isset($_GET['parent']))
									{
									$querycatlist="select * from tbl_emp_type  order by sortorder asc $limit";
									$query_paging="select * from tbl_emp_type ";
									}
									else
									{
									$querycatlist="select * from tbl_emp_type  order by  sortorder asc $limit";
									$query_paging="select * from tbl_emp_type order by  sortorder asc";
									}
									//echo $querycatlist;
									$counter=0;
									$rowcatlist=$db->get_results($querycatlist,ARRAY_A);
									if(isset($rowcatlist)){
									foreach($rowcatlist as $catlist)
									{
									$counter++;
									$bgcolor = ($bgcolor == 'class="colortr"')?'class="colortr2"':'class="colortr"';
									?>
								<tr <?php echo $bgcolor;?>>
									<td style="padding-left:10px;" align="center"><?php echo $counter;?></td>
									<td align="left" ><?php  echo stripslashes($catlist[emp_title]); ?></td>
									<td><input type="text" name="sortorders[]" value="<?php echo stripslashes($catlist[sortorder]);?>" style="width:75px"  />
										<input type="hidden" name="emp_ids[]" value="<?php echo stripslashes($catlist[emp_id]);?>"  /></td>
									<td><div align="center">
										<?php $status=stripslashes($catlist[status]);
										if($status=="1")
										{
										echo "<a href='home.php?p=process_salary&mod=$mod&chstatus=0&catidchg=$catlist[emp_id]&amp;&filter=$filter'><img src='img/icon_terms.gif' width='16' height='16' border='0' title='Status change' alt='Active'></a>";
										}
										else
										{
										echo "<a href='home.php?p=process_salary&mod=$mod&chstatus=1&catidchg=$catlist[emp_id]&amp;&filter=$filter'><img src='img/icon_terms_2.gif' width='16' height='16' border='0' title='Status change' alt='Inactive'></a>";
										}
										?>
											<a  href="home.php?p=addsalary_type&mod=<?php echo $mod;?>&editid=<?php echo base64_encode($catlist[emp_id]);?>" alt="" title="Edit" /> <img src="img/edit.jpg" width="16" height="16" border="0" alt="Edit"></a> 
                                            <a style="display:none;" href="home.php?p=process_salary&mod=<?php echo $mod;?>&action=del&cId=<?php echo $catlist['emp_id']?>" onClick="return confirm('Are you realy want to delete this record?')"> <img src="img/delete.jpg" width="16" height="16" border="0" title="Delete" alt="Delete"> </a> </div></td>
								</tr>
								<?php 
								unset($_SESSION['parent']);
								} 
								?>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td><input type="hidden" name="sort"  value="sort"  />
										<input type="submit" name="sort"  value="Sort" style="width:81px; margin-left:-2px;"/></td>
									<td>&nbsp;</td>
								</tr>
								<?php
			}
			else {?>
								<tr>
									<td colspan="4" align="center"  class="msg"  style="text-align:center">No Category Found.</td>
								</tr>
								<?php } ?>
							</form>
						</table>
				<tr>
					<td colspan="3" align="center" style=" border-bottom:1px solid #FFFFFF;" ><?php
			$rec_cats = mysql_query($query_paging);
			if(mysql_num_rows($rec_cats) >= $rows_per_page)
			{
			if ($pageno == 1) 
			{
			echo " FIRST PREV ";
			} 
			else 
			{
			echo " <a href='{$_SERVER['PHP_SELF']}?p=salary_type&mod=$mod&pageno=1&filter=$filter'>FIRST</a> ";
			$prevpage = $pageno-1;
			echo " <a href='{$_SERVER['PHP_SELF']}?p=salary_type&mod=$mod&pageno=$prevpage&filter=$filter'>PREV</a> ";
			} 
			//........
			echo " ( Page $pageno of $lastpage ) ";
			//....................
			if ($pageno == $lastpage) {
			echo " NEXT LAST ";
			} else {
			$nextpage = $pageno+1;
			echo " <a href='{$_SERVER['PHP_SELF']}?p=salary_type&mod=$mod&pageno=$nextpage&filter=$filter'>NEXT</a> ";
			echo " <a href='{$_SERVER['PHP_SELF']}?p=salary_type&mod=$mod&pageno=$lastpage&filter=$filter'>LAST</a> ";
			}
			}
			unset($_SESSION['msg']);
			?></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td style=" border-bottom:1px solid #FFFFFF;"></td>
		<td valign="top" style=" border-bottom:1px solid #FFFFFF;"></td>
	</tr>
</table>
