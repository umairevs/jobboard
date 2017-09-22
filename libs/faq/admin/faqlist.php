<?php
    defined('_JEVS') or die('Restricted access');
	createTable('faq'); // create table if not exist;
	if($_POST['sort'])
 {
 	$count_ids=count($_POST['faqgroup_ids']);
	for($i=0; $i<$count_ids; $i++)
 {   
	 $cat_ids= trim($_POST['faqgroup_ids'][$i]); 
	 $sortvalues= trim($_POST['srtorder'][$i]);
	
	 $sql_sort=mysql_query("update tbl_faq set
	 sortorder = '".$sortvalues."'
	 where faq_id=$cat_ids");
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

<table cellpadding="0" cellspacing="0" border="0" width="100%" id="internaltable">
		 <tr>
			<td class="top-bar"><div style=" float:left">FAQ List</div>
			 <div  class="message"> 
			 <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']);}?>
			</div>
			<div style="float:right"> Add New FAQ
			    <img src="img/new_faq_class.png" border="0" 
				onClick="window.location='home.php?mod=<?php echo $mod;?>&p=newfaq'" alt="" style="cursor:pointer" title="Add New FAQ" /> </div>
			</td>
			
		  </tr>
			
			<tr>
				<td colspan="4" align="center">
					
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="grid">
						
					<tr class="rowtitle">
						<th width="8%" style="padding-left:10px;">S#</th>
						<th width="54%" style="padding-right:220px;">Question</th>
						<th width="26%" style="padding-right:20px;">Sorting Order</th>			
						<th width="14%" style="padding-right:40px;">Action</th>				
					</tr>
					
						 <form name="faqlist" action="" method="post">
						<?php  
						 
								// pagination 2 of 3 
								  $query = "SELECT count(*) as COUNT from tbl_faq  order by faq_id desc";
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
					  
							   $queryfaq="select * from tbl_faq order by faq_id $limit";
							   $rowfaq=$db->get_results($queryfaq,ARRAY_A);
							   $counter=0;
								if(isset($rowfaq))
								{
								foreach($rowfaq as $arrfaq)
								{	
									$counter++;	
									$bgcolor = ($bgcolor == 'class="colortr"')?'class="colortr2"':'class="colortr"';							
									$querymugp="select * from tbl_faq_groups where faqg_id=$arrfaq[faq_groupid]";
									$rowmugp=$db->get_row($querymugp,ARRAY_A);
									
						?>
						<tr <?php echo $bgcolor;?>>
							<td style="padding-left:15px;">
								<?php echo $counter;?>							</td>
							<td style="padding-left:10px;">
								<?php  echo stripslashes($arrfaq[faq_question]); 
										
								
								?>							</td>
							<td style="padding-left:10px;">
                            <input type="text" name="srtorder[]<?php //echo $arrfaqgroup[faqg_id];?>" class="txtstyle" value="<?php echo $arrfaq['sortorder'];?>"  />
					<input type="hidden" name="faqgroup_ids[]" value="<?php echo $arrfaq['faq_id'];?>"  />                            </td>
                            
                            
							<td style="padding-left:10px;">
							<?php $status=$arrfaq[faq_status];
									if($status=="1")
									{
										echo "<a href='".$ruAdmin."home.php?mod=$mod&p=faqoperations&chstatus=0&faqid=$arrfaq[faq_id]'><img src='img/icon_terms.gif' width='16' height='16' border='0' alt='Inactive'></a>";
									}
									else
									{	
									  echo "<a href='".$ruAdmin."home.php?mod=$mod&p=faqoperations&chstatus=1&faqid=$arrfaq[faq_id]'><img src='img/icon_terms_2.gif' width='16' height='16' border='0' alt='Active'></a>";
									} 
							 ?>
							
							
					<a href="home.php?mod=<?php echo $mod;?>&p=newfaq&editid=<?php echo $arrfaq[faq_id]?>"	>	
				           <img src="img/edit.jpg" width="18" height="18" border="0"  alt="" title="Edit"> </a>
			<a href="home.php?mod=<?php echo $mod;?>&p=faqoperations&deletepage=<?php echo $arrfaq[faq_id]?>" onClick="return confirm('Are you sure you want to delete this question?')">
							<img src="img/delete.jpg" width="16" height="16" border="0" alt="" title="Delete"></a>	</td>
						</tr>
                        
						<?php 
						
						}
						?>
						
                  
				   <tr>
							 <td>&nbsp;   </td>
							  <td>&nbsp;   </td>
							<td><input type="submit" name="sort"  value="sort" style="width:81px; margin-left:-2px;"/></td>
							  <td width="0%">&nbsp;   </td>
				 </tr>
							
					<?php
						}
						
						
						
						 else{ ?>
						<tr> <td colspan="4" class="msg" align="center"> No Question Found </td>
							
						<?php } ?>
                        </form>
					</table>
<div align="center">
								<?php
									//pagination 3 of 3
							if($numrows >$rows_per_page)
							{
								if ($pageno == 1) 
								{
									echo " FIRST PREV ";
								} 
								else 
								{
									echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqlist&pageno=1'>FIRST</a> ";
									$prevpage = $pageno-1;
									echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqlist&pageno=$prevpage'>PREV</a> ";
								} 
							//........
								echo " ( Page $pageno of $lastpage ) ";
							
							//....................
								if ($pageno == $lastpage) 
								{
									echo " NEXT LAST ";
								
								} 
								else 
								{
								$nextpage = $pageno+1;
								echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqlist&pageno=$nextpage'>NEXT</a> ";
								echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=faqlist&pageno=$lastpage'>LAST</a> ";
							
							
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