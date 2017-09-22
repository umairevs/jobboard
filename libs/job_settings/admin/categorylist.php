<?php
//Check access of module
include("security_module.php");
if($_POST['sort'])
 { 
	$count_ids=count($_POST['category_ids']); 												
	for($i=0; $i<$count_ids; $i++)
 {   
	$cat_ids= trim($_POST['category_ids'][$i]); 
	$sortvalues= trim($_POST['sortorders'][$i]); 
	$sql_sort=mysql_query("update  tbl_categories set sortorder = '".$sortvalues."'	where category_id=$cat_ids");
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
include("../includes/functions/funcatlist.php");
//echo $_SESSION['msg']; exit;
?>

<table  width="100%" border="0" align="center" cellpadding="0"  cellspacing="0" id="maintable" class="borderclass">
  <tr>
    <td width="100%" valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="top-bar"><div style="float:left">
          <?php if(isset($_GET['parent'])){ echo "Manage Sub Categories";}else{echo "Manage Parent Categories";}?></div>
            <div style="width:300px; float:left; border:0; padding-left:150px;" class="msg">
              <?php if( isset ($_SESSION['msg'])) { echo $_SESSION['msg']; unset ($_SESSION['msg'] ); }?>
            </div>
            <div style="float:right; padding-right:20px;">Add New  Categories&nbsp; <img src="img/new_faq_class.png"  border="0" 
			onClick="window.location='home.php?p=addcategory&mod=<?php echo $mod;?>'" alt="" title="Add Category" style="cursor:pointer;" /></div></td>
        </tr>
        <tr>
          <td colspan="3" align="center" id="errormsg"></td>
        </tr>
        
        
        <tr>
          <td colspan="3" align="center" valign="top"><!--home.php?p=categorylist-->
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="grid" >
              <tr>
                <td colspan="7" style="padding-right:5px; text-align:right; background-color:#ffffff;">

                <form name="catlist" action="" method="post">
                 <?php
                  if($_REQUEST['parent']!='')
				  {
				  ?>
                    <select name="filter" onChange="gotolink(this.value);" style="width:300px;">
                      <option value="0" >Parent</option>
                      <?php 			
			$queryselopt="select * from tbl_categories where parent_id=0  order by  sortorder asc";
			$arrselopt = $db->get_results($queryselopt,ARRAY_A);
			if(isset($arrselopt))
			{
			foreach($arrselopt as $rowselopt)
			{
			if($_GET['parent'] == $rowselopt['category_id'])
			{
			echo '<option value="'.$rowselopt[category_id].'" selected="selected" >'.$rowselopt[category_name].'&nbsp;&nbsp;</option>';
			}
			else
			{
			echo '<option value="'.$rowselopt['category_id'].'" >'.$rowselopt['category_name'].'&nbsp;&nbsp;</option>';
			
			}
			//echo categorylist($rowselopt[category_id]);
			}
			}
			?>
                    </select>
                    <?php
					}
			 ?>
                  </form></td>
              </tr>
              <!-- <tr class="rowtitle">-->
              <tr>
                <th width="4%" align="center">S#</th>
				<?php
                  if($_REQUEST['parent']=='')
				  {
				  ?><th width="15%">Image</th>
                  <?php
				  }
				  ?>
                <th width="40%" align="left"><?php if(isset($_GET['parent'])){ echo "Sub Categories";}else{echo "Parent Categories";}?></th>
                <th width="15%">Sorting Order</th>
                <!--<td width="20%">Category Type</td>-->
                <th width="15%"><div align="center">Action</div></th>
              </tr>
              <form name="sortings" action="" method="post">
                <?php 
   if(isset($_SESSION['parent']))
	{
	$querypaging="select count(*) as COUNT from tbl_categories  where  parent_id=".$_SESSION['parent'];
    }
	elseif($filter >= 1)
	{
	$querypaging="select count(*) as COUNT from tbl_categories  where  parent_id=".$filter;
	}
	elseif($filter==0 && $search=="")
	{
	$querypaging="select count(*) as COUNT  from tbl_categories where parent_id=0  ";
	}
	elseif($search!="")
	{
	$query="select count(*) as COUNT  from tbl_categories  where category_name like '%$search%'  ";
	}
	else
	{
	$querypaging="select count(*) as COUNT  from tbl_categories  where parent_id=0   order by  sortorder asc";
	}

	$query_data = $db->get_row($querypaging,ARRAY_A);
	$numrows = $query_data[COUNT];  
	$rows_per_page = 50;
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
			$query_paging="select * from tbl_categories  where parent_id='".$_SESSION['parent']."' ";
			$querycatlist="select * from tbl_categories  where parent_id='".$_SESSION['parent']."'  order by sortorder asc $limit";
			}
			elseif($filter >= 1)
			{
			$querycatlist="select * from tbl_categories  where parent_id=$filter  order by sortorder asc $limit";
			$query_paging="select * from tbl_categories where parent_id=$filter ";
			}
			else if(isset($_GET['parent']))
			{
			$querycatlist="select * from tbl_categories  where parent_id='".$_GET['parent']."'  order by sortorder asc $limit";
			$query_paging="select * from tbl_categories where parent_id='".$_GET['parent']."' ";
			}
			else
			{
			$querycatlist="select * from tbl_categories  where parent_id=0  order by  sortorder asc $limit";
			$query_paging="select * from tbl_categories where parent_id=0  order by  sortorder asc";
			}
			$counter=0;
			$rowcatlist=$db->get_results($querycatlist,ARRAY_A);
			if(isset($rowcatlist)){
			foreach($rowcatlist as $catlist)
			{
			$counter++;
			$bgcolor = ($bgcolor == 'class="colortr"')?'class="colortr2"':'class="colortr"';
			
			if(!empty($catlist['category_image'])){
				$cat_image = $catlist['category_image'];
			}else{
				$cat_image = 'default.png';
			}
			?>
                <tr <?php echo $bgcolor;?>>
                  <td style="padding-left:10px;" align="center"><?php echo $counter;?> </td>
				  <?php
                  if($_REQUEST['parent']=='')
				  {
				  ?><td><img src="../media/category/<?php echo $cat_image; ?>" style="width:50px;"/></td>
                  <?php
				  }
				  ?>
                  <td align="left" >
                  <a href="home.php?p=categorylist&mod=<?php echo $mod;?>&ctype=<?php echo $catlist[category_name];?>&parent=<?php echo $catlist[category_id];?>" alt="" title="Edit" /><?php  echo stripslashes($catlist[category_name]); ?></a></td>
                  <td><input type="text" name="sortorders[]" value="<?php echo stripslashes($catlist[sortorder]);?>" style="width:75px"  />
                    <input type="hidden" name="category_ids[]" value="<?php echo stripslashes($catlist[category_id]);?>"  />
                  </td>
                  <td><div align="center">
                      <?php $status=stripslashes($catlist[active_status]);
			if($status=="1")
			{
			echo "<a href='home.php?p=process&mod=$mod&chstatus=0&catidchg=$catlist[category_id]&amp;&filter=$filter'><img src='img/icon_terms.gif' width='16' height='16' border='0' title='Status change' alt='Active'></a>";
			}
			else
			{
			echo "<a href='home.php?p=process&mod=$mod&chstatus=1&catidchg=$catlist[category_id]&amp;&filter=$filter'><img src='img/icon_terms_2.gif' width='16' height='16' border='0' title='Status change' alt='Inactive'></a>";
			}
			?>
            
                      <a href="home.php?p=addcategory&ctype=<?php echo stripslashes($catlist['category_name']); ?>&mod=<?php echo $mod;?>&editid=<?php echo base64_encode($catlist[category_id]);?>" alt="" title="Edit Parent Category" /> <img src="img/edit.jpg" width="16" height="16" border="0" alt="Edit Parent Category"></a> 
                   </div></td>
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
                  <td colspan="5" align="center"  class="msg"  style="text-align:center">No Company Found.</td>
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
			echo "FIRST PREV";
			} 
			else 
			{
			echo " <a href='{$_SERVER['PHP_SELF']}?p=categorylist&mod=$mod&pageno=1&filter=$filter'>FIRST</a> ";
			$prevpage = $pageno-1;
			echo " <a href='{$_SERVER['PHP_SELF']}?p=categorylist&mod=$mod&pageno=$prevpage&filter=$filter'>PREV</a> ";
			} 
			//........
			echo " ( Page $pageno of $lastpage ) ";
			//....................
			if ($pageno == $lastpage) {
			echo " NEXT LAST ";
			} else {
			$nextpage = $pageno+1;
			echo " <a href='{$_SERVER['PHP_SELF']}?p=categorylist&mod=$mod&pageno=$nextpage&filter=$filter'>NEXT</a> ";
			echo " <a href='{$_SERVER['PHP_SELF']}?p=categorylist&mod=$mod&pageno=$lastpage&filter=$filter'>LAST</a> ";
			}
			}
			unset($_SESSION['msg']);
			?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td style=" border-bottom:1px solid #FFFFFF;"></td>
    <td valign="top" style=" border-bottom:1px solid #FFFFFF;"></td>
  </tr>
</table>
<script type="text/javascript">
	function gotolink(val)
	{
		window.location.href = "home.php?p=categorylist&mod=job_settings&parent="+val;
	}	
</script>