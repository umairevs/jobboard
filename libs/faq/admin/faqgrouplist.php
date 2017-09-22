<?php
defined('_JEVS') or die('Restricted access');
if($_POST['sort'])
 {
 	$count_ids=count($_POST['faqgroup_ids']);
	for($i=0; $i<$count_ids; $i++)
 {   
	 $cat_ids= trim($_POST['faqgroup_ids'][$i]); 
	 $sortvalues= trim($_POST['srtorder'][$i]); 
	 $sql_sort=mysql_query("update  tbl_faq_groups set
	 sortorder = '".$sortvalues."'
	 where faqg_id=$cat_ids");
if($sql_sort)
 {					
	$_SESSION['msg']= "Sorting order saved successfully";
 }
 else
  {
  	$_SESSION['msg'] ='';
  }
 }     
 }
?>

          <table cellpadding="2" cellspacing="0" border="0" width="100%" id="internaltable" >
           <tr>
			<td class="top-bar" bordercolor="#F5F7D9" width="100%">
			<div style="float:left">FAQ Groups</div>
			<div style="width:300px; color:#CC0000; float:left; padding-left:150px;"> 
			<?php if(isset($_SESSION['msg'])) {echo $_SESSION['msg']; unset($_SESSION['msg']);} ?>
			</div> <div style="float:right"> Add New Group
			    <img src="img/new_faq_class.png" border="0" 
				onClick="window.location='home.php?mod=<?php echo $mod;?>&p=newfaqgroup'" alt="" title="Add Groups" /> </div> </td>
			 
		  </tr>
         	<tr>
              <td colspan="4" align="center">
			  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="grid">
                  <tr class="rowtitle">
                    <th width="11%" style="padding-left:10px;">Sr.#</th>
                    <th width="50%" style="padding-right:200px;">Group Name</th>
                    <th width="26%" style="padding-right:100px;">Sorting Order</th>
                   
                    <th width="13%">Action</th>
                  </tr>
               <form name="faqgroup" action="" method="post">
                  <?php 
						       	  // pagination 2 of 3 
								  $query = "SELECT count(*) as COUNT from tbl_faq_groups  order by sortorder";
								  $query_data = $db->get_row($query,ARRAY_A);
								  $numrows = $query_data[COUNT];  
								   $rows_per_page = 30;
								   $lastpage= ceil($numrows/$rows_per_page);
								   $pageno = (int)$pageno;
								 if ($pageno < 1) {
								   $pageno = 1;
								 } elseif ($pageno > $lastpage) {
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
					  
							   $queryfaqgroup="select * from tbl_faq_groups order by sortorder $limit";
							   $rowfaqgroup=$db->get_results($queryfaqgroup,ARRAY_A);
							   $counter=0;
								if(isset($rowfaqgroup))
								{
								foreach($rowfaqgroup as $arrfaqgroup)
								{									
									$counter++;	
									$bgcolor = ($bgcolor == 'class="colortr"')?'class="colortr2"':'class="colortr"';							
						?>
                 <tr <?php echo $bgcolor;?>>
                    <td style="padding-left:10px;"><?php echo $counter;?> </td>
                    <td><?php  echo stripslashes($arrfaqgroup[group_title]); 
										
								
								?></td>
                    <td>
					<input type="text" name="srtorder[]<?php //echo $arrfaqgroup[faqg_id];?>" class="txtstyle" value="<?php echo $arrfaqgroup[sortorder];?>"  />
					<input type="hidden" name="faqgroup_ids[]" value="<?php echo $arrfaqgroup['faqg_id'];?>"  />                    </td>
                    <td>
					<?php $status=$arrfaqgroup[group_status];
									if($status=="1")
									{
										echo "<a href='home.php?mod=".$mod."&p=faqoperations&st=0&faqgroupid=$arrfaqgroup[faqg_id]'><img src='img/icon_terms.gif' width='16' height='16' border='0' alt='Inactive'></a>";
									}
										else
									{	
									 	echo "<a href='home.php?mod=".$mod."&p=faqoperations&st=1&faqgroupid=$arrfaqgroup[faqg_id]'><img src='img/icon_terms_2.gif' width='16' height='16' border='0' alt='Active'></a>";
									}
							 ?>                    
						<img src="img/edit.jpg" width="18" height="18" border="0" 
						onClick="window.location='home.php?mod=<?php echo $mod;?>&p=newfaqgroup&editidgroup=<?php echo  base64_encode($arrfaqgroup[faqg_id]);?>'" alt="" title="Edit FAQ Groups" /> 
						<a href="home.php?mod=<?php echo $mod;?>&p=faqoperations&delid=<?php echo $arrfaqgroup[faqg_id]; ?>" onClick="return confirm('It will delete all questions under this group .Are you sure you want to delete a record?')"> <img src="img/delete.jpg" width="16" height="16" border="0"  /> </a>						</td>
						</tr>
                  <?php 
						
						}  ?>
						
                  
				   <tr>
							 <td>&nbsp;   </td>
							  <td>&nbsp;   </td>
							<td >
							<input type="hidden" name="sort"  value="sort"  />
							<input type="submit" name="sort2"  value="Sort" style="width:81px; margin-left:-2px;"/></td>
							<td>&nbsp;   </td>
							  <td width="0%">&nbsp;   </td>
				 </tr>
							
					<?php }else{?>	
						
						<tr> <td colspan="5" class="msg" align="center"> No FAQ Group Found </td>
						<?php } ?> 	
							</form>
				  
                 
					<input type="hidden" name="limit" id="limit" value="<?php $limit;?>" />
				</table>
			  <div align="center">
					<?php
									//pagination 3 of 3
									if($numrows >$rows_per_page)
									{
									if ($pageno == 1) {
									   echo " FIRST PREV ";
									} else {
									   echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqgrouplist&pageno=1'>FIRST</a> ";
									   $prevpage = $pageno-1;
									   echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqgrouplist&pageno=$prevpage'>PREV</a> ";
									} 
									//........
									echo " ( Page $pageno of $lastpage ) ";
									
									//....................
									if ($pageno == $lastpage) {
									   echo " NEXT LAST ";
									} else {
									   $nextpage = $pageno+1;
									   echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqgrouplist&pageno=$nextpage'>NEXT</a> ";
									   echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqgrouplist&pageno=$lastpage'>LAST</a> ";
									  
									
									}
									}
								
						
							 ?>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" align="center" id="errormsg">
              </td>
            </tr>
          </table>
        