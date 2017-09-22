<?php
//Check access of module
include("security_module.php");
	foreach($_POST  as $key => $value)
	{
		$$key = $value;
	}
	foreach($_GET as $key => $value)
	{
		$$key = $value;
	}	
	
if($_REQUEST['doSearch']=='Search')
{
								
	$where_condition = '';
	
	if($_REQUEST['city']!='')
	{
		$_SESSION['searchby']['city'] =  $_REQUEST['city'];
		$where_condition  .=  " AND City like '%".addslashes($_REQUEST['city'])."%'";
	}
	else
	{
		$_SESSION['searchby']['city'] = '';
	}
	
	
	$_SESSION['city_user_session'] = $where_condition;
	
}elseif($_REQUEST['res']=='Reset'){
	$_SESSION['city_user_session'] = "";
	$_SESSION['searchby']['city']="";
}	
?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" id="internaltable">
		 <tr>
			<td class="top-bar"><div style=" float:left">States management</div>
			 <div  class="message"> 
			 <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']);}?>
			</div>
			
            <div style="float:right"> Add New

                <img src="img/new_faq_class.png"  border="0" 
			onClick="window.location='home.php?p=addedit_city&mod=<?php echo $mod;?>'" alt="" title="Add New" style="cursor:pointer;" />
                 </div>
			
            </td>
			
		  </tr>
			<tr style="display:block;">
	<td colspan="4" align="right" class="rowtitle"><form method="post" action="">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td style="font-size:10px;color:#666666;font-weight:600;border:1px solid #F8F8F8; padding:4px;" colspan="7"> Search by  :
							<input type="text"  class="topsearch input_fld_whole" name="city" size="25" value="<?php echo $_SESSION['searchby']['city'];?>" placeholder="City name">
							 
							<input type="submit" class="searchbtn" value="Search" name="doSearch">
							<input type="submit" class="searchbtn" value="Reset" name="res"></td>
					</tr>
					<tr>
						<td colspan="7"></td>
					</tr>
				</tbody>
			</table>
		</form></td>
</tr>
			<tr>
				<td colspan="4" align="center">
					
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="grid">
						
					<tr>
								<th width="2%" align="center">S#</th>
					  <th width="26%" style="text-align:left;">Country Name</th>
								<th width="25%" style="text-align:left;">State Name</th>
					            <th width="33%" style="text-align:left;">City Name</th>
		              <th width="14%"><div align="center">Action</div></th>
					  </tr>
					
						 <form name="gamelist" action="" method="post">
						<?php  
						 
							
					  
					  
					  			$rows_per_page = 50;
					  
								if(!isset($_GET['pageno']))
								{ 
								$pageno = 1; 
								} else { 
								$pageno = $_GET['pageno']; 
								} 
								
								$from = (($pageNo * $rows_per_page) - $rows_per_page);
								
								$querypaging="select count(*) as COUNT  from tbl_city where 1=1 ".$_SESSION['city_user_session']."     order by  CityId desc";
								$query_data = $db->get_row($querypaging,ARRAY_A);
								$numrows = $query_data[COUNT];  
								
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
								{
								$limit = 'LIMIT ' .($pageno).',' .$rows_per_page;
								$i=$pageno+1;
								}
								else
								{ 
								$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
								$i=$rows_per_page*($pageno - 1);
								}
					  
					  
					  
							   $queryfaq="select * from tbl_city where 1=1 ".$_SESSION['city_user_session']."  order by  CityId desc $limit";
							   $rowfaq=$db->get_results($queryfaq,ARRAY_A);
							  
							   $counter=0;
								if(isset($rowfaq))
								{
								foreach($rowfaq as $arrfaq)
								{	
									$counter++;	
									$bgcolor = ($bgcolor == 'class="colortr"')?'class="colortr2"':'class="colortr"';							
									
									$c_name = get_country(stripslashes($arrfaq[CountryID]));
									$r_name = get_state(stripslashes($arrfaq[RegionID]));
						?>		
				<tr <?php echo $bgcolor;?>>
									<td style="padding-left:10px;" align="center"><?php echo $counter;?></td>
									<td align="left" ><?php echo $c_name['Country'];?></td>
									<td align="left" ><?php echo utf8_encode($r_name['Region']);?></td>
									<td align="left" ><?php echo utf8_encode(stripslashes($arrfaq[City]));?></td>
									<td><div align="center">
										
                                      
                                       
                                    <?php $status=$arrfaq[status];
									if($status=="1")
									{
										echo "<a href='".$ruAdmin."home.php?mod=$mod&p=city_process&chstatus=0&CityId=$arrfaq[CityId]'><img src='img/icon_terms.gif' width='16' height='16' border='0' alt='Inactive'></a>";
									}
									else
									{	
									  echo "<a href='".$ruAdmin."home.php?mod=$mod&p=city_process&chstatus=1&CityId=$arrfaq[CityId]'><img src='img/icon_terms_2.gif' width='16' height='16' border='0' alt='Active'></a>";
									} 
							 ?>
                                            
                                       <a href="home.php?p=addedit_city&mod=<?php echo $mod;?>&editid=<?php echo base64_encode($arrfaq[CityId]);?>" alt="" title="Edit" /> <img src="img/edit.jpg" width="16" height="16" border="0" alt="Edit" style=""></a>
                                      

                                            <a style="display:none;" href="home.php?p=city_process&mod=<?php echo $mod;?>&action=deletepage&cId=<?php echo $arrfaq['CityId']?>" onClick="return confirm('Are you realy want to delete this record?')"> <img src="img/delete.jpg" width="16" height="16" border="0" title="Delete" alt="Delete" style=""> </a> 

                                            </div></td>
								</tr>
                        
						<?php 
						
						}
						?>
						
                  

							
					<?php
						}
						
						
						
						 else{ ?>
						<tr> <td colspan="5" class="msg" align="center"> No Record Found </td>
							
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
									echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=citylist&pageno=1'>FIRST</a> ";
									$prevpage = $pageno-1;
									echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=citylist&pageno=$prevpage'>PREV</a> ";
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
								echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=citylist&pageno=$nextpage'>NEXT</a> ";
								echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=citylist&pageno=$lastpage'>LAST</a> ";
							
							
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